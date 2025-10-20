<?php
class Router {
    private $routes = [];
    
    public function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }
    
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchRoute($route['path'], $uri)) {
                $this->callHandler($route['handler'], $this->extractParams($route['path'], $uri));
                return;
            }
        }
        
        // 404 Not Found
        http_response_code(404);
        echo "Page not found";
    }
    
    private function matchRoute($pattern, $uri) {
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $pattern);
        return preg_match('#^' . $pattern . '$#', $uri);
    }
    
    private function extractParams($pattern, $uri) {
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $pattern);
        preg_match('#^' . $pattern . '$#', $uri, $matches);
        array_shift($matches);
        return $matches;
    }
    
    private function callHandler($handler, $params = []) {
        list($controller, $method) = explode('@', $handler);
        $controller = new $controller();
        call_user_func_array([$controller, $method], $params);
    }
}
