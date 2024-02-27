<?php
session_start();

$random_number = rand(1000, 9999);
$_SESSION['captcha'] = $random_number;

$im = imagecreatetruecolor(100, 38);
$text_color = imagecolorallocate($im, 0, 0, 0);
imagestring($im, 5, 20, 10, $random_number, $text_color);

header('Content-type: image/jpeg');
imagejpeg($im);
imagedestroy($im);
?>
