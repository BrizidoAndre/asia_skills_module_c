<?php

namespace App\Base;

use Symfony\Component\HttpKernel\EventListener\FragmentListener;

class Image
{
    const WIDTH = 300;
    const HEIGHT = 300;

    static public function halfImage($firstImage, $secondImage)
    {
        $firstImage = self::getRightImage($firstImage);
        $secondImage = self::getRightImage($secondImage);
        $combinedImage = imagecreatetruecolor(imagesx($firstImage), imagesy($firstImage));
        $halfWidth = imagesx($firstImage);
        imagecopy($combinedImage, $firstImage, 0, 0, 0, 0, $halfWidth / 2, imagesy($firstImage));
        imagecopy($combinedImage, $secondImage, $halfWidth / 2, 0, 0, 0, $halfWidth / 2, imagesy($secondImage));

        // Capture the output
        ob_start();
        imagejpeg($combinedImage);
        $imageData = ob_get_clean();

        // Clean up memory
        imagedestroy($combinedImage);
        imagedestroy($firstImage);
        imagedestroy($secondImage);
        return $imageData;
    }

    public static function threeImage(string $firstImage, string $secondImage, string $thirdImage)
    {
        $firstImage = self::getRightImage($firstImage);
        $secondImage = self::getRightImage($secondImage);
        $thirdImage = self::getRightImage($thirdImage);
        $combinedImage = imagecreatetruecolor(imagesx($firstImage), imagesy($firstImage));
        $halfWidth = imagesx($firstImage) / 2;
        $halfHeight = imagesy($firstImage) / 2;
        imagecopy($combinedImage, $firstImage, 0, 0, 0, 0, $halfWidth, $halfHeight);
        imagecopy($combinedImage, $secondImage, $halfWidth, 0, 0, 0, $halfWidth, $halfHeight);
        imagecopyresampled($combinedImage, $thirdImage, 0, $halfHeight, 0, 0, self::WIDTH, $halfHeight, self::WIDTH, self::HEIGHT);

        // Capture the output
        ob_start();
        imagejpeg($combinedImage);
        $imageData = ob_get_clean();

        // Clean up memory
        imagedestroy($combinedImage);
        imagedestroy($firstImage);
        imagedestroy($secondImage);
        imagedestroy($thirdImage);
        return $imageData;
    }

    public static function getRightImage($path)
    {
        $info = getimagesize($path);
        $data = match ($info['mime'] ?? '') {
            'image/jpeg' => imagecreatefromjpeg($path),
            'image/png' => imagecreatefrompng($path),
            'image/gif' => imagecreatefromgif($path),
            'image/webp' => imagecreatefromwebp($path),
            default => throw new \Exception('Unsupported image type'),
        };
        $target = imagecreatetruecolor(self::WIDTH, self::HEIGHT);
        imagecopyresampled($target, $data, 0, 0, 0, 0, self::WIDTH, self::HEIGHT, imagesx($data), imagesy($data));
        imagedestroy($data);
        return $target;
    }
}
