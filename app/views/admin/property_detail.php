<?php
// Admin Property Detail View
require_once APP_PATH . '/components/BaseLayout.php';
$layoutData = [
    'activePage' => 'admin-property-detail',
    'pageTitle' => 'Property Details - Admin Panel',
    'pageDescription' => 'View property details in admin panel',
    'content' => '
    <section class="admin-property-detail">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="admin-header">
                        <h1><i class="fas fa-home"></i> Property Details</h1>
                        <div class="admin-actions">
                            <a href="/admin/properties" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Properties
                            </a>
                            <a href="/admin/properties/edit/' . $property['id'] . '" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Property
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="property-details-card">
                        <div class="property-header">
                            <h2>' . htmlspecialchars($property['title']) . '</h2>
                            <p class="property-description">' . htmlspecialchars($property['short_description']) . '</p>
                            <div class="property-meta">
                                <span class="badge badge-primary">ID: ' . htmlspecialchars($property['property_id']) . '</span>
                                <span class="badge badge-success">Posted: ' . date('M d, Y', strtotime($property['created_at'])) . '</span>
                                <span class="badge badge-info">' . htmlspecialchars($property['location']) . '</span>
                                ' . ($property['featured'] ? '<span class="badge badge-warning">Featured</span>' : '') . '
                            </div>
                        </div>
                        
                        <div class="property-images">
                            <h3><i class="fas fa-images"></i> Property Images</h3>
                            <div class="image-gallery">
                                ' . renderPropertyImages($property['images']) . '
                            </div>
                        </div>
                        
                        <div class="property-description-section">
                            <h3><i class="fas fa-info-circle"></i> Description</h3>
                            <p>' . nl2br(htmlspecialchars($property['description'])) . '</p>
                        </div>
                        
                        <div class="property-features">
                            <h3><i class="fas fa-star"></i> Features & Amenities</h3>
                            <div class="features-grid">
                                ' . renderPropertyFeatures($property['features']) . '
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="property-sidebar">
                        <div class="pricing-card">
                            <h3><i class="fas fa-dollar-sign"></i> Pricing</h3>
                            <div class="price-display">
                                <span class="currency">Rs.</span>
                                <span class="amount">' . number_format($property['price']) . '</span>
                            </div>
                            <div class="property-status">
                                <span class="status-badge status-' . $property['status'] . '">' . ucfirst($property['status']) . '</span>
                            </div>
                        </div>
                        
                        <div class="property-info-card">
                            <h3><i class="fas fa-info-circle"></i> Property Information</h3>
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>Property Type:</label>
                                    <span>' . ucfirst($property['property_type']) . '</span>
                                </div>
                                <div class="info-item">
                                    <label>Bedrooms:</label>
                                    <span>' . $property['bedrooms'] . '</span>
                                </div>
                                <div class="info-item">
                                    <label>Bathrooms:</label>
                                    <span>' . $property['bathrooms'] . '</span>
                                </div>
                                <div class="info-item">
                                    <label>Floors:</label>
                                    <span>' . $property['floors'] . '</span>
                                </div>
                                ' . ($property['area_sqft'] ? '
                                <div class="info-item">
                                    <label>Built Area:</label>
                                    <span>' . number_format($property['area_sqft']) . ' sq ft</span>
                                </div>' : '') . '
                                ' . ($property['land_area_sqft'] ? '
                                <div class="info-item">
                                    <label>Land Area:</label>
                                    <span>' . number_format($property['land_area_sqft']) . ' sq ft</span>
                                </div>' : '') . '
                            </div>
                        </div>
                        
                        <div class="location-card">
                            <h3><i class="fas fa-map-marker-alt"></i> Location</h3>
                            <div class="location-info">
                                <p><strong>Address:</strong><br>' . htmlspecialchars($property['address']) . '</p>
                                <p><strong>City:</strong> ' . htmlspecialchars($property['city']) . '</p>
                                <p><strong>District:</strong> ' . htmlspecialchars($property['district']) . '</p>
                                ' . ($property['latitude'] && $property['longitude'] ? '
                                <p><strong>Coordinates:</strong><br>
                                Lat: ' . $property['latitude'] . '<br>
                                Lng: ' . $property['longitude'] . '</p>' : '') . '
                            </div>
                        </div>
                        
                        <div class="admin-actions-card">
                            <h3><i class="fas fa-cogs"></i> Admin Actions</h3>
                            <div class="action-buttons">
                                <a href="/admin/properties/edit/' . $property['id'] . '" class="btn btn-primary btn-block">
                                    <i class="fas fa-edit"></i> Edit Property
                                </a>
                                <button class="btn btn-warning btn-block" onclick="toggleFeatured(' . $property['id'] . ')">
                                    <i class="fas fa-star"></i> ' . ($property['featured'] ? 'Remove from Featured' : 'Add to Featured') . '
                                </button>
                                <button class="btn btn-danger btn-block" onclick="deleteProperty(' . $property['id'] . ')">
                                    <i class="fas fa-trash"></i> Delete Property
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <style>
    .admin-property-detail {
        padding: 20px 0;
        background-color: #f8f9fa;
        min-height: 100vh;
    }
    
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .admin-header h1 {
        color: var(--primary-color);
        margin: 0;
        font-size: 2rem;
    }
    
    .admin-actions {
        display: flex;
        gap: 10px;
    }
    
    .property-details-card {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    
    .property-header h2 {
        color: var(--primary-color);
        margin-bottom: 10px;
        font-size: 1.8rem;
    }
    
    .property-description {
        color: #666;
        font-size: 1.1rem;
        margin-bottom: 20px;
    }
    
    .property-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 30px;
    }
    
    .badge {
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .badge-primary { background: var(--primary-color); color: white; }
    .badge-success { background: #28a745; color: white; }
    .badge-info { background: #17a2b8; color: white; }
    .badge-warning { background: #ffc107; color: #212529; }
    
    .property-images h3,
    .property-description-section h3,
    .property-features h3 {
        color: var(--primary-color);
        margin-bottom: 20px;
        font-size: 1.3rem;
    }
    
    .image-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }
    
    .image-item {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .image-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    
    .image-item.primary::after {
        content: "Primary";
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--primary-color);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }
    
    .feature-item {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid var(--primary-color);
    }
    
    .feature-item strong {
        color: var(--primary-color);
        display: block;
        margin-bottom: 5px;
    }
    
    .property-sidebar {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .pricing-card,
    .property-info-card,
    .location-card,
    .admin-actions-card {
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .pricing-card h3,
    .property-info-card h3,
    .location-card h3,
    .admin-actions-card h3 {
        color: var(--primary-color);
        margin-bottom: 20px;
        font-size: 1.2rem;
    }
    
    .price-display {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .price-display .currency {
        font-size: 1.2rem;
        color: #666;
    }
    
    .price-display .amount {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--primary-color);
    }
    
    .status-badge {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.9rem;
    }
    
    .status-available { background: #d4edda; color: #155724; }
    .status-sold { background: #f8d7da; color: #721c24; }
    .status-rented { background: #fff3cd; color: #856404; }
    
    .info-grid {
        display: grid;
        gap: 15px;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-item label {
        font-weight: 600;
        color: #666;
    }
    
    .info-item span {
        color: var(--primary-color);
        font-weight: 500;
    }
    
    .location-info p {
        margin-bottom: 15px;
        line-height: 1.6;
    }
    
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-block {
        width: 100%;
        margin-bottom: 10px;
    }
    
    @media (max-width: 768px) {
        .admin-header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
        
        .admin-actions {
            flex-direction: column;
            width: 100%;
        }
        
        .price-display .amount {
            font-size: 2rem;
        }
        
        .features-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
    
    <script>
    function toggleFeatured(propertyId) {
        if (confirm("Are you sure you want to toggle the featured status of this property?")) {
            // Implementation for toggling featured status
            console.log("Toggle featured for property:", propertyId);
        }
    }
    
    function deleteProperty(propertyId) {
        if (confirm("Are you sure you want to delete this property? This action cannot be undone.")) {
            // Implementation for deleting property
            console.log("Delete property:", propertyId);
        }
    }
    </script>
    ',
    'csrfToken' => $csrfToken ?? ''
];

// Helper functions
function renderPropertyImages($images) {
    if (empty($images)) {
        return '<div class="no-images"><i class="fas fa-image"></i> No images available</div>';
    }
    
    $html = '';
    foreach ($images as $image) {
        $primaryClass = $image['is_primary'] ? 'primary' : '';
        $html .= '
        <div class="image-item ' . $primaryClass . '">
            <img src="' . htmlspecialchars($image['image_path']) . '" alt="' . htmlspecialchars($image['alt_text']) . '">
        </div>';
    }
    return $html;
}

function renderPropertyFeatures($features) {
    if (empty($features)) {
        return '<div class="no-features"><i class="fas fa-star"></i> No features listed</div>';
    }
    
    $html = '';
    foreach ($features as $feature) {
        $html .= '
        <div class="feature-item">
            <strong>' . htmlspecialchars($feature['feature_name']) . '</strong>
            ' . ($feature['feature_value'] ? htmlspecialchars($feature['feature_value']) : 'Yes') . '
        </div>';
    }
    return $html;
}

// Render the layout
$layout = new BaseLayout($layoutData);
echo $layout->render();
?>
