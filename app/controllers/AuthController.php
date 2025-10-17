<?php
class AuthController extends Controller {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function login() {
        if ($this->isLoggedIn()) {
            $this->redirect('/');
        }
        
        $this->view('auth/login', [
            'csrfToken' => $this->generateCSRF()
        ]);
    }
    
    public function authenticate() {
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            $this->json(['success' => false, 'message' => 'Invalid request']);
            return;
        }
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $this->json(['success' => false, 'message' => 'Email and password are required']);
            return;
        }
        
        $user = $this->userModel->authenticate($email, $password);
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            
            $this->json(['success' => true, 'message' => 'Login successful', 'redirect' => '/']);
        } else {
            $this->json(['success' => false, 'message' => 'Invalid email or password']);
        }
    }
    
    public function register() {
        if ($this->isLoggedIn()) {
            $this->redirect('/');
        }
        
        $this->view('auth/register', [
            'csrfToken' => $this->generateCSRF()
        ]);
    }
    
    public function store() {
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            $this->json(['success' => false, 'message' => 'Invalid request']);
            return;
        }
        
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $phone = trim($_POST['phone'] ?? '');
        
        // Validation
        $errors = [];
        
        if (empty($name)) {
            $errors[] = 'Name is required';
        }
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email is required';
        }
        
        if (empty($password) || strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        }
        
        if ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match';
        }
        
        if (!empty($errors)) {
            $this->json(['success' => false, 'message' => implode(', ', $errors)]);
            return;
        }
        
        // Check if email already exists
        if ($this->userModel->findByEmail($email)) {
            $this->json(['success' => false, 'message' => 'Email already registered']);
            return;
        }
        
        // Create user
        $userData = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'phone' => $phone
        ];
        
        $userId = $this->userModel->createUser($userData);
        
        if ($userId) {
            // Auto login after registration
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = 'user';
            
            $this->json(['success' => true, 'message' => 'Registration successful', 'redirect' => '/']);
        } else {
            $this->json(['success' => false, 'message' => 'Registration failed']);
        }
    }
    
    public function logout() {
        if (!$this->validateCSRF($_POST['csrf_token'] ?? '')) {
            $this->json(['success' => false, 'message' => 'Invalid request']);
            return;
        }
        
        session_destroy();
        $this->json(['success' => true, 'message' => 'Logged out successfully', 'redirect' => '/']);
    }
}
