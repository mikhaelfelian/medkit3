<?php
class Encrypt {
    private static $instance = null;
    private $key;
    private $method;
    
    private function __construct() {
        $this->key = $GLOBALS['app_config']['encryption_key'];
        $this->method = $GLOBALS['app_config']['encryption_method'];
        
        if (empty($this->key)) {
            throw new Exception('Encryption key is not set');
        }
        
        // Pad or truncate key to exactly 32 characters
        $this->key = str_pad(substr($this->key, 0, 32), 32, '0');
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Static encryption method
     * @param string $data Data to encrypt
     * @return string Encrypted data
     */
    public static function encrypt($data) {
        return self::getInstance()->encryptData($data);
    }
    
    /**
     * Static decryption method
     * @param string $data Encrypted data
     * @return string|false Decrypted data or false on failure
     */
    public static function decrypt($data) {
        return self::getInstance()->decryptData($data);
    }
    
    /**
     * Dynamic encryption method
     * @param string $data Data to encrypt
     * @return string Encrypted data
     */
    public function encryptData($data) {
        try {
            $ivlen = openssl_cipher_iv_length($this->method);
            $iv = openssl_random_pseudo_bytes($ivlen);
            
            $encrypted = openssl_encrypt(
                $data,
                $this->method,
                $this->key,
                OPENSSL_RAW_DATA,
                $iv
            );
            
            if ($encrypted === false) {
                throw new Exception('Encryption failed');
            }
            
            // Combine IV and encrypted data
            $combined = $iv . $encrypted;
            
            // Base64 encode for safe storage
            return base64_encode($combined);
            
        } catch (Exception $e) {
            if (DEBUG_MODE) {
                throw $e;
            }
            return false;
        }
    }
    
    /**
     * Dynamic decryption method
     * @param string $data Encrypted data
     * @return string|false Decrypted data or false on failure
     */
    public function decryptData($data) {
        try {
            // Decode from base64
            $decoded = base64_decode($data);
            if ($decoded === false) {
                throw new Exception('Invalid base64 encoding');
            }
            
            // Get the IV size
            $ivlen = openssl_cipher_iv_length($this->method);
            
            // Extract IV and encrypted data
            $iv = substr($decoded, 0, $ivlen);
            $encrypted = substr($decoded, $ivlen);
            
            if (strlen($iv) !== $ivlen) {
                throw new Exception('Invalid IV length');
            }
            
            // Decrypt
            $decrypted = openssl_decrypt(
                $encrypted,
                $this->method,
                $this->key,
                OPENSSL_RAW_DATA,
                $iv
            );
            
            if ($decrypted === false) {
                throw new Exception('Decryption failed');
            }
            
            return $decrypted;
            
        } catch (Exception $e) {
            if (DEBUG_MODE) {
                throw $e;
            }
            return false;
        }
    }
    
    /**
     * Generate a secure encryption key
     * @return string 32-character encryption key
     */
    public static function generateKey() {
        return bin2hex(random_bytes(16)); // Generates 32 character hex string
    }
    
    /**
     * Hash a string (one-way encryption)
     * @param string $data Data to hash
     * @return string Hashed data
     */
    public static function hash($data) {
        return password_hash($data, PASSWORD_BCRYPT, ['cost' => 12]);
    }
    
    /**
     * Verify a hash
     * @param string $data Original data
     * @param string $hash Hashed data
     * @return bool True if match
     */
    public static function verifyHash($data, $hash) {
        return password_verify($data, $hash);
    }
    
    /**
     * Encrypt data with custom key
     * @param string $data Data to encrypt
     * @param string $key Custom encryption key
     * @return string Encrypted data
     */
    public static function encryptWithKey($data, $key) {
        $instance = new self();
        $originalKey = $instance->key;
        $instance->key = $key;
        $result = $instance->encryptData($data);
        $instance->key = $originalKey;
        return $result;
    }
    
    /**
     * Decrypt data with custom key
     * @param string $data Encrypted data
     * @param string $key Custom encryption key
     * @return string|false Decrypted data or false on failure
     */
    public static function decryptWithKey($data, $key) {
        $instance = new self();
        $originalKey = $instance->key;
        $instance->key = $key;
        $result = $instance->decryptData($data);
        $instance->key = $originalKey;
        return $result;
    }
}
?> 