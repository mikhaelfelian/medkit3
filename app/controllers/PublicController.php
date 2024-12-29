<?php
class PublicController extends BaseController {
    public function file($path = '') {
        try {
            // Clean and validate path
            $path = filter_var($path, FILTER_SANITIZE_URL);
            
            // Remove any leading slashes
            $path = ltrim($path, '/');
            
            // Construct full path - note we're using file/ not public/file/
            $fullPath = ROOT_PATH . '/public/file/' . $path;
            
            // Security check - ensure path is within allowed directory
            $realPath = realpath($fullPath);
            $publicPath = realpath(ROOT_PATH . '/public/file');
            
            if (!$realPath || strpos($realPath, $publicPath) !== 0) {
                throw new Exception('Invalid file path');
            }
            
            // Check if file exists
            if (!file_exists($fullPath) || !is_file($fullPath)) {
                throw new Exception('File not found');
            }
            
            // Get file extension
            $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
            
            // Set content type based on file extension
            $contentTypes = [
                'png' => 'image/png',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'gif' => 'image/gif',
                'pdf' => 'application/pdf'
            ];
            
            $contentType = $contentTypes[$ext] ?? 'application/octet-stream';
            
            // Set headers
            header('Content-Type: ' . $contentType);
            header('Content-Length: ' . filesize($fullPath));
            header('Cache-Control: public, max-age=31536000');
            header('Pragma: public');
            
            // Output file
            readfile($fullPath);
            exit;
            
        } catch (Exception $e) {
            error_log('File access error: ' . $e->getMessage());
            header("HTTP/1.0 404 Not Found");
            echo "File not found";
            exit;
        }
    }
} 