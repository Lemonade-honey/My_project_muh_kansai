<?php
    session_start();
    // captcha code generate
    $random_alpha = md5(rand());
    $captcha_code = substr($random_alpha, 0, 7);
    $_SESSION["captcha"] = $captcha_code;

    // image generate
    $target = imagecreatetruecolor(72, 30);
    $image_color = imagecolorallocate($target, 255, 160, 119);
    imagefill($target, 0, 0, $image_color);
    $image_text_color = imagecolorallocate($target, 0, 0, 0);
    imagestring($target, 5, 5, 5, $captcha_code, $image_text_color);
    header("Content-type: image/jpeg");
    imagejpeg($target);
?>