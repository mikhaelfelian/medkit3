<?php
class PaginateHelper {
    private static $instance = null;
    private static $conn = null;
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$conn = Database::getInstance()->getConnection();
        }
        return self::$instance;
    }
    
    public static function createLinks($page, $perPage, $total, $params = []) {
        $paginator = new Paginate(self::$conn ?? Database::getInstance()->getConnection());
        return $paginator->createLinks($page, $perPage, $total, $params);
    }
} 