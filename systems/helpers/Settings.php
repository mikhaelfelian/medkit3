<?php
class Settings {
    private static $instance = null;
    private $settings = null;
    private $conn;
    
    private function __construct() {
        $this->conn = Database::getInstance()->getConnection();
        $this->loadSettings();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function loadSettings() {
        try {
            $stmt = $this->conn->query("SELECT * FROM pengaturan LIMIT 1");
            $this->settings = $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Settings Error: " . $e->getMessage());
            $this->settings = new stdClass();
            $this->settings->judul_app = 'NUSANTARA HMVC';
            $this->settings->logo = 'assets/theme/admin-lte-3/dist/img/AdminLTELogo.png';
            $this->settings->favicon = 'assets/theme/admin-lte-3/dist/img/AdminLTELogo.png';
        }
    }
    
    public function get($key = null) {
        if ($key === null) {
            return $this->settings;
        }
        return $this->settings->$key ?? null;
    }
} 