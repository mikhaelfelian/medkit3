<?php
class GenerateNoRM {
    private $conn;
    private $prefix;
    
    public function __construct() {
        global $conn;
        $this->conn = $conn;
        $this->prefix = date('ym');
    }
    
    public function generate() {
        try {
            // Get last number for current prefix
            $lastNumber = $this->getLastNumber($this->prefix);
            
            // Generate new number
            $newNumber = $lastNumber + 1;
            
            // Format number to 4 digits
            $formattedNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            
            // Combine prefix and number
            return $this->prefix . $formattedNumber;
            
        } catch (Exception $e) {
            error_log("Error generating RM number: " . $e->getMessage());
            throw new Exception("Gagal generate nomor RM");
        }
    }
    
    private function getLastNumber($prefix) {
        try {
            // Get the last RM number with current prefix
            $sql = "SELECT kode FROM pasien 
                   WHERE kode LIKE :prefix 
                   ORDER BY kode DESC LIMIT 1";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':prefix', $prefix . '%');
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($result) {
                // Extract number part from RM
                $lastNumber = (int) substr($result->kode, -4);
                return $lastNumber;
            }
            
            // If no existing number found, start from 0
            return 0;
            
        } catch (PDOException $e) {
            error_log("Database Error in getLastNumber: " . $e->getMessage());
            throw new Exception("Gagal mendapatkan nomor RM terakhir");
        }
    }
    
    public function validate($rm) {
        try {
            $sql = "SELECT COUNT(*) as count FROM pasien WHERE kode = :rm";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':rm', $rm);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result->count > 0;
            
        } catch (PDOException $e) {
            error_log("Database Error in validate: " . $e->getMessage());
            throw new Exception("Gagal validasi nomor RM");
        }
    }
}
?> 