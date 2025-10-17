<?php
class UserRequest extends Model {
    protected $table = 'user_requests';
    
    public function createRequest($data) {
        return $this->create($data);
    }
    
    public function getRequestsByProperty($propertyId) {
        $stmt = $this->db->prepare("
            SELECT ur.*, u.name as user_name, u.email as user_email, u.phone as user_phone
            FROM user_requests ur 
            JOIN users u ON ur.user_id = u.id 
            WHERE ur.property_id = ? 
            ORDER BY ur.created_at DESC
        ");
        $stmt->execute([$propertyId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRequestsByUser($userId) {
        $stmt = $this->db->prepare("
            SELECT ur.*, p.title as property_title, p.property_id as property_ref
            FROM user_requests ur 
            JOIN properties p ON ur.property_id = p.id 
            WHERE ur.user_id = ? 
            ORDER BY ur.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function updateStatus($id, $status) {
        return $this->update($id, ['status' => $status]);
    }
}
