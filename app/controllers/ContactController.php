<?php
class ContactController extends Controller {
    private $requestModel;
    
    public function __construct() {
        $this->requestModel = new UserRequest();
    }
    
    public function submit() {
        // Validate CSRF token
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            $this->json(['success' => false, 'message' => 'Invalid request']);
            return;
        }
        
        // Validate required fields
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');
        
        if (empty($name) || empty($email) || empty($message)) {
            $this->json(['success' => false, 'message' => 'Please fill in all required fields']);
            return;
        }
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json(['success' => false, 'message' => 'Please enter a valid email address']);
            return;
        }
        
        // Prepare request data
        $requestData = [
            'property_id' => null, // General contact request
            'user_id' => $_SESSION['user_id'] ?? null, // null for guest requests
            'name' => $name,
            'email' => $email,
            'phone' => trim($_POST['phone'] ?? ''),
            'message' => $message,
            'contact_method' => 'email',
            'status' => 'pending'
        ];
        
        // Create request
        $success = $this->requestModel->createRequest($requestData);
        
        if ($success) {
            $this->json([
                'success' => true, 
                'message' => 'Your message has been sent successfully. We\'ll get back to you soon!'
            ]);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to send message. Please try again.']);
        }
    }
    
    public function checkAuth() {
        $this->json([
            'isLoggedIn' => $this->isLoggedIn(),
            'user' => $this->isLoggedIn() ? $this->getCurrentUser() : null
        ]);
    }
}



