<?php
class BaseModel {
    protected $conn;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $timestamps = true;
    
    public function __construct($conn) {
        if (!$conn) {
            throw new Exception("Database connection is required");
        }
        $this->conn = $conn;
        
        // If table is not set in child class, use class name
        if (empty($this->table)) {
            // Convert CamelCase to snake_case and remove 'Model' suffix
            $className = (new ReflectionClass($this))->getShortName();
            $className = preg_replace('/Model$/', '', $className);
            $tableName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className));
            $this->table = 'tbl_' . $tableName;
        }
    }
    
    public function getAll($orderBy = null) {
        $sql = "SELECT * FROM {$this->table}";
        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
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
                $fields['created_at'] = date('Y-m-d H:i:s');
                $fields['updated_at'] = date('Y-m-d H:i:s');
            }
            
            $columns = implode(', ', array_keys($fields));
            $values = ':' . implode(', :', array_keys($fields));
            
            $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";
            $stmt = $this->conn->prepare($sql);
            
            foreach ($fields as $key => $value) {
                $stmt->bindValue(":{$key}", $value);
            }
            
            $stmt->execute();
            return $this->conn->lastInsertId();
            
        } catch (PDOException $e) {
            error_log("Database Error in BaseModel::create - " . $e->getMessage());
            throw new Exception("Failed to create record");
        }
    }
    
    public function update($id, $data) {
        try {
            $fields = array_intersect_key($data, array_flip($this->fillable));
            
            if ($this->timestamps) {
                $fields['updated_at'] = date('Y-m-d H:i:s');
            }
            
            $set = [];
            foreach (array_keys($fields) as $field) {
                $set[] = "{$field} = :{$field}";
            }
            
            $sql = "UPDATE {$this->table} SET " . implode(', ', $set) . " WHERE {$this->primaryKey} = :id";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindValue(':id', $id);
            foreach ($fields as $key => $value) {
                $stmt->bindValue(":{$key}", $value);
            }
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Database Error in BaseModel::update - " . $e->getMessage());
            throw new Exception("Failed to update record");
        }
    }
    
    public function delete($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error in BaseModel::delete - " . $e->getMessage());
            throw new Exception("Failed to delete record");
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
}
?> 