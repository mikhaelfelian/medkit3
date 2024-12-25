<?php
/**
 * Base Tables Class
 * 
 * Provides common methods for table creation
 */
class BaseTables {
    /**
     * Create table options
     * 
     * @return string
     */
    public static function tableOptions() {
        return "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
    }
    
    /**
     * Create primary key field
     * 
     * @return string
     */
    public static function primaryKey() {
        return "`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY";
    }
    
    /**
     * Create timestamp fields
     * 
     * @return string
     */
    public static function timestamps() {
        return "`created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP";
    }
    
    /**
     * Create varchar field
     * 
     * @param string $name Field name
     * @param int $length Field length
     * @param bool $nullable Whether field is nullable
     * @param string|null $default Default value
     * @return string
     */
    public static function varchar($name, $length = 255, $nullable = true, $default = null) {
        $null = $nullable ? 'NULL' : 'NOT NULL';
        $default = is_null($default) ? '' : "DEFAULT '$default'";
        return "`$name` VARCHAR($length) $null $default";
    }
    
    /**
     * Create text field
     * 
     * @param string $name Field name
     * @param bool $nullable Whether field is nullable
     * @return string
     */
    public static function text($name, $nullable = true) {
        $null = $nullable ? 'NULL' : 'NOT NULL';
        return "`$name` TEXT $null";
    }
    
    /**
     * Create integer field
     * 
     * @param string $name Field name
     * @param bool $nullable Whether field is nullable
     * @param int|null $default Default value
     * @return string
     */
    public static function integer($name, $nullable = true, $default = null) {
        $null = $nullable ? 'NULL' : 'NOT NULL';
        $default = is_null($default) ? '' : "DEFAULT $default";
        return "`$name` INT(11) $null $default";
    }
    
    /**
     * Create decimal field
     * 
     * @param string $name Field name
     * @param int $precision Total digits
     * @param int $scale Decimal places
     * @param bool $nullable Whether field is nullable
     * @param float|null $default Default value
     * @return string
     */
    public static function decimal($name, $precision = 10, $scale = 2, $nullable = true, $default = null) {
        $null = $nullable ? 'NULL' : 'NOT NULL';
        $default = is_null($default) ? '' : "DEFAULT $default";
        return "`$name` DECIMAL($precision,$scale) $null $default";
    }
    
    /**
     * Create enum field
     * 
     * @param string $name Field name
     * @param array $values Enum values
     * @param bool $nullable Whether field is nullable
     * @param string|null $default Default value
     * @return string
     */
    public static function enum($name, $values = [], $nullable = true, $default = null) {
        $values = array_map(function($val) { return "'$val'"; }, $values);
        $valuesStr = implode(',', $values);
        $null = $nullable ? 'NULL' : 'NOT NULL';
        $default = is_null($default) ? '' : "DEFAULT '$default'";
        return "`$name` ENUM($valuesStr) $null $default";
    }
    
    /**
     * Create datetime field
     * 
     * @param string $name Field name
     * @param bool $nullable Whether field is nullable
     * @param string|null $default Default value
     * @return string
     */
    public static function datetime($name, $nullable = true, $default = null) {
        $null = $nullable ? 'NULL' : 'NOT NULL';
        $default = is_null($default) ? '' : "DEFAULT $default";
        return "`$name` DATETIME $null $default";
    }
    
    /**
     * Create float field
     * 
     * @param string $name Field name
     * @param bool $nullable Whether field is nullable
     * @param float|null $default Default value
     * @return string
     */
    public static function float($name, $nullable = true, $default = null) {
        $null = $nullable ? 'NULL' : 'NOT NULL';
        $default = is_null($default) ? '' : "DEFAULT $default";
        return "`$name` FLOAT $null $default";
    }
    
    /**
     * Create timestamp field
     * 
     * @param string $name Field name
     * @param bool $nullable Whether field is nullable
     * @param string|null $default Default value
     * @return string
     */
    public static function timestamp($name, $nullable = true, $default = null) {
        $null = $nullable ? 'NULL' : 'NOT NULL';
        $default = is_null($default) ? '' : "DEFAULT $default";
        return "`$name` TIMESTAMP $null $default";
    }
}
?> 