<?php
class User extends Model {
    protected $table = 'users';
    
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function authenticate($email, $password) {
        // Check if user is banned first
        $bannedUserModel = new BannedUser();
        if ($bannedUserModel->isBanned($email)) {
            return false; // User is banned, cannot authenticate
        }
        
        $user = $this->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    
    public function createUser($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->create($data);
    }
    
    public function getFavorites($userId) {
        $stmt = $this->db->prepare("
            SELECT p.*, pi.image_path, pi.thumbnail_path 
            FROM user_favorites uf 
            JOIN properties p ON uf.property_id = p.id 
            LEFT JOIN property_images pi ON p.id = pi.property_id AND pi.is_primary = 1
            WHERE uf.user_id = ? 
            ORDER BY uf.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function addFavorite($userId, $propertyId) {
        try {
            $stmt = $this->db->prepare("INSERT INTO user_favorites (user_id, property_id) VALUES (?, ?)");
            $stmt->execute([$userId, $propertyId]);
            return true;
        } catch (PDOException $e) {
            // Duplicate entry - already favorited
            return false;
        }
    }
    
    public function removeFavorite($userId, $propertyId) {
        $stmt = $this->db->prepare("DELETE FROM user_favorites WHERE user_id = ? AND property_id = ?");
        $stmt->execute([$userId, $propertyId]);
        return $stmt->rowCount() > 0;
    }
    
    public function isFavorite($userId, $propertyId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM user_favorites WHERE user_id = ? AND property_id = ?");
        $stmt->execute([$userId, $propertyId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
    
    public function getAll($page = 1, $limit = 10, $conditions = []) {
        $offset = ($page - 1) * $limit;
        $limit = (int)$limit; // Ensure it's an integer
        $offset = (int)$offset; // Ensure it's an integer
        
        $sql = "SELECT u.*, COUNT(ur.id) as request_count FROM {$this->table} u LEFT JOIN user_requests ur ON u.id = ur.user_id";
        $params = [];
        $whereClause = [];
        
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $whereClause[] = "u.{$key} = ?";
                $params[] = $value;
            }
        }
        
        if (!empty($whereClause)) {
            $sql .= " WHERE " . implode(" AND ", $whereClause);
        }
        
        $sql .= " GROUP BY u.id ORDER BY u.created_at DESC LIMIT {$limit} OFFSET {$offset}";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
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
}
