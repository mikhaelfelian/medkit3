<?php
class BaseModel {
    protected $conn;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $timestamps = true;

    public function __construct($conn, $table) {
        $this->conn = $conn;
        $this->table = $table;
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

    public function create($data) {
        try {
            $fields = array_intersect_key($data, array_flip($this->fillable));
            
            $columns = implode(', ', array_keys($fields));
            $values = ':' . implode(', :', array_keys($fields));
            
            $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";
            $stmt = $this->conn->prepare($sql);
            
            foreach ($fields as $key => $value) {
                $stmt->bindValue(":{$key}", $value);
            }
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database Error in BaseModel::create - " . $e->getMessage());
            throw new Exception("Failed to create record");
        }
    }

    public function update($id, $data) {
        try {
            $fields = array_intersect_key($data, array_flip($this->fillable));
            
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

    public function where($column, $operator, $value = null) {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        
        $sql = "SELECT * FROM {$this->table} WHERE {$column} {$operator} :value";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function search($columns, $keyword, $page = 1, $perPage = 10) {
        try {
            $conditions = [];
            $params = [];
            foreach ($columns as $index => $column) {
                $param = "param{$index}";
                $conditions[] = "{$column} LIKE :{$param}";
                $params[$param] = "%{$keyword}%";
            }
            
            $whereClause = implode(' OR ', $conditions);
            
            // Get total records
            $countSql = "SELECT COUNT(*) as total FROM {$this->table} WHERE " . $whereClause;
            $countStmt = $this->conn->prepare($countSql);
            $countStmt->execute($params);
            $total = $countStmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Calculate pagination
            $lastPage = ceil($total / $perPage);
            $currentPage = max(1, min($page, $lastPage));
            $offset = ($currentPage - 1) * $perPage;
            
            // Get paginated records
            $sql = "SELECT * FROM {$this->table} WHERE " . $whereClause . " LIMIT :offset, :limit";
            $stmt = $this->conn->prepare($sql);
            
            // Bind all parameters
            foreach ($params as $key => $value) {
                $stmt->bindValue(":{$key}", $value);
            }
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            
            $stmt->execute();
            
            return [
                'data' => $stmt->fetchAll(PDO::FETCH_OBJ),
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $currentPage,
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

    public function paginate($page = 1, $perPage = 10, $orderBy = '') {
        try {
            // Count total records
            $countSql = "SELECT COUNT(*) as total FROM {$this->table}";
            $countStmt = $this->conn->query($countSql);
            $total = $countStmt->fetch(PDO::FETCH_OBJ)->total;
            
            // Calculate pagination
            $lastPage = ceil($total / $perPage);
            $currentPage = max(1, min($page, $lastPage));
            $offset = ($currentPage - 1) * $perPage;
            
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
                'current_page' => $currentPage,
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

    public function findOne($conditions = []) {
        $sql = "SELECT * FROM {$this->table}";
        
        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $key => $value) {
                $where[] = "{$key} = :{$key}";
            }
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        
        $sql .= " LIMIT 1";
        
        try {
            $stmt = $this->conn->prepare($sql);
            
            if (!empty($conditions)) {
                $stmt->execute($conditions);
            } else {
                $stmt->execute();
            }
            
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }

    protected function filterFillable($data) {
        if (empty($this->fillable)) {
            return $data;
        }
        return array_intersect_key($data, array_flip($this->fillable));
    }
}
?> 