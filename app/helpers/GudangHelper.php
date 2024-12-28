<?php
/**
 * Generate unique code for gudang
 * Format: GD + YYMM + 3 digit number
 * Example: GD2412001
 */
function generateGudangCode() {
    try {
        // Get database connection
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $year = date('y');
        $month = date('m');
        
        // Get last number from this month
        $sql = "SELECT kode FROM tbl_gudangs 
                WHERE kode LIKE :prefix 
                ORDER BY kode DESC LIMIT 1";
                
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':prefix', "GD{$year}{$month}%");
        $stmt->execute();
        
        $data = $stmt->fetch(PDO::FETCH_OBJ);
        
        if ($data) {
            // Extract the number part (last 3 digits) and increment
            $lastNumber = intval(substr($data->kode, -3));
            $newNumber = $lastNumber + 1;
        } else {
            // Start from 1 if no existing codes
            $newNumber = 1;
        }
        
        // Format: GD + YYMM + 3 digit number
        // Example: GD2412001
        return 'GD' . $year . $month . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        
    } catch (PDOException $e) {
        error_log("Database Error in generateGudangCode: " . $e->getMessage());
        return 'GD' . date('ym') . '001'; // Fallback code if error
    }
} 