<?php
class PengaturanModel extends BaseModel {
    protected $table = 'pengaturan';
    protected $primaryKey = 'id';
    protected $fillable = ['judul_app', 'logo', 'favicon'];
    
    public function __construct($conn) {
        if (!$conn) {
            throw new Exception("Database connection is required");
        }
        parent::__construct($conn, $this->table);
    }
    
    public function findOne($conditions = []) {
        try {
            // Check if table exists
            $tableCheck = $this->conn->query("SHOW TABLES LIKE '{$this->table}'");
            if ($tableCheck->rowCount() === 0) {
                error_log("Table {$this->table} does not exist");
                return $this->getDefaultSettings();
            }
            
            $sql = "SELECT * FROM {$this->table}";
            
            if (!empty($conditions)) {
                $where = [];
                foreach ($conditions as $field => $value) {
                    $where[] = "{$field} = :{$field}";
                }
                $sql .= " WHERE " . implode(' AND ', $where);
            }
            
            $sql .= " LIMIT 1";
            
            $stmt = $this->conn->prepare($sql);
            
            if (!empty($conditions)) {
                foreach ($conditions as $field => $value) {
                    $stmt->bindValue(":{$field}", $value);
                }
            }
            
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            
            return $result ?: $this->getDefaultSettings();
            
        } catch (PDOException $e) {
            error_log("Database Error in PengaturanModel: " . $e->getMessage());
            error_log("SQL Query: " . $sql);
            return $this->getDefaultSettings();
        }
    }
    
    public function getSettings() {
        try {
            return $this->findOne();
        } catch (Exception $e) {
            error_log("Error getting settings: " . $e->getMessage());
            return $this->getDefaultSettings();
        }
    }
    
    private function getDefaultSettings() {
        $settings = new stdClass();
        $settings->judul_app = 'NUSANTARA HMVC';
        $settings->logo = 'theme/admin-lte-3/dist/img/AdminLTELogo.png';
        $settings->favicon = 'theme/admin-lte-3/dist/img/AdminLTELogo.png';
        return $settings;
    }
} 