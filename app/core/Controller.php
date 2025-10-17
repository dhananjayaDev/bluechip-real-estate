<?php
class Controller {
    protected function view($view, $data = []) {
        extract($data);
        require_once APP_PATH . "/views/{$view}.php";
    }
    
    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }
    
    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    protected function getCurrentUser() {
        if ($this->isLoggedIn()) {
            $user = new User();
            return $user->find($_SESSION['user_id']);
        }
        return null;
    }
    
    protected function validateCSRF($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    protected function generateCSRF() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}
