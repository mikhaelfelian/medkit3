<?php
class Paginate {
    protected $config;
    protected $template;
    
    public function __construct($template = 'default') {
        $this->config = require_once CONFIG_PATH . '/pagination.php';
        $this->setTemplate($template);
    }
    
    public function setTemplate($template) {
        if (!isset($this->config['templates'][$template])) {
            throw new Exception("Pagination template '{$template}' not found");
        }
        $this->template = $this->config['templates'][$template];
    }
    
    public function createLinks($currentPage, $perPage, $total, $params = []) {
        $lastPage = ceil($total / $perPage);
        
        if ($lastPage <= 1) {
            return '';
        }
        
        $html = $this->template['wrapper_start'];
        
        // Previous button
        if ($currentPage > 1) {
            $params['page'] = $currentPage - 1;
            $html .= $this->template['item_start'];
            $html .= $this->template['link_start'] . $this->buildUrl($params) . 
                    $this->template['link_mid'] . $this->template['prev_symbol'] . 
                    $this->template['link_end'];
            $html .= $this->template['item_end'];
        } else {
            $html .= $this->template['disabled_item_start'];
            $html .= $this->template['disabled_link'] . 
                    $this->template['prev_symbol'] . 
                    $this->template['link_end'];
            $html .= $this->template['disabled_item_end'];
        }
        
        // Page numbers
        $start = max(1, $currentPage - 2);
        $end = min($lastPage, $currentPage + 2);
        
        if ($start > 1) {
            $params['page'] = 1;
            $html .= $this->template['item_start'];
            $html .= $this->template['link_start'] . $this->buildUrl($params) . 
                    $this->template['link_mid'] . '1' . 
                    $this->template['link_end'];
            $html .= $this->template['item_end'];
            
            if ($start > 2) {
                $html .= $this->template['disabled_item_start'];
                $html .= $this->template['disabled_link'] . 
                        $this->template['dots_symbol'] . 
                        $this->template['link_end'];
                $html .= $this->template['disabled_item_end'];
            }
        }
        
        for ($i = $start; $i <= $end; $i++) {
            $params['page'] = $i;
            if ($i == $currentPage) {
                $html .= $this->template['active_item_start'];
                $html .= $this->template['active_link'] . $i . 
                        $this->template['link_end'];
                $html .= $this->template['active_item_end'];
            } else {
                $html .= $this->template['item_start'];
                $html .= $this->template['link_start'] . $this->buildUrl($params) . 
                        $this->template['link_mid'] . $i . 
                        $this->template['link_end'];
                $html .= $this->template['item_end'];
            }
        }
        
        if ($end < $lastPage) {
            if ($end < $lastPage - 1) {
                $html .= $this->template['disabled_item_start'];
                $html .= $this->template['disabled_link'] . 
                        $this->template['dots_symbol'] . 
                        $this->template['link_end'];
                $html .= $this->template['disabled_item_end'];
            }
            
            $params['page'] = $lastPage;
            $html .= $this->template['item_start'];
            $html .= $this->template['link_start'] . $this->buildUrl($params) . 
                    $this->template['link_mid'] . $lastPage . 
                    $this->template['link_end'];
            $html .= $this->template['item_end'];
        }
        
        // Next button
        if ($currentPage < $lastPage) {
            $params['page'] = $currentPage + 1;
            $html .= $this->template['item_start'];
            $html .= $this->template['link_start'] . $this->buildUrl($params) . 
                    $this->template['link_mid'] . $this->template['next_symbol'] . 
                    $this->template['link_end'];
            $html .= $this->template['item_end'];
        } else {
            $html .= $this->template['disabled_item_start'];
            $html .= $this->template['disabled_link'] . 
                    $this->template['next_symbol'] . 
                    $this->template['link_end'];
            $html .= $this->template['disabled_item_end'];
        }
        
        $html .= $this->template['wrapper_end'];
        
        return $html;
    }
    
    protected function buildUrl($params) {
        $currentUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (!empty($params)) {
            return $currentUrl . '?' . http_build_query($params);
        }
        return $currentUrl;
    }
} 