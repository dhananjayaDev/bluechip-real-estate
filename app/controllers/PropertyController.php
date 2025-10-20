<?php
class PropertyController extends Controller {
    private $propertyModel;
    private $userModel;
    private $requestModel;
    
    public function __construct() {
        $this->propertyModel = new Property();
        $this->userModel = new User();
        $this->requestModel = new UserRequest();
    }
    
    public function index() {
        // Check if this is a search request (has filters)
        $hasFilters = !empty(array_filter($_GET));
        
        if ($hasFilters) {
            // Show search results
            $filters = [
                'search' => $_GET['search'] ?? '',
                'city' => $_GET['city'] ?? '',
                'property_type' => $_GET['property_type'] ?? '',
                'min_price' => $_GET['min_price'] ?? '',
                'max_price' => $_GET['max_price'] ?? '',
                'bedrooms' => $_GET['bedrooms'] ?? ''
            ];
            
            $page = (int)($_GET['page'] ?? 1);
            $properties = $this->propertyModel->search($filters, $page);
            $totalProperties = $this->propertyModel->getCount($filters);
            $totalPages = ceil($totalProperties / ITEMS_PER_PAGE);
            
            $this->view('properties/index', [
                'properties' => $properties,
                'filters' => $filters,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'totalProperties' => $totalProperties
            ]);
        } else {
            // Show home page
            $this->view('home', [
                'csrfToken' => $this->generateCSRF()
            ]);
        }
    }
    
    public function all() {
        // Show all properties page
        $this->view('all_properties', []);
    }
    
    public function show($id) {
        $property = $this->propertyModel->getWithImages($id);
        
        if (!$property) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }
        
        $similarProperties = $this->propertyModel->getSimilarProperties($id);
        $isFavorite = false;
        
        if ($this->isLoggedIn()) {
            $user = $this->getCurrentUser();
            $isFavorite = $this->userModel->isFavorite($user['id'], $id);
        }
        
        // Breadcrumbs
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '/'],
            ['name' => 'Properties', 'url' => '/'],
            ['name' => $property['city'], 'url' => '/?city=' . urlencode($property['city'])],
            ['name' => $property['title'], 'url' => '']
        ];
        
        $this->view('properties/show', [
            'property' => $property,
            'similarProperties' => $similarProperties,
            'isFavorite' => $isFavorite,
            'breadcrumbs' => $breadcrumbs,
            'csrfToken' => $this->generateCSRF()
        ]);
    }

    // Admin-only detailed view with admin footer/header
    public function adminShow($id) {
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            $this->redirect('/admin/login');
        }
        $property = $this->propertyModel->getWithImages($id);
        if (!$property) {
            http_response_code(404);
            $this->view('errors/404');
            return;
        }
        $this->view('admin/property_detail', [
            'property' => $property,
            'csrfToken' => $this->generateCSRF()
        ]);
    }

    public function submitRequest($id) {
        // Validate CSRF token
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request']);
            return;
        }
        
        // Validate required fields
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');
        
        if (empty($name) || empty($email) || empty($message)) {
            $this->jsonResponse(['success' => false, 'message' => 'Please fill in all required fields']);
            return;
        }
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->jsonResponse(['success' => false, 'message' => 'Please enter a valid email address']);
            return;
        }
        
        // Check if property exists
        $property = $this->propertyModel->getWithImages($id);
        if (!$property) {
            $this->jsonResponse(['success' => false, 'message' => 'Property not found']);
            return;
        }
        
        // Prepare request data
        $requestData = [
            'property_id' => $id,
            'user_id' => $_SESSION['user_id'] ?? null, // null for guest requests
            'name' => $name,
            'email' => $email,
            'phone' => trim($_POST['phone'] ?? ''),
            'message' => $message,
            'contact_method' => $_POST['contact_method'] ?? 'email',
            'status' => 'pending'
        ];
        
        // Create request
        $requestModel = new UserRequest();
        $success = $requestModel->createRequest($requestData);
        
        if ($success) {
            $this->jsonResponse([
                'success' => true, 
                'message' => 'Your request has been submitted successfully. We\'ll get back to you soon!'
            ]);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to submit request. Please try again.']);
        }
    }
    
    private function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }
    
    public function requestDetails($id) {
        if (!$this->isLoggedIn()) {
            $this->json(['success' => false, 'message' => 'Please login to request details']);
            return;
        }
        
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            $this->json(['success' => false, 'message' => 'Invalid request']);
            return;
        }
        
        $property = $this->propertyModel->find($id);
        if (!$property) {
            $this->json(['success' => false, 'message' => 'Property not found']);
            return;
        }
        
        $user = $this->getCurrentUser();
        
        $data = [
            'property_id' => $id,
            'user_id' => $user['id'],
            'contact_method' => $_POST['contact_method'] ?? 'email',
            'message' => $_POST['message'] ?? '',
            'preferred_date' => $_POST['preferred_date'] ?? null,
            'preferred_time' => $_POST['preferred_time'] ?? null
        ];
        
        $requestId = $this->requestModel->createRequest($data);
        
        if ($requestId) {
            // Send email notification to admin
            $this->sendRequestNotification($property, $user, $data);
            
            $this->json(['success' => true, 'message' => 'Your request has been submitted successfully']);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to submit request']);
        }
    }
    
    public function toggleFavorite($id) {
        if (!$this->isLoggedIn()) {
            $this->json(['success' => false, 'message' => 'Please login to add favorites']);
            return;
        }
        
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            $this->json(['success' => false, 'message' => 'Invalid request']);
            return;
        }
        
        $property = $this->propertyModel->find($id);
        if (!$property) {
            $this->json(['success' => false, 'message' => 'Property not found']);
            return;
        }
        
        $user = $this->getCurrentUser();
        $isFavorite = $this->userModel->isFavorite($user['id'], $id);
        
        if ($isFavorite) {
            $success = $this->userModel->removeFavorite($user['id'], $id);
            $message = $success ? 'Removed from favorites' : 'Failed to remove from favorites';
        } else {
            $success = $this->userModel->addFavorite($user['id'], $id);
            $message = $success ? 'Added to favorites' : 'Failed to add to favorites';
        }
        
        $this->json([
            'success' => $success,
            'message' => $message,
            'isFavorite' => !$isFavorite
        ]);
    }
    
    private function sendRequestNotification($property, $user, $requestData) {
        // This would typically use PHPMailer or similar
        $subject = "New Property Request - {$property['title']}";
        $message = "
            New property request received:
            
            Property: {$property['title']} ({$property['property_id']})
            User: {$user['name']} ({$user['email']})
            Contact Method: {$requestData['contact_method']}
            Message: {$requestData['message']}
            Preferred Date: {$requestData['preferred_date']}
            Preferred Time: {$requestData['preferred_time']}
            
            Please contact the user as soon as possible.
        ";
        
        // In a real application, you would send this email
        // mail(ADMIN_EMAIL, $subject, $message);
    }
}
