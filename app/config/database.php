<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'real_estate');
define('DB_USER', 'root');
define('DB_PASS', '');

// Site configuration
define('SITE_NAME', 'Bluechip Realty');
define('SITE_URL', 'http://localhost/real-estate-01');
define('ADMIN_EMAIL', 'admin@bluechiprealty.com');

// Security
define('ENCRYPTION_KEY', 'your-secret-key-here');

// File upload settings
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
