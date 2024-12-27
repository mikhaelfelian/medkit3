<?php

class Paginate {
    protected $config;
    
    public function __construct() {
        if (!defined('CONFIG_PATH')) {
            define('CONFIG_PATH', APP_PATH . '/config');
        }
        
        // Load pagination config
        $this->config = require_once CONFIG_PATH . '/pagination.php';
    }
    
    public function createLinks($currentPage, $perPage, $total, $queryParams = []) {
        $lastPage = ceil($total / $perPage);
        
        if ($lastPage <= 1) {
            return '';
        }
        
        $template = $this->config['templates'][$this->config['template']];
        
        $output = $template['wrapper_start'];
        
        // First page
        if ($currentPage > 1) {
            $output .= $this->createLink(1, $template['first_link'], $queryParams, $template);
        } else {
            $output .= $this->createDisabledLink($template['first_link'], $template);
        }
        
        // Previous page
        if ($currentPage > 1) {
            $output .= $this->createLink($currentPage - 1, $template['prev_link'], $queryParams, $template);
        } else {
            $output .= $this->createDisabledLink($template['prev_link'], $template);
        }
        
        // Numbered pages
        $numLinks = $this->config['num_links'];
        $start = max(1, $currentPage - floor($numLinks / 2));
        $end = min($lastPage, $start + $numLinks - 1);
        
        if ($start > 1) {
            $output .= $this->createEllipsis($template);
        }
        
        for ($i = $start; $i <= $end; $i++) {
            if ($i == $currentPage) {
                $output .= '<li class="page-item active">';
                $output .= '<a class="page-link" href="#">' . $i . '</a>';
                $output .= '</li>';
            } else {
                $output .= $this->createLink($i, $i, $queryParams, $template);
            }
        }
        
        if ($end < $lastPage) {
            $output .= $this->createEllipsis($template);
        }
        
        // Next page
        if ($currentPage < $lastPage) {
            $output .= $this->createLink($currentPage + 1, $template['next_link'], $queryParams, $template);
        } else {
            $output .= $this->createDisabledLink($template['next_link'], $template);
        }
        
        // Last page
        if ($currentPage < $lastPage) {
            $output .= $this->createLink($lastPage, $template['last_link'], $queryParams, $template);
        } else {
            $output .= $this->createDisabledLink($template['last_link'], $template);
        }
        
        $output .= $template['wrapper_end'];
        
        return $output;
    }
    
    protected function createLink($page, $text, $queryParams, $template) {
        $params = array_merge(['page' => $page], $queryParams);
        
        // Get current URL path without query string
        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Build URL with query parameters
        $url = $currentPath . '?' . http_build_query($params);
        
        return '<li class="page-item">' . 
               '<a class="page-link" href="' . $url . '">' . $text . '</a>' . 
               '</li>';
    }
    
    protected function createDisabledLink($text, $template) {
        return '<li class="page-item disabled">' .
               '<a class="page-link" href="#" tabindex="-1">' . $text . '</a>' .
               '</li>';
    }
    
    protected function createEllipsis($template) {
        return '<li class="page-item disabled">' .
               '<a class="page-link" href="#">...</a>' .
               '</li>';
    }
} 