<?php
class BannedUser extends Model {
    protected $table = 'banned_users';
    
    public function isBanned($email) {
        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
    
    public function banUser($email, $bannedBy, $reason = '') {
        try {
            $stmt = $this->db->prepare("INSERT INTO {$this->table} (email, banned_by, reason) VALUES (?, ?, ?)");
            return $stmt->execute([$email, $bannedBy, $reason]);
        } catch (PDOException $e) {
            // User already banned
            return false;
        }
    }
    
    public function unbanUser($email) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE email = ?");
        return $stmt->execute([$email]);
    }
    
    public function getBannedUsers($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $limit = (int)$limit;
        $offset = (int)$offset;
        
        $stmt = $this->db->prepare("
            SELECT bu.*, u.name as banned_by_name 
            FROM {$this->table} bu 
            LEFT JOIN users u ON bu.banned_by = u.id 
            ORDER BY bu.banned_at DESC 
            LIMIT {$limit} OFFSET {$offset}
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getBannedCount() {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM {$this->table}");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
