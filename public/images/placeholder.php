<?php
// Create a simple placeholder image
$width = 400;
$height = 300;
$image = imagecreate($width, $height);

// Set colors
$bg_color = imagecolorallocate($image, 240, 240, 240);
$text_color = imagecolorallocate($image, 100, 100, 100);
$border_color = imagecolorallocate($image, 200, 200, 200);

// Fill background
imagefill($image, 0, 0, $bg_color);

// Draw border
imagerectangle($image, 0, 0, $width-1, $height-1, $border_color);

// Add text
$text = "No Image Available";
$font_size = 5;
$text_width = imagefontwidth($font_size) * strlen($text);
$text_height = imagefontheight($font_size);
$x = ($width - $text_width) / 2;
$y = ($height - $text_height) / 2;

imagestring($image, $font_size, $x, $y, $text, $text_color);

// Output image
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
?>
