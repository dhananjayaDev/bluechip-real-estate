<?php

class AdminController extends Controller {
    private $propertyModel;
    private $userModel;
    private $requestModel;
    private $bannedUserModel;
    
    public function __construct() {
        $this->propertyModel = new Property();
        $this->userModel = new User();
        $this->requestModel = new UserRequest();
        $this->bannedUserModel = new BannedUser();
    }
    
    public function login() {
        // If already logged in as admin, redirect to dashboard
        if ($this->isLoggedIn() && $this->isAdmin()) {
            $this->redirect('/admin');
        }
        
        $this->view('admin/login', [
            'csrfToken' => $this->generateCSRF()
        ]);
    }
    
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/login');
        }
        
        // Verify CSRF token
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Invalid request. Please try again.';
            $this->redirect('/admin/login');
        }
        
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Please fill in all fields.';
            $this->redirect('/admin/login');
        }
        
        $user = $this->userModel->authenticate($email, $password);
        
        if (!$user) {
            $_SESSION['error'] = 'Invalid email or password.';
            $this->redirect('/admin/login');
        }
        
        if ($user['role'] !== 'admin') {
            $_SESSION['error'] = 'Access denied. Admin privileges required.';
            $this->redirect('/admin/login');
        }
        
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['logged_in'] = true;
        
        $_SESSION['success'] = 'Welcome back, ' . $user['name'] . '!';
        $this->redirect('/admin');
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('/admin/login');
    }
    
    public function index() {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            $this->redirect('/admin/login');
        }
        
        // Get dashboard statistics
        $stats = [
            'total_properties' => $this->propertyModel->getCount(),
            'featured_properties' => $this->propertyModel->getCount(['featured' => 1]),
            'total_users' => $this->userModel->getCount(),
            'pending_requests' => $this->requestModel->getCount(['status' => 'pending'])
        ];
        
        // Get recent properties
        $recent_properties = $this->propertyModel->search([], 1, 5);
        
        // Get recent requests
        $recent_requests = $this->requestModel->getRecent(5);
        
        $this->view('admin/dashboard', [
            'stats' => $stats,
            'recent_properties' => $recent_properties,
            'recent_requests' => $recent_requests,
            'csrfToken' => $this->generateCSRF()
        ]);
    }
    
    public function properties() {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            $this->redirect('/admin/login');
        }
        
        $page = (int)($_GET['page'] ?? 1);
        
        // Build filters from GET parameters
        $filters = ['admin' => true]; // Show all properties for admin
        
        if (!empty($_GET['search'])) {
            $filters['search'] = $_GET['search'];
        }
        
        if (!empty($_GET['status'])) {
            $filters['status'] = $_GET['status'];
        }
        
        if (!empty($_GET['type'])) {
            $filters['property_type'] = $_GET['type'];
        }
        
        if (!empty($_GET['featured'])) {
            $filters['featured'] = (int)$_GET['featured'];
        }
        
        $properties = $this->propertyModel->search($filters, $page, 10);
        $totalProperties = $this->propertyModel->getCount($filters);
        $totalPages = ceil($totalProperties / 10);
        
        $this->view('admin/properties', [
            'properties' => $properties,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalProperties' => $totalProperties,
            'csrfToken' => $this->generateCSRF()
        ]);
    }
    
    public function users() {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            $this->redirect('/admin/login');
        }
        
        $page = (int)($_GET['page'] ?? 1);
        $limit = 10;
        
        // Fetch admin users separately
        $adminUsers = $this->userModel->getAll($page, $limit, ['role' => 'admin']);
        
        // Fetch regular users separately  
        $regularUsers = $this->userModel->getAll($page, $limit, ['role' => 'user']);
        
        // Add banned status to regular users only
        foreach ($regularUsers as &$user) {
            $user['is_banned'] = $this->bannedUserModel->isBanned($user['email']);
        }
        
        $totalAdmins = $this->userModel->getCount(['role' => 'admin']);
        $totalUsers = $this->userModel->getCount(['role' => 'user']);
        $totalPagesAdmins = ceil($totalAdmins / $limit);
        $totalPagesUsers = ceil($totalUsers / $limit);
        
        $this->view('admin/users', [
            'adminUsers' => $adminUsers,
            'regularUsers' => $regularUsers,
            'currentPage' => $page,
            'totalPagesAdmins' => $totalPagesAdmins,
            'totalPagesUsers' => $totalPagesUsers,
            'totalAdmins' => $totalAdmins,
            'totalUsers' => $totalUsers,
            'csrfToken' => $this->generateCSRF()
        ]);
    }
    
    public function requests() {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            $this->redirect('/admin/login');
        }
        
        $page = (int)($_GET['page'] ?? 1);
        $requests = $this->requestModel->getAll($page, 10);
        $totalRequests = $this->requestModel->getCount();
        $totalPages = ceil($totalRequests / 10);
        
        $this->view('admin/requests', [
            'requests' => $requests,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalRequests' => $totalRequests,
            'csrfToken' => $this->generateCSRF()
        ]);
    }

    public function addProperty() {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            $this->redirect('/admin/login');
        }
        
        $this->view('admin/add_property', [
            'csrfToken' => $this->generateCSRF()
        ]);
    }

    public function storeProperty() {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            $this->redirect('/admin/login');
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/properties/add');
        }
        
        // Verify CSRF token
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Invalid request. Please try again.';
            $this->redirect('/admin/properties/add');
        }
        
        // Validate required fields
        $requiredFields = [
            'title', 'property_id', 'short_description', 'description', 
            'price', 'property_type', 'bedrooms', 'bathrooms', 
            'location', 'city', 'district', 'address'
        ];
        
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['error'] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
                $this->redirect('/admin/properties/add');
            }
        }
        
        // Prepare property data
        $propertyData = [
            'title' => trim($_POST['title']),
            'property_id' => trim($_POST['property_id']),
            'short_description' => trim($_POST['short_description']),
            'description' => trim($_POST['description']),
            'price' => (float)$_POST['price'],
            'currency' => $_POST['currency'] ?? 'LKR',
            'property_type' => $_POST['property_type'],
            'bedrooms' => (int)$_POST['bedrooms'],
            'bathrooms' => (int)$_POST['bathrooms'],
            'floors' => (int)($_POST['floors'] ?? 1),
            'area_sqft' => !empty($_POST['area_sqft']) ? (float)$_POST['area_sqft'] : null,
            'land_area_sqft' => !empty($_POST['land_area_sqft']) ? (float)$_POST['land_area_sqft'] : null,
            'location' => trim($_POST['location']),
            'city' => trim($_POST['city']),
            'district' => trim($_POST['district']),
            'address' => trim($_POST['address']),
            'latitude' => !empty($_POST['latitude']) ? (float)$_POST['latitude'] : null,
            'longitude' => !empty($_POST['longitude']) ? (float)$_POST['longitude'] : null,
            'status' => $_POST['status'] ?? 'available',
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'created_by' => $_SESSION['user_id']
        ];
        
        // Check if property ID already exists
        $existingProperty = $this->propertyModel->findByPropertyId($propertyData['property_id']);
        if ($existingProperty) {
            $_SESSION['error'] = 'Property ID already exists. Please choose a different one.';
            $this->redirect('/admin/properties/add');
        }
        
        // Create property
        $propertyId = $this->propertyModel->create($propertyData);
        
        if ($propertyId) {
            // Handle image uploads
            if (!empty($_FILES['images']['name'][0])) {
                $this->handleImageUploads($propertyId, $_FILES['images']);
            }
            
            // Handle property features
            if (!empty($_POST['features'])) {
                $this->handlePropertyFeatures($propertyId, $_POST['features']);
            }
            
            $_SESSION['success'] = 'Property added successfully!';
            $this->redirect('/admin/properties');
        } else {
            $_SESSION['error'] = 'Failed to add property. Please try again.';
            $this->redirect('/admin/properties/add');
        }
    }
    
    private function handleImageUploads($propertyId, $files) {
        $uploadDir = 'public/images/uploads/properties/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $primaryImage = $_POST['primary_image'] ?? 0;
        
        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $fileName = uniqid() . '_' . $files['name'][$i];
                $filePath = $uploadDir . $fileName;
                
                if (move_uploaded_file($files['tmp_name'][$i], $filePath)) {
                    $imageData = [
                        'property_id' => $propertyId,
                        'image_path' => '/' . $filePath,
                        'thumbnail_path' => '/' . $filePath, // For now, same as main image
                        'alt_text' => $_POST['image_alt'][$i] ?? '',
                        'sort_order' => $i,
                        'is_primary' => ($i == $primaryImage) ? 1 : 0
                    ];
                    
                    $this->propertyModel->addImage(
                        $imageData['property_id'],
                        $imageData['image_path'],
                        $imageData['thumbnail_path'],
                        $imageData['alt_text'],
                        $imageData['is_primary']
                    );
                }
            }
        }
    }
    
    private function handlePropertyFeatures($propertyId, $features) {
        foreach ($features as $feature) {
            if (!empty($feature['name'])) {
                $featureData = [
                    'property_id' => $propertyId,
                    'feature_name' => trim($feature['name']),
                    'feature_value' => trim($feature['value'] ?? '')
                ];
                
                $this->propertyModel->addFeature(
                    $featureData['property_id'],
                    $featureData['feature_name'],
                    $featureData['feature_value']
                );
            }
        }
    }
    
    public function propertyDetail($id) {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            $this->redirect('/admin/login');
        }
        
        $property = $this->propertyModel->getWithImages($id);
        
        if (!$property) {
            $_SESSION['error'] = 'Property not found.';
            $this->redirect('/admin/properties');
        }
        
        $this->view('admin/property_detail', [
            'property' => $property,
            'csrfToken' => $this->generateCSRF()
        ]);
    }

    public function editProperty($id) {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            $this->redirect('/admin/login');
        }
        
        $property = $this->propertyModel->getWithImages($id);
        
        if (!$property) {
            $_SESSION['error'] = 'Property not found.';
            $this->redirect('/admin/properties');
        }
        
        $this->view('admin/edit_property', [
            'property' => $property,
            'csrfToken' => $this->generateCSRF()
        ]);
    }

    public function updateProperty($id) {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            $this->redirect('/admin/login');
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/properties/' . $id . '/edit');
        }
        
        // Verify CSRF token
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Invalid request. Please try again.';
            $this->redirect('/admin/properties/' . $id . '/edit');
        }
        
        // Validate required fields
        $requiredFields = [
            'title', 'property_id', 'short_description', 'description', 
            'price', 'property_type', 'bedrooms', 'bathrooms', 
            'location', 'city', 'district', 'address'
        ];
        
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['error'] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
                $this->redirect('/admin/properties/' . $id . '/edit');
            }
        }
        
        // Prepare property data
        $propertyData = [
            'title' => trim($_POST['title']),
            'property_id' => trim($_POST['property_id']),
            'short_description' => trim($_POST['short_description']),
            'description' => trim($_POST['description']),
            'price' => (float)$_POST['price'],
            'currency' => $_POST['currency'] ?? 'LKR',
            'property_type' => $_POST['property_type'],
            'bedrooms' => (int)$_POST['bedrooms'],
            'bathrooms' => (int)$_POST['bathrooms'],
            'floors' => (int)($_POST['floors'] ?? 1),
            'area_sqft' => !empty($_POST['area_sqft']) ? (float)$_POST['area_sqft'] : null,
            'land_area_sqft' => !empty($_POST['land_area_sqft']) ? (float)$_POST['land_area_sqft'] : null,
            'location' => trim($_POST['location']),
            'city' => trim($_POST['city']),
            'district' => trim($_POST['district']),
            'address' => trim($_POST['address']),
            'latitude' => !empty($_POST['latitude']) ? (float)$_POST['latitude'] : null,
            'longitude' => !empty($_POST['longitude']) ? (float)$_POST['longitude'] : null,
            'status' => $_POST['status'] ?? 'available',
            'featured' => isset($_POST['featured']) ? 1 : 0
        ];
        
        // Check if property ID already exists (excluding current property)
        $existingProperty = $this->propertyModel->findByPropertyId($propertyData['property_id']);
        if ($existingProperty && $existingProperty['id'] != $id) {
            $_SESSION['error'] = 'Property ID already exists. Please choose a different one.';
            $this->redirect('/admin/properties/' . $id . '/edit');
        }
        
        // Update property
        $success = $this->propertyModel->update($id, $propertyData);
        
        if ($success) {
            // Handle primary image replace (optional)
            if (!empty($_FILES['primary_image']['name'])) {
                $this->replacePrimaryImage($id, $_FILES['primary_image']);
            }
            
            // Handle gallery image uploads (if new images are uploaded)
            if (!empty($_FILES['images']['name'][0])) {
                $this->handleImageUploads($id, $_FILES['images']);
            }
            
            // Handle property features update
            if (!empty($_POST['features'])) {
                // Delete existing features and add new ones
                $this->propertyModel->deleteFeatures($id);
                $this->handlePropertyFeatures($id, $_POST['features']);
            }
            
            $_SESSION['success'] = 'Property updated successfully!';
            $this->redirect('/admin/properties');
        } else {
            $_SESSION['error'] = 'Failed to update property. Please try again.';
            $this->redirect('/admin/properties/' . $id . '/edit');
        }
    }

    private function replacePrimaryImage($propertyId, $file) {
        $uploadDir = 'public/images/uploads/properties/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileName = uniqid() . '_' . $file['name'];
            $filePath = $uploadDir . $fileName;
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                // If there is already a primary image, just update its path
                $currentPrimary = $this->propertyModel->getPrimaryImage($propertyId);
                if ($currentPrimary) {
                    // Delete old physical file if exists
                    if (!empty($currentPrimary['image_path']) && file_exists('.' . $currentPrimary['image_path'])) {
                        @unlink('.' . $currentPrimary['image_path']);
                    }
                    $this->propertyModel->updateImagePath($currentPrimary['id'], '/' . $filePath, '/' . $filePath, 'Primary Image');
                } else {
                    // Otherwise add as new primary
                    $this->propertyModel->removeImagePrimary($propertyId);
                    $this->propertyModel->addImage($propertyId, '/' . $filePath, '/' . $filePath, 'Primary Image', true);
                }
            }
        }
    }

    public function deleteProperty($id) {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            $this->redirect('/admin/login');
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/properties');
        }
        
        // Verify CSRF token
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Invalid request. Please try again.';
            $this->redirect('/admin/properties');
        }
        
        $property = $this->propertyModel->find($id);
        
        if (!$property) {
            $_SESSION['error'] = 'Property not found.';
            $this->redirect('/admin/properties');
        }
        
        // Delete property (this will cascade delete images and features)
        $success = $this->propertyModel->delete($id);
        
        if ($success) {
            $_SESSION['success'] = 'Property deleted successfully!';
        } else {
            $_SESSION['error'] = 'Failed to delete property. Please try again.';
        }
        
        $this->redirect('/admin/properties');
    }

    public function togglePropertyStatus($id) {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        // Verify CSRF token
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
            return;
        }
        
        $property = $this->propertyModel->find($id);
        
        if (!$property) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Property not found']);
            return;
        }
        
        $newStatus = $property['status'] === 'available' ? 'unavailable' : 'available';
        $success = $this->propertyModel->update($id, ['status' => $newStatus]);
        
        if ($success) {
            echo json_encode(['success' => true, 'status' => $newStatus]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status']);
        }
    }

    public function toggleFeatured($id) {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        // Verify CSRF token
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
            return;
        }
        
        $property = $this->propertyModel->find($id);
        
        if (!$property) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Property not found']);
            return;
        }
        
        $newFeatured = $property['featured'] ? 0 : 1;
        $success = $this->propertyModel->update($id, ['featured' => $newFeatured]);
        
        if ($success) {
            echo json_encode(['success' => true, 'featured' => $newFeatured]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update featured status']);
        }
    }

    public function bulkAction() {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            $this->redirect('/admin/login');
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/properties');
        }
        
        // Verify CSRF token
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Invalid request. Please try again.';
            $this->redirect('/admin/properties');
        }
        
        $action = $_POST['bulk_action'] ?? '';
        $propertyIds = $_POST['selected_properties'] ?? [];
        
        if (empty($propertyIds) || empty($action)) {
            $_SESSION['error'] = 'Please select properties and an action.';
            $this->redirect('/admin/properties');
        }
        
        $successCount = 0;
        $totalCount = count($propertyIds);
        
        foreach ($propertyIds as $propertyId) {
            switch ($action) {
                case 'delete':
                    if ($this->propertyModel->delete($propertyId)) {
                        $successCount++;
                    }
                    break;
                case 'featured':
                    if ($this->propertyModel->update($propertyId, ['featured' => 1])) {
                        $successCount++;
                    }
                    break;
                case 'unfeatured':
                    if ($this->propertyModel->update($propertyId, ['featured' => 0])) {
                        $successCount++;
                    }
                    break;
                case 'available':
                    if ($this->propertyModel->update($propertyId, ['status' => 'available'])) {
                        $successCount++;
                    }
                    break;
                case 'unavailable':
                    if ($this->propertyModel->update($propertyId, ['status' => 'unavailable'])) {
                        $successCount++;
                    }
                    break;
            }
        }
        
        if ($successCount > 0) {
            $_SESSION['success'] = "Successfully processed {$successCount} out of {$totalCount} properties.";
        } else {
            $_SESSION['error'] = 'No properties were processed.';
        }
        
        $this->redirect('/admin/properties');
    }

    public function banUser($userId) {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        // Verify CSRF token
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
            return;
        }
        
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'User not found']);
            return;
        }
        
        if ($user['role'] === 'admin') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Cannot ban admin users']);
            return;
        }
        
        $reason = $_POST['reason'] ?? 'No reason provided';
        $success = $this->bannedUserModel->banUser($user['email'], $_SESSION['user_id'], $reason);
        
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'User banned successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'User is already banned']);
        }
    }

    public function unbanUser($userId) {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        // Verify CSRF token
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
            return;
        }
        
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'User not found']);
            return;
        }
        
        $success = $this->bannedUserModel->unbanUser($user['email']);
        
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'User unbanned successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'User is not banned']);
        }
    }

    public function deleteUser($userId) {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        // Verify CSRF token
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
            return;
        }
        
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'User not found']);
            return;
        }
        
        if ($user['role'] === 'admin') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Cannot delete admin users']);
            return;
        }
        
        // TODO: Add your specific delete logic here
        // This is where you'll guide me on how to handle the delete action
        
        $success = $this->userModel->delete($userId);
        
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
        }
    }

    public function updatePrimaryImage($propertyId) {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        // Verify CSRF token
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
            return;
        }
        
        $imageId = $_POST['image_id'] ?? null;
        
        if (!$imageId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Image ID is required']);
            return;
        }
        
        // Verify the image belongs to the property
        $image = $this->propertyModel->getImageById($imageId);
        if (!$image || $image['property_id'] != $propertyId) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Image not found']);
            return;
        }
        
        // Remove primary status from all images of this property
        $this->propertyModel->removeImagePrimary($propertyId);
        
        // Set the selected image as primary
        $success = $this->propertyModel->updateImagePrimary($imageId, 1);
        
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Primary image updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update primary image']);
        }
    }

    public function deletePropertyImage($propertyId) {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }
        
        // Verify CSRF token
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
            return;
        }
        
        $imageId = $_POST['image_id'] ?? null;
        
        if (!$imageId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Image ID is required']);
            return;
        }
        
        // Verify the image belongs to the property
        $image = $this->propertyModel->getImageById($imageId);
        if (!$image || $image['property_id'] != $propertyId) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Image not found']);
            return;
        }
        
        // Delete the image file
        if (file_exists('.' . $image['image_path'])) {
            unlink('.' . $image['image_path']);
        }
        
        // Delete the image record
        $success = $this->propertyModel->deleteImage($imageId);
        
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Image deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete image']);
        }
    }

    public function getRequestDetails($id) {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            $this->jsonResponse(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        
        $requestModel = new UserRequest();
        $request = $requestModel->getById($id);
        
        if (!$request) {
            $this->jsonResponse(['success' => false, 'message' => 'Request not found']);
            return;
        }
        
        // Get property details
        $propertyModel = new Property();
        $property = $propertyModel->find($request['property_id']);
        
        if ($property) {
            $request['property_title'] = $property['title'];
            $request['property_location'] = $property['location'];
            $request['property_price'] = $property['price'];
        }
        
        $this->jsonResponse(['success' => true, 'request' => $request]);
    }
    
    public function updateRequestStatus($id) {
        // Check if user is admin
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            $this->jsonResponse(['success' => false, 'message' => 'Unauthorized']);
            return;
        }
        
        // Validate CSRF token
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request']);
            return;
        }
        
        $status = $_POST['status'] ?? '';
        if (!in_array($status, ['pending', 'contacted', 'completed'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid status']);
            return;
        }
        
        $requestModel = new UserRequest();
        $success = $requestModel->updateStatus($id, $status);
        
        if ($success) {
            $this->jsonResponse(['success' => true, 'message' => 'Request status updated successfully']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to update request status']);
        }
    }
    
    private function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }
    
    private function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
