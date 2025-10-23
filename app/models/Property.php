<?php
class Property extends Model {
    protected $table = 'properties';
    
    public function getWithImages($id) {
        $property = $this->find($id);
        if ($property) {
            $property['images'] = $this->getImages($id);
            $property['features'] = $this->getFeatures($id);
        }
        return $property;
    }
    
    public function getImages($propertyId) {
        // Always return primary image first
        $stmt = $this->db->prepare("SELECT * FROM property_images WHERE property_id = ? ORDER BY is_primary DESC, sort_order, id");
        $stmt->execute([$propertyId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getFeatures($propertyId) {
        $stmt = $this->db->prepare("SELECT feature_name, feature_value FROM property_features WHERE property_id = ? ORDER BY feature_name");
        $stmt->execute([$propertyId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getSimilarProperties($propertyId, $limit = 4) {
        $property = $this->find($propertyId);
        if (!$property) return [];
        
        $limit = (int)$limit; // Ensure it's an integer
        $stmt = $this->db->prepare("
            SELECT p.*, pi.image_path, pi.thumbnail_path 
            FROM properties p 
            LEFT JOIN property_images pi ON p.id = pi.property_id AND pi.is_primary = 1
            WHERE p.id != ? 
            AND p.status = 'available' 
            AND (p.city = ? OR p.property_type = ? OR ABS(p.price - ?) < ?)
            ORDER BY 
                CASE WHEN p.city = ? THEN 1 ELSE 2 END,
                ABS(p.price - ?)
            LIMIT {$limit}
        ");
        
        $priceRange = $property['price'] * 0.3; // 30% price range
        $stmt->execute([
            $propertyId, 
            $property['city'], 
            $property['property_type'], 
            $property['price'], 
            $priceRange,
            $property['city'],
            $property['price']
        ]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function search($filters = [], $page = 1, $limit = ITEMS_PER_PAGE) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT p.*, 
                       GROUP_CONCAT(pi.image_path ORDER BY (CASE WHEN pi.is_primary = 1 THEN 0 ELSE 1 END), pi.id ASC) as images,
                       GROUP_CONCAT(CASE WHEN pf.feature_name = 'Parking' THEN pf.feature_value END) as parking
                FROM properties p 
                LEFT JOIN property_images pi ON p.id = pi.property_id
                LEFT JOIN property_features pf ON p.id = pf.property_id AND pf.feature_name = 'Parking'
                WHERE p.status = 'available'";
        
        $params = [];
        
        if (!empty($filters['city'])) {
            $sql .= " AND p.city = ?";
            $params[] = $filters['city'];
        }
        
        if (!empty($filters['property_type'])) {
            $sql .= " AND p.property_type = ?";
            $params[] = $filters['property_type'];
        }
        
        if (!empty($filters['min_price'])) {
            $sql .= " AND p.price >= ?";
            $params[] = $filters['min_price'];
        }
        
        if (!empty($filters['max_price'])) {
            $sql .= " AND p.price <= ?";
            $params[] = $filters['max_price'];
        }
        
        if (!empty($filters['bedrooms'])) {
            $sql .= " AND p.bedrooms >= ?";
            $params[] = $filters['bedrooms'];
        }
        
        if (!empty($filters['bathrooms'])) {
            $sql .= " AND p.bathrooms >= ?";
            $params[] = $filters['bathrooms'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND p.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['search'])) {
            $sql .= " AND (p.title LIKE ? OR p.description LIKE ? OR p.location LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $sql .= " GROUP BY p.id ORDER BY p.featured DESC, p.created_at DESC LIMIT {$limit} OFFSET {$offset}";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCount($filters = []) {
        $sql = "SELECT COUNT(*) as total FROM properties p";
        $params = [];
        $whereClause = [];
        
        // For admin, show all properties regardless of status
        if (!isset($filters['admin']) || !$filters['admin']) {
            $whereClause[] = "p.status = 'available'";
        }
        
        if (!empty($filters['city'])) {
            $whereClause[] = "p.city = ?";
            $params[] = $filters['city'];
        }
        
        if (!empty($filters['property_type'])) {
            $whereClause[] = "p.property_type = ?";
            $params[] = $filters['property_type'];
        }
        
        if (!empty($filters['min_price'])) {
            $whereClause[] = "p.price >= ?";
            $params[] = $filters['min_price'];
        }
        
        if (!empty($filters['max_price'])) {
            $whereClause[] = "p.price <= ?";
            $params[] = $filters['max_price'];
        }
        
        if (!empty($filters['bedrooms'])) {
            $whereClause[] = "p.bedrooms >= ?";
            $params[] = $filters['bedrooms'];
        }
        
        if (!empty($filters['bathrooms'])) {
            $whereClause[] = "p.bathrooms >= ?";
            $params[] = $filters['bathrooms'];
        }
        
        if (!empty($filters['status'])) {
            $whereClause[] = "p.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['featured'])) {
            $whereClause[] = "p.featured = ?";
            $params[] = $filters['featured'];
        }
        
        if (!empty($filters['search'])) {
            $whereClause[] = "(p.title LIKE ? OR p.description LIKE ? OR p.location LIKE ?)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        if (!empty($whereClause)) {
            $sql .= " WHERE " . implode(" AND ", $whereClause);
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function findByPropertyId($propertyId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE property_id = ?");
        $stmt->execute([$propertyId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function addImage($propertyId, $imagePath, $thumbnailPath = null, $altText = '', $isPrimary = false) {
        $data = [
            'property_id' => $propertyId,
            'image_path' => $imagePath,
            'thumbnail_path' => $thumbnailPath,
            'alt_text' => $altText,
            'is_primary' => $isPrimary ? 1 : 0
        ];
        
        return $this->db->prepare("INSERT INTO property_images (property_id, image_path, thumbnail_path, alt_text, is_primary) VALUES (?, ?, ?, ?, ?)")
            ->execute([$data['property_id'], $data['image_path'], $data['thumbnail_path'], $data['alt_text'], $data['is_primary']]);
    }
    
    public function addFeature($propertyId, $featureName, $featureValue = null) {
        $data = [
            'property_id' => $propertyId,
            'feature_name' => $featureName,
            'feature_value' => $featureValue
        ];
        
        return $this->db->prepare("INSERT INTO property_features (property_id, feature_name, feature_value) VALUES (?, ?, ?)")
            ->execute([$data['property_id'], $data['feature_name'], $data['feature_value']]);
    }

    public function deleteFeatures($propertyId) {
        $stmt = $this->db->prepare("DELETE FROM property_features WHERE property_id = ?");
        return $stmt->execute([$propertyId]);
    }
    
    public function updateImagePrimary($imageId, $isPrimary) {
        $stmt = $this->db->prepare("UPDATE property_images SET is_primary = ? WHERE id = ?");
        return $stmt->execute([$isPrimary, $imageId]);
    }
    
    public function removeImagePrimary($propertyId) {
        $stmt = $this->db->prepare("UPDATE property_images SET is_primary = 0 WHERE property_id = ?");
        return $stmt->execute([$propertyId]);
    }
    
    public function getPrimaryImage($propertyId) {
        $stmt = $this->db->prepare("SELECT * FROM property_images WHERE property_id = ? AND is_primary = 1 LIMIT 1");
        $stmt->execute([$propertyId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateImagePath($imageId, $imagePath, $thumbnailPath = null, $altText = null) {
        $sql = "UPDATE property_images SET image_path = ?, thumbnail_path = COALESCE(?, thumbnail_path), alt_text = COALESCE(?, alt_text) WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$imagePath, $thumbnailPath, $altText, $imageId]);
    }

    public function deleteImage($imageId) {
        $stmt = $this->db->prepare("DELETE FROM property_images WHERE id = ?");
        return $stmt->execute([$imageId]);
    }
    
    public function getImageById($imageId) {
        $stmt = $this->db->prepare("SELECT * FROM property_images WHERE id = ?");
        $stmt->execute([$imageId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
