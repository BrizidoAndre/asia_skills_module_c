<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('image', function () {
    $size = 200;
    $imageData = imagecreatetruecolor($size, $size);
    $black = imagecolorallocate($imageData, 0, 0, 0);

    $startColor = [0, 0, 255];
    $endColor = [255, 255, 0];
    for ($i = 0; $i < $size; $i++) {
        $percentage = ($i / $size);
        $r = $startColor[0] + ($endColor[0] - $startColor[0]) * $percentage;
        $g = $startColor[1] + ($endColor[1] - $startColor[1]) * $percentage;
        $b = $startColor[2] + ($endColor[2] - $startColor[2]) * $percentage;
        $color = imagecolorallocate($imageData, $r, $g, $b);
        imageline($imageData, 0, $i, $size, $i, $color);
    }

//    get image size
    $imageWidth = imagesx($imageData);
    $imageHeight = imagesy($imageData);
//    set image colors
    $textColor = imagecolorallocate($imageData, 0, 0, 0);
    $whiteColor = imagecolorallocate($imageData, 255, 255, 255);
//    filling the image with colors
    $imageText = request()->query('text', 'Hello World!');
    $textCount = strlen($imageText);
//    get text centering positions
    $x = ($imageWidth - (9 * $textCount)) / 2;
    $y = ($imageHeight - 9) / 2;
//    write the text
    imagestring($imageData, 5, $x, $y, $imageText, $textColor);
//    drawing an X
    imageline($imageData, 0, 0, $imageWidth, $imageHeight, $black);
    imageline($imageData, $imageWidth, 0, 0, $imageHeight, $black);
    // register the images in a string
    ob_start();
    imagepng($imageData);
//    get everything and stop registering images in a string
    $image = ob_get_clean();
//    destroy the image
    imagedestroy($imageData);
//    returning the image
    return response($image)->header('Content-Type', 'image/png');
});
