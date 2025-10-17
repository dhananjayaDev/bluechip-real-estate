<?php
/**
 * Installation Script for Bluechip Realty
 * Run this script to set up the database and initial configuration
 */

// Check if PHP version is compatible
if (version_compare(PHP_VERSION, '7.4.0', '<')) {
    die('PHP 7.4 or higher is required. Current version: ' . PHP_VERSION);
}

// Check if required extensions are loaded
$required_extensions = ['pdo', 'pdo_mysql', 'gd', 'mbstring'];
$missing_extensions = [];

foreach ($required_extensions as $ext) {
    if (!extension_loaded($ext)) {
        $missing_extensions[] = $ext;
    }
}

if (!empty($missing_extensions)) {
    die('Missing required PHP extensions: ' . implode(', ', $missing_extensions));
}

echo "Bluechip Realty Installation Script\n";
echo "===================================\n\n";

// Database configuration
echo "Database Configuration:\n";
$db_host = readline("Database Host (localhost): ") ?: 'localhost';
$db_name = readline("Database Name (real_estate): ") ?: 'real_estate';
$db_user = readline("Database Username (root): ") ?: 'root';
$db_pass = readline("Database Password: ");

echo "\nSite Configuration:\n";
$site_name = readline("Site Name (Bluechip Realty): ") ?: 'Bluechip Realty';
$site_url = readline("Site URL (http://localhost/real-estate-01): ") ?: 'http://localhost/real-estate-01';
$admin_email = readline("Admin Email (admin@bluechiprealty.com): ") ?: 'admin@bluechiprealty.com';

// Test database connection
try {
    $pdo = new PDO("mysql:host={$db_host};charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "\n✓ Database connection successful\n";
} catch (PDOException $e) {
    die("✗ Database connection failed: " . $e->getMessage() . "\n");
}

// Create database if it doesn't exist
try {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$db_name}` CHARACTER SET utf8 COLLATE utf8_general_ci");
    echo "✓ Database '{$db_name}' created/verified\n";
} catch (PDOException $e) {
    die("✗ Failed to create database: " . $e->getMessage() . "\n");
}

// Connect to the specific database
try {
    $pdo = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("✗ Failed to connect to database: " . $e->getMessage() . "\n");
}

// Read and execute schema
$schema_file = __DIR__ . '/database/schema.sql';
if (!file_exists($schema_file)) {
    die("✗ Schema file not found: {$schema_file}\n");
}

$schema = file_get_contents($schema_file);
$statements = explode(';', $schema);

foreach ($statements as $statement) {
    $statement = trim($statement);
    if (!empty($statement)) {
        try {
            $pdo->exec($statement);
        } catch (PDOException $e) {
            // Ignore errors for statements that might already exist
            if (strpos($e->getMessage(), 'already exists') === false) {
                echo "Warning: " . $e->getMessage() . "\n";
            }
        }
    }
}

echo "✓ Database schema imported\n";

// Update configuration files
$config_files = [
    'app/config/database.php' => [
        'DB_HOST' => $db_host,
        'DB_NAME' => $db_name,
        'DB_USER' => $db_user,
        'DB_PASS' => $db_pass
    ],
    'app/config/config.php' => [
        'SITE_NAME' => $site_name,
        'SITE_URL' => $site_url,
        'ADMIN_EMAIL' => $admin_email
    ]
];

foreach ($config_files as $file => $config) {
    $file_path = __DIR__ . '/' . $file;
    if (file_exists($file_path)) {
        $content = file_get_contents($file_path);
        
        foreach ($config as $key => $value) {
            $content = preg_replace(
                "/define\('{$key}',\s*'[^']*'\);/",
                "define('{$key}', '{$value}');",
                $content
            );
        }
        
        file_put_contents($file_path, $content);
        echo "✓ Updated {$file}\n";
    }
}

// Create necessary directories
$directories = [
    'public/uploads',
    'public/uploads/properties',
    'public/uploads/thumbnails'
];

foreach ($directories as $dir) {
    if (!is_dir(__DIR__ . '/' . $dir)) {
        mkdir(__DIR__ . '/' . $dir, 0755, true);
        echo "✓ Created directory: {$dir}\n";
    }
}

// Set permissions
if (function_exists('chmod')) {
    chmod(__DIR__ . '/public/uploads', 0755);
    echo "✓ Set upload directory permissions\n";
}

echo "\nInstallation completed successfully!\n";
echo "===================================\n";
echo "You can now access your website at: {$site_url}\n";
echo "Default admin credentials:\n";
echo "Email: {$admin_email}\n";
echo "Password: password\n\n";
echo "Next steps:\n";
echo "1. Change the default admin password\n";
echo "2. Add your Google Maps API key for map functionality\n";
echo "3. Upload property images\n";
echo "4. Customize the site settings\n\n";
echo "For support, please refer to the README.md file.\n";
?>
