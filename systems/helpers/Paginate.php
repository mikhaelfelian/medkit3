<?php
class Paginate {
    public function createLinks($currentPage, $perPage, $total, $params = []) {
        $lastPage = ceil($total / $perPage);
        
        if ($lastPage <= 1) {
            return '';
        }
        
        $html = '<ul class="pagination pagination-sm m-0 float-right">';
        
        // Previous button
        if ($currentPage > 1) {
            $params['page'] = $currentPage - 1;
            $html .= '<li class="page-item">';
            $html .= '<a class="page-link rounded-0" href="' . $this->buildUrl($params) . '">&laquo;</a>';
            $html .= '</li>';
        } else {
            $html .= '<li class="page-item disabled">';
            $html .= '<a class="page-link rounded-0" href="#">&laquo;</a>';
            $html .= '</li>';
        }
        
        // Page numbers
        $start = max(1, $currentPage - 2);
        $end = min($lastPage, $currentPage + 2);
        
        if ($start > 1) {
            $params['page'] = 1;
            $html .= '<li class="page-item">';
            $html .= '<a class="page-link rounded-0" href="' . $this->buildUrl($params) . '">1</a>';
            $html .= '</li>';
            if ($start > 2) {
                $html .= '<li class="page-item disabled">';
                $html .= '<a class="page-link rounded-0" href="#">...</a>';
                $html .= '</li>';
            }
        }
        
        for ($i = $start; $i <= $end; $i++) {
            $params['page'] = $i;
            if ($i == $currentPage) {
                $html .= '<li class="page-item active">';
                $html .= '<a class="page-link rounded-0" href="#">' . $i . '</a>';
                $html .= '</li>';
            } else {
                $html .= '<li class="page-item">';
                $html .= '<a class="page-link rounded-0" href="' . $this->buildUrl($params) . '">' . $i . '</a>';
                $html .= '</li>';
            }
        }
        
        if ($end < $lastPage) {
            if ($end < $lastPage - 1) {
                $html .= '<li class="page-item disabled">';
                $html .= '<a class="page-link rounded-0" href="#">...</a>';
                $html .= '</li>';
            }
            $params['page'] = $lastPage;
            $html .= '<li class="page-item">';
            $html .= '<a class="page-link rounded-0" href="' . $this->buildUrl($params) . '">' . $lastPage . '</a>';
            $html .= '</li>';
        }
        
        // Next button
        if ($currentPage < $lastPage) {
            $params['page'] = $currentPage + 1;
            $html .= '<li class="page-item">';
            $html .= '<a class="page-link rounded-0" href="' . $this->buildUrl($params) . '">&raquo;</a>';
            $html .= '</li>';
        } else {
            $html .= '<li class="page-item disabled">';
            $html .= '<a class="page-link rounded-0" href="#">&raquo;</a>';
            $html .= '</li>';
        }
        
        $html .= '</ul>';
        
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