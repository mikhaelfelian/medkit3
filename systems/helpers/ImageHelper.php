<?php
/**
 * Image Helper
 * Provides helper functions for image handling
 */
class ImageHelper {
    /**
     * Convert base64 image to file and save it
     * 
     * @param string $base64Image Base64 encoded image string
     * @param string $uploadPath Path where image should be saved
     * @param string $fileName Optional custom filename (without extension)
     * @return array|false Returns array with file info on success, false on failure
     */
    public static function base64ToFile($base64Image, $uploadPath, $fileName = null) {
        try {
            // Check if base64 string is valid
            if (empty($base64Image) || !preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                throw new Exception('Invalid base64 image string');
            }

            // Get image type and data
            $imageType = strtolower($type[1]); // jpg, png, gif
            $base64Data = substr($base64Image, strpos($base64Image, ',') + 1);
            $decodedImage = base64_decode($base64Data);

            if (!$decodedImage) {
                throw new Exception('Failed to decode base64 image');
            }

            // Create upload directory if it doesn't exist
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generate filename if not provided
            if (empty($fileName)) {
                $fileName = uniqid('img_');
            }

            // Full file path with extension
            $filePath = $uploadPath . '/' . $fileName . '.' . $imageType;

            // Save file
            if (!file_put_contents($filePath, $decodedImage)) {
                throw new Exception('Failed to save image file');
            }

            // Return file information
            return [
                'fileName' => $fileName . '.' . $imageType,
                'filePath' => $filePath,
                'fileType' => $imageType,
                'fileSize' => filesize($filePath),
                'mimeType' => 'image/' . $imageType
            ];

        } catch (Exception $e) {
            error_log("ImageHelper Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Validate image file type
     * 
     * @param string $base64Image Base64 encoded image string
     * @param array $allowedTypes Array of allowed image types (e.g., ['jpg', 'jpeg', 'png'])
     * @return bool Returns true if valid, false otherwise
     */
    public static function validateImageType($base64Image, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif']) {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $imageType = strtolower($type[1]);
            return in_array($imageType, $allowedTypes);
        }
        return false;
    }

    /**
     * Get image dimensions from base64 string
     * 
     * @param string $base64Image Base64 encoded image string
     * @return array|false Returns array with width and height, or false on failure
     */
    public static function getImageDimensions($base64Image) {
        try {
            $base64Data = substr($base64Image, strpos($base64Image, ',') + 1);
            $decodedImage = base64_decode($base64Data);
            
            if (!$decodedImage) {
                return false;
            }

            $image = imagecreatefromstring($decodedImage);
            if (!$image) {
                return false;
            }

            $dimensions = [
                'width' => imagesx($image),
                'height' => imagesy($image)
            ];

            imagedestroy($image);
            return $dimensions;

        } catch (Exception $e) {
            error_log("ImageHelper Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete image file
     * 
     * @param string $filePath Full path to image file
     * @return bool Returns true if deleted successfully, false otherwise
     */
    public static function deleteImage($filePath) {
        try {
            if (file_exists($filePath) && is_file($filePath)) {
                return unlink($filePath);
            }
            return false;
        } catch (Exception $e) {
            error_log("ImageHelper Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate a random filename with specified extension
     * 
     * @param string $extension File extension (e.g. 'jpg', 'png')
     * @param int $length Length of random string (default: 16)
     * @return string Random filename with extension
     */
    public static function generateRandomFilename($extension, $length = 16) {
        try {
            // Remove dot if included in extension
            $extension = ltrim($extension, '.');
            
            // Generate random string
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            
            // Add timestamp for more uniqueness
            $timestamp = time();
            
            // Combine elements
            return $timestamp . '_' . $randomString . '.' . $extension;
            
        } catch (Exception $e) {
            error_log("ImageHelper Error: " . $e->getMessage());
            return false;
        }
    }
} 