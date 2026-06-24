<?php

namespace App\Traits;

trait GeneratesMathCaptchaImage
{
    public function generateCaptchaImage(int $num1, int $num2): string
    {
        $width = 140;
        $height = 50;

        $image = imagecreatetruecolor($width, $height);

        // Define colors
        $bg = imagecolorallocate($image, 245, 245, 245);
        $textColor = imagecolorallocate($image, 40, 40, 40);
        $lineColor = imagecolorallocate($image, 120, 120, 120);

        // Fill background
        imagefill($image, 0, 0, $bg);

        // Draw some random lines for noise
        for ($i = 0; $i < 6; $i++) {
            imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $lineColor);
        }

        // The math equation
        $text = "$num1 + $num2 = ?";

        // Center text
        $font = 5;
        $fw = imagefontwidth($font);
        $fh = imagefontheight($font);
        $tw = $fw * strlen($text);

        $x = ($width - $tw) / 2;
        $y = ($height - $fh) / 2;

        imagestring($image, $font, $x, $y, $text, $textColor);

        // Draw some random dots for noise
        for ($i = 0; $i < 50; $i++) {
            imagesetpixel($image, rand(0, $width), rand(0, $height), $lineColor);
        }

        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        return 'data:image/png;base64,' . base64_encode($imageData);
    }
}
