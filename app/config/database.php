<?php
// Database configuration - Load from environment or use defaults
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'real_estate');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');

// Site configuration
define('SITE_NAME', $_ENV['SITE_NAME'] ?? 'Bluechip Realty');
define('SITE_URL', $_ENV['SITE_URL'] ?? 'http://localhost/real-estate-01');
define('ADMIN_EMAIL', $_ENV['ADMIN_EMAIL'] ?? 'admin@bluechiprealty.com');

// Security
define('ENCRYPTION_KEY', $_ENV['ENCRYPTION_KEY'] ?? 'your-secret-key-here');

// File upload settings
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
