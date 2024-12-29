<?php
class Paginate {
    private $conn;
    private $table;
    private $limit;
    private $page;
    private $query;
    private $total_records;
    private $total_pages;
    
    public function __construct($conn, $table = null) {
        $this->conn = $conn;
        $this->table = $table;
    }
    
    public function setQuery($query) {
        $this->query = $query;
        return $this;
    }
    
    public function getQuery() {
        return $this->query;
    }
    
    public function getData($limit = 10, $page = 1) {
        $this->limit = $limit;
        $this->page = $page;
        
        // Calculate the offset
        $offset = ($this->page - 1) * $this->limit;
        
        // If custom query is set, use it
        if ($this->query) {
            // Get total records without LIMIT
            $total_query = preg_replace('/SELECT (.*?) FROM/', 'SELECT COUNT(*) as total FROM', $this->query);
            $total_query = preg_replace('/ORDER BY(.*?)$/i', '', $total_query);
            $result = mysqli_query($this->conn, $total_query);
            $row = mysqli_fetch_assoc($result);
            $this->total_records = $row['total'];
            
            // Add LIMIT to the query
            $query = $this->query . " LIMIT $offset, $this->limit";
        } else {
            // Use simple table query if no custom query
            $this->total_records = mysqli_fetch_assoc(mysqli_query($this->conn, "SELECT COUNT(*) as total FROM $this->table"))['total'];
            $query = "SELECT * FROM $this->table LIMIT $offset, $this->limit";
        }
        
        // Calculate total pages
        $this->total_pages = ceil($this->total_records / $this->limit);
        
        // Get the records
        $result = mysqli_query($this->conn, $query);
        
        return [
            'data' => $result,
            'total_records' => $this->total_records,
            'total_pages' => $this->total_pages,
            'current_page' => $this->page
        ];
    }
    
    public function createLinks($extra_params = '') {
        if ($this->total_pages <= 1) return '';
        
        $params = $extra_params ? '&' . ltrim($extra_params, '&') : '';
        
        $html = '<ul class="pagination pagination-sm m-0 float-right">';
        
        // Previous button
        if ($this->page > 1) {
            $html .= '<li class="page-item"><a class="page-link" href="?page='.($this->page-1).$params.'">&laquo;</a></li>';
        } else {
            $html .= '<li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>';
        }
        
        // Numbered pages
        $start = max(1, $this->page - 2);
        $end = min($this->total_pages, $this->page + 2);
        
        if ($start > 1) {
            $html .= '<li class="page-item"><a class="page-link" href="?page=1'.$params.'">1</a></li>';
            if ($start > 2) {
                $html .= '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
            }
        }
        
        for ($i = $start; $i <= $end; $i++) {
            if ($i == $this->page) {
                $html .= '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
            } else {
                $html .= '<li class="page-item"><a class="page-link" href="?page='.$i.$params.'">'.$i.'</a></li>';
            }
        }
        
        if ($end < $this->total_pages) {
            if ($end < $this->total_pages - 1) {
                $html .= '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
            }
            $html .= '<li class="page-item"><a class="page-link" href="?page='.$this->total_pages.$params.'">'.$this->total_pages.'</a></li>';
        }
        
        // Next button
        if ($this->page < $this->total_pages) {
            $html .= '<li class="page-item"><a class="page-link" href="?page='.($this->page+1).$params.'">&raquo;</a></li>';
        } else {
            $html .= '<li class="page-item disabled"><a class="page-link" href="#">&raquo;</a></li>';
        }
        
        $html .= '</ul>';
        
        return $html;
    }
}
?> 