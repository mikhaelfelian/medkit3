<?php
class GenerateNoRM {
    protected static $instance = null;
    protected $prefix = 'RM';
    protected $yearFormat = 'y';
    protected $monthFormat = 'm';
    protected $sequenceLength = 4;
    protected $separator = '-';
    
    private function __construct() {
        // Private constructor to prevent direct creation
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Generate new medical record number
     * Format: RM-YYMM-XXXX (e.g., RM-2403-0001)
     */
    public function generate() {
        try {
            // Get current date components
            $year = date($this->yearFormat);
            $month = date($this->monthFormat);
            $yearMonth = $year . $month;
            
            // Get last sequence number from database
            $lastNumber = $this->getLastNumber($yearMonth);
            $nextNumber = $lastNumber + 1;
            
            // Format sequence number with leading zeros
            $sequence = str_pad($nextNumber, $this->sequenceLength, '0', STR_PAD_LEFT);
            
            // Combine all parts
            return implode($this->separator, [
                $this->prefix,
                $yearMonth,
                $sequence
            ]);
        } catch (Exception $e) {
            if (DEBUG_MODE) {
                throw $e;
            }
            // Fallback format if error occurs
            return $this->generateFallback();
        }
    }
    
    /**
     * Get last sequence number for given year and month
     */
    protected function getLastNumber($yearMonth) {
        global $conn;
        
        $sql = "SELECT MAX(SUBSTRING_INDEX(kode, '-', -1)) as last_number 
                FROM tbl_m_pasien 
                WHERE kode LIKE ?";
        
        $pattern = "{$this->prefix}-{$yearMonth}-%";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $pattern);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return intval($row['last_number'] ?? 0);
    }
    
    /**
     * Generate fallback number if normal generation fails
     */
    protected function generateFallback() {
        $timestamp = time();
        $random = mt_rand(1000, 9999);
        return "{$this->prefix}-{$timestamp}-{$random}";
    }
    
    /**
     * Validate medical record number format
     */
    public function isValid($number) {
        $pattern = "/^{$this->prefix}{$this->separator}\d{4}{$this->separator}\d{4}$/";
        return preg_match($pattern, $number);
    }
    
    /**
     * Extract date from medical record number
     */
    public function extractDate($number) {
        $parts = explode($this->separator, $number);
        if (count($parts) !== 3) {
            return null;
        }
        
        $yearMonth = $parts[1];
        $year = '20' . substr($yearMonth, 0, 2);
        $month = substr($yearMonth, 2, 2);
        
        return [
            'year' => $year,
            'month' => $month,
            'full' => "{$year}-{$month}-01"
        ];
    }
    
    /**
     * Set custom prefix
     */
    public function setPrefix($prefix) {
        $this->prefix = $prefix;
        return $this;
    }
    
    /**
     * Set custom sequence length
     */
    public function setSequenceLength($length) {
        $this->sequenceLength = $length;
        return $this;
    }
    
    /**
     * Set custom separator
     */
    public function setSeparator($separator) {
        $this->separator = $separator;
        return $this;
    }
}
?> 