<?php
session_start();

$random = rand(1, 9) . rand(1, 9) . rand(1, 9);

$_SESSION['captcha'] = $random;

$captcha = imagecreatefromjpeg("images/captcha.jpeg");
$color = imagecolorallocate($captcha, 0, 0, 0);
$font = 'code.otf';
imagettftext($captcha, 20, 0, rand(30, 80), rand(20, 60), $color, $font, $random);
imagepng($captcha);
imagedestroy($captcha);
?>