<?php
class UserRequest extends Model {
    protected $table = 'user_requests';
    
    public function createRequest($data) {
        return $this->create($data);
    }
    
    public function getAll($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $limit = (int)$limit; // Ensure it's an integer
        $offset = (int)$offset; // Ensure it's an integer
        $stmt = $this->db->prepare("
            SELECT ur.*, p.title as property_title, p.location as property_location
            FROM {$this->table} ur
            LEFT JOIN properties p ON ur.property_id = p.id
            ORDER BY ur.created_at DESC 
            LIMIT {$limit} OFFSET {$offset}
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRecent($limit = 5) {
        $limit = (int)$limit; // Ensure it's an integer
        $stmt = $this->db->prepare("
            SELECT ur.*, p.title as property_title, p.location as property_location
            FROM {$this->table} ur
            LEFT JOIN properties p ON ur.property_id = p.id
            ORDER BY ur.created_at DESC 
            LIMIT {$limit}
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCount($conditions = []) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $params = [];
        
        if (!empty($conditions)) {
            $whereClause = [];
            foreach ($conditions as $key => $value) {
                $whereClause[] = "{$key} = ?";
                $params[] = $value;
            }
            $sql .= " WHERE " . implode(" AND ", $whereClause);
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET status = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }
}