<?php
class PaginateHelper {
    protected static $config;
    
    protected static function getConfig() {
        if (self::$config === null) {
            self::$config = require CONFIG_PATH . '/pagination.php';
        }
        return self::$config;
    }
    
    public static function createLinks($page, $perPage, $total, $queryParams = []) {
        $totalPages = self::getTotalPages($total, $perPage);
        if ($totalPages <= 1) return '';
        
        $pageNumbers = self::getPageNumbers($page, $totalPages);
        $template = self::getConfig()['template'];
        $items = [];
        
        // Previous button
        if ($page > 1) {
            $items[] = self::createPageLink($page - 1, $template['previous'], $queryParams);
        } else {
            $items[] = sprintf($template['disabled_item'], $template['previous']);
        }
        
        // Page numbers
        foreach ($pageNumbers as $pageNum) {
            if ($pageNum === '...') {
                $items[] = sprintf($template['disabled_item'], $template['dots']);
            } else {
                $items[] = self::createPageLink($pageNum, $pageNum, $queryParams, $pageNum == $page);
            }
        }
        
        // Next button
        if ($page < $totalPages) {
            $items[] = self::createPageLink($page + 1, $template['next'], $queryParams);
        } else {
            $items[] = sprintf($template['disabled_item'], $template['next']);
        }
        
        return sprintf($template['wrapper'], implode('', $items));
    }
    
    protected static function createPageLink($page, $text, $queryParams = [], $isActive = false) {
        $params = array_merge(['page' => $page], $queryParams);
        
        // Get the current route from the URL
        $uri = $_SERVER['REQUEST_URI'];
        $path = explode('?', $uri)[0];
        $segments = explode('/', trim($path, '/'));
        
        // Remove the base folder name and index.php if present
        $segments = array_filter($segments, function($segment) {
            return !in_array($segment, ['medkit3', 'index.php']);
        });
        
        // Get the current route (first segment after filtering)
        $currentRoute = reset($segments) ?: '';
        
        $url = BaseRouting::url($currentRoute, $params);
        $template = self::getConfig()['template'];
        
        if ($isActive) {
            return sprintf($template['active_item'], $text);
        }
        
        return sprintf($template['item'], $url, $text);
    }
    
    public static function getOffset($page, $perPage) {
        return ($page - 1) * $perPage;
    }
    
    public static function getTotalPages($total, $perPage) {
        return ceil($total / $perPage);
    }
    
    public static function getPageNumbers($currentPage, $totalPages, $maxLinks = 5) {
        $pages = [];
        
        if ($totalPages <= $maxLinks) {
            return range(1, $totalPages);
        }
        
        $halfMax = floor($maxLinks / 2);
        $start = max(1, min($currentPage - $halfMax, $totalPages - $maxLinks + 1));
        $end = min($totalPages, $start + $maxLinks - 1);
        
        if ($start > 1) {
            $pages[] = 1;
            if ($start > 2) $pages[] = '...';
        }
        
        for ($i = $start; $i <= $end; $i++) {
            $pages[] = $i;
        }
        
        if ($end < $totalPages) {
            if ($end < $totalPages - 1) $pages[] = '...';
            $pages[] = $totalPages;
        }
        
        return $pages;
    }
} 