<?php
// Additional configuration
define('TIMEZONE', 'Asia/Colombo');
date_default_timezone_set(TIMEZONE);

// Pagination
define('ITEMS_PER_PAGE', 12);

// Image settings
define('THUMBNAIL_WIDTH', 300);
define('THUMBNAIL_HEIGHT', 200);
define('GALLERY_WIDTH', 800);
define('GALLERY_HEIGHT', 600);

// Email settings
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-email@gmail.com');
define('SMTP_PASSWORD', 'your-app-password');
define('SMTP_FROM_EMAIL', 'noreply@bluechiprealty.com');
define('SMTP_FROM_NAME', 'Bluechip Realty');
