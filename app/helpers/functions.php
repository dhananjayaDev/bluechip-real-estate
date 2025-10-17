<?php
// Helper function to render views with layout
function render($view, $data = []) {
    extract($data);
    ob_start();
    include APP_PATH . "/views/{$view}.php";
    $content = ob_get_clean();
    
    include APP_PATH . "/views/layouts/app.php";
}

// Helper function to format currency
function formatCurrency($amount, $currency = 'LKR') {
    if ($currency === 'LKR') {
        return 'Rs. ' . number_format($amount, 0, '.', ',');
    }
    return $currency . ' ' . number_format($amount, 0, '.', ',');
}

// Helper function to format date
function formatDate($date, $format = 'M d, Y') {
    return date($format, strtotime($date));
}

// Helper function to generate property URL
function propertyUrl($id) {
    return "/property/{$id}";
}

// Helper function to generate image URL
function imageUrl($path) {
    if (empty($path)) {
        return '/public/images/placeholder.php';
    }
    return '/public/uploads/' . $path;
}

// Helper function to truncate text
function truncate($text, $length = 100) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

// Helper function to escape HTML
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
