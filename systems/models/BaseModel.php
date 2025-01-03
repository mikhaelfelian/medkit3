<?php
class BaseModel {
    protected $conn;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $timestamps = true;
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function getConnection() {
        return $this->conn;
    }
    
    public function get() {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            throw new Exception("Failed to fetch data");
        }
    }
    
    public function find($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error in BaseModel::find - " . $e->getMessage());
            return null;
        }
    }
    
    public function findOne($conditions = []) {
        try {
            $sql = "SELECT * FROM {$this->table}";
            
            if (!empty($conditions)) {
                $where = [];
                foreach ($conditions as $key => $value) {
                    $where[] = "{$key} = :{$key}";
                }
                $sql .= " WHERE " . implode(' AND ', $where);
            }
            
            $sql .= " LIMIT 1";
            
            $stmt = $this->conn->prepare($sql);
            
            if (!empty($conditions)) {
                foreach ($conditions as $key => $value) {
                    $stmt->bindValue(":{$key}", $value);
                }
            }
            
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
            
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }
    
    public function create($data) {
        try {
            $fields = array_intersect_key($data, array_flip($this->fillable));
            
            if ($this->timestamps) {
                if (!isset($fields['created_at'])) {
                    $fields['created_at'] = date('Y-m-d H:i:s');
                }
                if (!isset($fields['updated_at'])) {
                    $fields['updated_at'] = date('Y-m-d H:i:s');
                }
            }
            
            $columns = implode(', ', array_keys($fields));
            $values = implode(', ', array_map(function($field) {
                return ":$field";
            }, array_keys($fields)));
            
            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
            $stmt = $this->conn->prepare($sql);
            
            foreach ($fields as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database Error in create: " . $e->getMessage());
            return false;
        }
    }
    
    public function update($id, $data) {
        try {
            $fields = array_intersect_key($data, array_flip($this->fillable));
            
            if ($this->timestamps && !isset($fields['updated_at'])) {
                $fields['updated_at'] = date('Y-m-d H:i:s');
            }
            
            $set = implode(', ', array_map(function($field) {
                return "$field = :$field";
            }, array_keys($fields)));
            
            $sql = "UPDATE {$this->table} SET $set WHERE {$this->primaryKey} = :id";
            $stmt = $this->conn->prepare($sql);
            
            $fields['id'] = $id;
            foreach ($fields as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database Error in update: " . $e->getMessage());
            return false;
        }
    }
    
    public function delete($id) {
        try {
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error in delete: " . $e->getMessage());
            throw new Exception("Failed to delete record");
        }
    }
    
    public function count() {
        try {
            $sql = "SELECT COUNT(*) as total FROM {$this->table}";
            $stmt = $this->conn->query($sql);
            return $stmt->fetch(PDO::FETCH_OBJ)->total;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return 0;
        }
    }
    
    public function paginate($page = 1, $perPage = 10, $orderBy = null) {
        try {
            // Count total records
            $stmt = $this->conn->query("SELECT COUNT(*) as total FROM {$this->table}");
            $total = $stmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Calculate pagination
            $page = max(1, $page);
            $offset = ($page - 1) * $perPage;
            $lastPage = ceil($total / $perPage);
            
            // Get paginated data
            $sql = "SELECT * FROM {$this->table}";
            if ($orderBy) {
                $sql .= " ORDER BY {$orderBy}";
            }
            $sql .= " LIMIT :offset, :limit";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->execute();
            
            return [
                'data' => $stmt->fetchAll(PDO::FETCH_OBJ),
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => $lastPage
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [
                'data' => [],
                'total' => 0,
                'per_page' => $perPage,
                'current_page' => 1,
                'last_page' => 1
            ];
        }
    }
    
    protected function loadModel($modelName) {
        $modelClass = $modelName . 'Model';
        $modelPath = APP_PATH . '/models/' . $modelClass . '.php';
        
        if (!file_exists($modelPath)) {
            throw new Exception("Model {$modelClass} not found");
        }
        
        require_once $modelPath;
        return new $modelClass($this->conn);
    }
}
?> 