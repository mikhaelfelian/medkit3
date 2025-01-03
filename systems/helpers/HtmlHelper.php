<?php
/**
 * HTML Helper Class
 * 
 * Provides helper functions for generating HTML elements
 */
class HtmlHelper {
    
    /**
     * Generate non-breaking spaces
     *
     * @param int $count Number of spaces to generate
     * @return string String of non-breaking spaces
     */
    public static function nbs($count = 1) {
        return str_repeat('&nbsp;', (int)$count);
    }
    
    /**
     * Generate line breaks
     *
     * @param int $count Number of line breaks to generate
     * @return string String of line breaks
     */
    public static function br($count = 1) {
        return str_repeat('<br/>', (int)$count);
    }
    
    /**
     * Generate HTML heading tags
     *
     * @param string $text The text content
     * @param int $level The heading level (1-6)
     * @param array $attributes Optional HTML attributes
     * @return string The formatted heading
     */
    public static function heading($text, $level = 1, $attributes = []) {
        // Validate heading level
        $level = min(6, max(1, (int)$level));
        
        // Build attributes string
        $attr_str = '';
        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                $attr_str .= ' ' . $key . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';
            }
        }
        
        return "<h{$level}{$attr_str}>" . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . "</h{$level}>";
    }
} 