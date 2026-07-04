<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class ImageThumbnail
{
    // Genere des miniatures normalisees pour les images uploades.
    public static function generate(string $sourceRelativePath, string $thumbRelativePath, int $maxWidth = 320, int $maxHeight = 320): ?string
    {
        if (! function_exists('imagecreatetruecolor')) {
            return null;
        }

        $disk = Storage::disk('public');
        $sourcePath = $disk->path($sourceRelativePath);

        if (! is_file($sourcePath)) {
            return null;
        }

        $imageInfo = @getimagesize($sourcePath);
        if ($imageInfo === false) {
            return null;
        }

        [$sourceWidth, $sourceHeight, $imageType] = $imageInfo;
        if ($sourceWidth < 1 || $sourceHeight < 1) {
            return null;
        }

        $sourceImage = match ($imageType) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($sourcePath),
            IMAGETYPE_PNG => @imagecreatefrompng($sourcePath),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($sourcePath) : false,
            IMAGETYPE_GIF => @imagecreatefromgif($sourcePath),
            default => false,
        };

        if ($sourceImage === false) {
            return null;
        }

        $ratio = min($maxWidth / $sourceWidth, $maxHeight / $sourceHeight, 1);
        $thumbWidth = max(1, (int) floor($sourceWidth * $ratio));
        $thumbHeight = max(1, (int) floor($sourceHeight * $ratio));

        $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);

        // Preserve transparency for PNG/WEBP/GIF output.
        if (in_array($imageType, [IMAGETYPE_PNG, IMAGETYPE_WEBP, IMAGETYPE_GIF], true)) {
            imagealphablending($thumbImage, false);
            imagesavealpha($thumbImage, true);
            $transparent = imagecolorallocatealpha($thumbImage, 0, 0, 0, 127);
            imagefilledrectangle($thumbImage, 0, 0, $thumbWidth, $thumbHeight, $transparent);
        }

        imagecopyresampled(
            $thumbImage,
            $sourceImage,
            0,
            0,
            0,
            0,
            $thumbWidth,
            $thumbHeight,
            $sourceWidth,
            $sourceHeight,
        );

        $thumbPath = $disk->path($thumbRelativePath);
        $thumbDirectory = dirname($thumbPath);
        if (! is_dir($thumbDirectory)) {
            mkdir($thumbDirectory, 0755, true);
        }

        $saved = match ($imageType) {
            IMAGETYPE_JPEG => imagejpeg($thumbImage, $thumbPath, 85),
            IMAGETYPE_PNG => imagepng($thumbImage, $thumbPath, 6),
            IMAGETYPE_WEBP => function_exists('imagewebp') ? imagewebp($thumbImage, $thumbPath, 85) : false,
            IMAGETYPE_GIF => imagegif($thumbImage, $thumbPath),
            default => false,
        };

        imagedestroy($sourceImage);
        imagedestroy($thumbImage);

        return $saved ? $thumbRelativePath : null;
    }
}
