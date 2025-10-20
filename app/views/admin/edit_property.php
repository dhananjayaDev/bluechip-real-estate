<?php
// Initialize components
require_once APP_PATH . '/components/BaseLayout.php';

// Prepare data for components
$layoutData = [
    'pageTitle' => 'Edit Property - Admin Dashboard',
    'pageDescription' => 'Edit property details',
    'activePage' => 'admin-properties',
    'csrfToken' => $csrfToken ?? '',
    'includeModals' => false,
    'email' => 'hello@bluechiplands.asia',
    'phone' => '(+94) 71 609 2918',
    'logoPath' => '/public/images/uploads/logo.jpeg',
    'companyName' => 'Bluechip Real Estate (Pvt) Limited',
    'tagline' => 'අපේ රටේ ඉඩමක් ගන්න හොඳම තැන',
    'aboutText' => 'Bluechip Real Estate (PVT) Limited has been established with the vision To deliver the highest value in real estate industry through innovation and integrity.',
    'address' => 'World Trade Center, West Tower,<br>Level 37, Colombo 01, Sri Lanka',
    'facebookUrl' => 'https://www.facebook.com/p/Bluechip-Real-Estate-100091440704853/',
    'whatsappUrl' => 'https://wa.me/94716092918'
];

// Create the page content
$pageContent = '
    <!-- Edit Property Form Section -->
    <section class="admin-edit-property">
        <div class="container">
            <div class="form-header">
                <h1>Edit Property</h1>
                <p>Update the property details below</p>
            </div>

            <form id="editPropertyForm" method="POST" action="/admin/properties/' . $property['id'] . '/update" enctype="multipart/form-data" class="property-form">
                <input type="hidden" name="csrf_token" value="' . ($csrfToken ?? '') . '">
                
                <!-- Section 1: Basic Information -->
                <div class="form-section">
                    <h2><i class="fas fa-info-circle"></i> Basic Information</h2>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="title">Property Title <span class="required">*</span></label>
                                <input type="text" id="title" name="title" class="form-control" required maxlength="200" value="' . htmlspecialchars($property['title']) . '" placeholder="e.g., 3-Bedroom Luxury Apartment in Colombo 07">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="property_id">Property ID <span class="required">*</span></label>
                                <input type="text" id="property_id" name="property_id" class="form-control" required maxlength="50" value="' . htmlspecialchars($property['property_id']) . '" placeholder="e.g., PROP001">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="short_description">Short Description <span class="required">*</span></label>
                                <textarea id="short_description" name="short_description" class="form-control" required maxlength="500" rows="3" placeholder="Brief description for listings">' . htmlspecialchars($property['short_description']) . '</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Full Description <span class="required">*</span></label>
                                <textarea id="description" name="description" class="form-control" required rows="3" placeholder="Detailed property description">' . htmlspecialchars($property['description']) . '</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Pricing -->
                <div class="form-section">
                    <h2><i class="fas fa-dollar-sign"></i> Pricing</h2>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="price">Price <span class="required">*</span></label>
                                <input type="number" id="price" name="price" class="form-control" required min="0" step="1" value="' . $property['price'] . '" placeholder="Enter price">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <select id="currency" name="currency" class="form-control">
                                    <option value="LKR" ' . ($property['currency'] === 'LKR' ? 'selected' : '') . '>LKR (Sri Lankan Rupee)</option>
                                    <option value="USD" ' . ($property['currency'] === 'USD' ? 'selected' : '') . '>USD (US Dollar)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Property Details -->
                <div class="form-section">
                    <h2><i class="fas fa-home"></i> Property Details</h2>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="property_type">Property Type <span class="required">*</span></label>
                                <select id="property_type" name="property_type" class="form-control" required>
                                    <option value="">Select Type</option>
                                    <option value="house" ' . ($property['property_type'] === 'house' ? 'selected' : '') . '>House</option>
                                    <option value="apartment" ' . ($property['property_type'] === 'apartment' ? 'selected' : '') . '>Apartment</option>
                                    <option value="condo" ' . ($property['property_type'] === 'condo' ? 'selected' : '') . '>Condo</option>
                                    <option value="villa" ' . ($property['property_type'] === 'villa' ? 'selected' : '') . '>Villa</option>
                                    <option value="land" ' . ($property['property_type'] === 'land' ? 'selected' : '') . '>Land</option>
                                    <option value="commercial" ' . ($property['property_type'] === 'commercial' ? 'selected' : '') . '>Commercial</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="bedrooms">Bedrooms <span class="required">*</span></label>
                                <input type="number" id="bedrooms" name="bedrooms" class="form-control" required min="0" max="20" value="' . $property['bedrooms'] . '">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="bathrooms">Bathrooms <span class="required">*</span></label>
                                <input type="number" id="bathrooms" name="bathrooms" class="form-control" required min="0" max="20" value="' . $property['bathrooms'] . '">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="floors">Floors</label>
                                <input type="number" id="floors" name="floors" class="form-control" min="1" max="50" value="' . $property['floors'] . '">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="area_sqft">Area (sq ft)</label>
                                <input type="number" id="area_sqft" name="area_sqft" class="form-control" min="0" step="0.01" value="' . $property['area_sqft'] . '" placeholder="Building area">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="land_area_sqft">Land Area (sq ft)</label>
                                <input type="number" id="land_area_sqft" name="land_area_sqft" class="form-control" min="0" step="0.01" value="' . $property['land_area_sqft'] . '" placeholder="Total land area">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="available" ' . ($property['status'] === 'available' ? 'selected' : '') . '>Available</option>
                                    <option value="unavailable" ' . ($property['status'] === 'unavailable' ? 'selected' : '') . '>Unavailable</option>
                                    <option value="sold" ' . ($property['status'] === 'sold' ? 'selected' : '') . '>Sold</option>
                                    <option value="rented" ' . ($property['status'] === 'rented' ? 'selected' : '') . '>Rented</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Location -->
                <div class="form-section">
                    <h2><i class="fas fa-map-marker-alt"></i> Location</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="location">Location <span class="required">*</span></label>
                                <input type="text" id="location" name="location" class="form-control" required maxlength="100" value="' . htmlspecialchars($property['location']) . '" placeholder="e.g., Colombo 07">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="city">City <span class="required">*</span></label>
                                <input type="text" id="city" name="city" class="form-control" required maxlength="50" value="' . htmlspecialchars($property['city']) . '" placeholder="e.g., Colombo">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="district">District <span class="required">*</span></label>
                                <input type="text" id="district" name="district" class="form-control" required maxlength="50" value="' . htmlspecialchars($property['district']) . '" placeholder="e.g., Colombo">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="address">Full Address <span class="required">*</span></label>
                                <textarea id="address" name="address" class="form-control" required rows="2" placeholder="Complete address">' . htmlspecialchars($property['address']) . '</textarea>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="number" id="latitude" name="latitude" class="form-control" step="any" value="' . $property['latitude'] . '" placeholder="6.9271">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="number" id="longitude" name="longitude" class="form-control" step="any" value="' . $property['longitude'] . '" placeholder="79.8612">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 5: Images -->
                <div class="form-section">
                    <h2><i class="fas fa-images"></i> Property Images</h2>
                    
                    <!-- Primary Image (separate) -->
                    <div class="primary-image-upload" style="margin-bottom:20px;">
                        <h4>Primary Image</h4>
                        <div class="row" style="align-items:center; gap:15px;">
                            <div>
                                <div id="primaryImagePreview" style="width:140px;height:100px;border:1px solid #ddd;border-radius:8px;overflow:hidden;background:#f9fafb;display:flex;align-items:center;justify-content:center;">
                                    <img src="' . (!empty($property['images']) ? htmlspecialchars($property['images'][0]['image_path']) : '') . '" alt="Primary" style="max-width:100%;max-height:100%;' . (empty($property['images']) ? 'display:none;' : '') . '">
                                    <span class="no-primary-text" style="color:#666;' . (!empty($property['images']) ? 'display:none;' : '') . '">No primary image</span>
                                </div>
                            </div>
                            <div class="form-group" style="flex:1;min-width:220px;">
                                <label for="primary_image_file">Change Primary Image</label>
                                <input type="file" id="primary_image_file" name="primary_image" class="form-control" accept="image/*">
                                <small class="form-text text-muted">Upload a single image to replace the primary image.</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Current Images -->
                    <div class="current-images">
                        <h4>Current Images</h4>
                        <div class="current-images-grid" id="currentImagesGrid">
                            ' . renderCurrentImages($property['images']) . '
                        </div>
                    </div>
                    
                    <!-- New Gallery Images -->
                    <div class="new-images">
                        <h4>Add New Gallery Images</h4>
                        <div class="form-group">
                            <label for="images">Upload Images</label>
                            <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*">
                            <small class="form-text text-muted">You can select multiple images. Supported formats: JPG, PNG, GIF, WebP</small>
                        </div>
                        
                        <div class="image-preview-container" id="imagePreviewContainer"></div>
                    </div>
                </div>

                <!-- Section 6: Features -->
                <div class="form-section">
                    <h2><i class="fas fa-star"></i> Features & Amenities</h2>
                    
                    <!-- Current Features -->
                    <div class="current-features">
                        <h4>Current Features</h4>
                        <div class="features-list" id="currentFeaturesList">
                            ' . renderCurrentFeatures($property['features']) . '
                        </div>
                    </div>
                    
                    <!-- Add New Features -->
                    <div class="add-features">
                        <h4>Add New Features</h4>
                        <div class="form-group">
                            <label>Common Features (Click to add)</label>
                            <div class="common-features">
                                <span class="feature-tag" data-feature="Air Conditioning">Air Conditioning</span>
                                <span class="feature-tag" data-feature="Swimming Pool">Swimming Pool</span>
                                <span class="feature-tag" data-feature="Garden">Garden</span>
                                <span class="feature-tag" data-feature="Parking">Parking</span>
                                <span class="feature-tag" data-feature="Security">Security</span>
                                <span class="feature-tag" data-feature="Balcony">Balcony</span>
                                <span class="feature-tag" data-feature="Balcony">Balcony</span>
                                <span class="feature-tag" data-feature="Furnished">Furnished</span>
                                <span class="feature-tag" data-feature="Pet Friendly">Pet Friendly</span>
                                <span class="feature-tag" data-feature="Near School">Near School</span>
                                <span class="feature-tag" data-feature="Near Hospital">Near Hospital</span>
                                <span class="feature-tag" data-feature="Near Shopping">Near Shopping</span>
                            </div>
                        </div>
                        
                        <div class="dynamic-features" id="dynamicFeatures">
                            <!-- Dynamic features will be added here -->
                        </div>
                        
                        <button type="button" class="btn btn-outline-primary" id="addFeatureBtn">
                            <i class="fas fa-plus"></i> Add Custom Feature
                        </button>
                    </div>
                </div>

                <!-- Section 7: Additional Options -->
                <div class="form-section">
                    <h2><i class="fas fa-cog"></i> Additional Options</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" id="featured" name="featured" class="form-check-input" ' . ($property['featured'] ? 'checked' : '') . '>
                                    <label for="featured" class="form-check-label">Featured Property</label>
                                    <small class="form-text text-muted">Featured properties appear first in search results</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        Update Property
                    </button>
                    <a href="/admin/properties" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
';

// Helper functions
function renderCurrentImages($images) {
    if (empty($images)) {
        return '<p class="no-images">No images uploaded yet.</p>';
    }
    
    $html = '';
    foreach ($images as $image) {
        $primaryClass = $image['is_primary'] ? 'primary-image' : '';
        $html .= '
        <div class="current-image-item ' . $primaryClass . '" data-image-id="' . $image['id'] . '">
            <img src="' . htmlspecialchars($image['image_path']) . '" alt="' . htmlspecialchars($image['alt_text']) . '" class="current-image">
            <div class="image-overlay">
                <div class="image-actions">
                    ' . ($image['is_primary'] ? '' : '<button type="button" class="btn btn-sm btn-primary set-primary" data-image-id="' . $image['id'] . '" title="Set as Primary">
                        <i class="fas fa-star"></i>
                    </button>') . '
                    <button type="button" class="btn btn-sm btn-danger delete-image" data-image-id="' . $image['id'] . '" title="Delete Image">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="image-info">
                <small>' . htmlspecialchars($image['alt_text'] ?: 'No description') . '</small>
                ' . ($image['is_primary'] ? '<span class="primary-badge">Primary</span>' : '') . '
            </div>
        </div>';
    }
    
    return $html;
}

function renderCurrentFeatures($features) {
    if (empty($features)) {
        return '<p class="no-features">No features added yet.</p>';
    }
    
    $html = '';
    foreach ($features as $feature) {
        $html .= '
        <div class="current-feature-item">
            <span class="feature-name">' . htmlspecialchars($feature['feature_name']) . '</span>
            ' . ($feature['feature_value'] ? '<span class="feature-value">: ' . htmlspecialchars($feature['feature_value']) . '</span>' : '') . '
            <button type="button" class="btn btn-sm btn-outline-danger remove-current-feature" data-feature="' . htmlspecialchars($feature['feature_name']) . '">
                <i class="fas fa-times"></i>
            </button>
        </div>';
    }
    
    return $html;
}

// Add page-specific CSS
$pageContent .= '
<style>
/* Edit Property Styles */
.admin-edit-property {
    padding: 40px 0;
    background: #f8f9fa;
    min-height: 80vh;
}

.form-header {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.form-header h1 {
    color: var(--primary-color);
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 10px 0;
}

.form-header p {
    color: var(--text-color);
    margin: 0;
}

.property-form {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.form-section {
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 1px solid #eee;
}

.form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.form-section h2 {
    color: var(--primary-color);
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}

.form-section h2 i {
    margin-right: 10px;
    font-size: 1.2rem;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    color: var(--text-color);
}

.required {
    color: #ef4444;
}

.form-control {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 0.9rem;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(30, 58, 138, 0.1);
}

.form-check {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.form-check-input {
    margin-right: 10px;
}

.form-check-label {
    margin-bottom: 0;
}

/* Current Images */
.current-images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.current-image-item {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    background: white;
    position: relative;
    transition: all 0.3s ease;
}

.current-image-item:hover .image-overlay {
    opacity: 1;
}

.current-image-item.primary-image {
    border: 2px solid var(--primary-color);
    box-shadow: 0 0 10px rgba(30, 58, 138, 0.3);
}

.current-image {
    width: 100%;
    height: 100px;
    object-fit: cover;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.image-actions {
    display: flex;
    gap: 10px;
}

.image-actions .btn {
    padding: 5px 10px;
    font-size: 0.8rem;
}

.image-info {
    padding: 10px;
    text-align: center;
}

.primary-badge {
    background: var(--primary-color);
    color: white;
    padding: 2px 6px;
    border-radius: 10px;
    font-size: 0.7rem;
    margin-left: 5px;
}

/* Current Features */
.current-features {
    margin-bottom: 30px;
}

.current-feature-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 15px;
    background: #f8f9fa;
    border-radius: 5px;
    margin-bottom: 10px;
}

.feature-name {
    font-weight: 500;
    color: var(--text-color);
}

.feature-value {
    color: #666;
    margin-left: 5px;
}

/* Common Features */
.common-features {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}

.feature-tag {
    background: var(--primary-color);
    color: white;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.feature-tag:hover {
    background: #1e40af;
    transform: translateY(-1px);
}

/* Dynamic Features */
.dynamic-feature {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
    align-items: end;
}

.dynamic-feature .form-group {
    margin-bottom: 0;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
    font-size: 0.9rem;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: #1e40af;
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
    color: white;
    text-decoration: none;
}

.btn-outline-primary {
    background: transparent;
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
}

.btn-outline-primary:hover {
    background: var(--primary-color);
    color: white;
}

.btn-outline-danger {
    background: transparent;
    color: #ef4444;
    border: 1px solid #ef4444;
}

.btn-outline-danger:hover {
    background: #ef4444;
    color: white;
}

.btn-sm {
    padding: 5px 10px;
    font-size: 0.8rem;
}

.btn i {
    margin-right: 5px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-section h2 {
        font-size: 1.3rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .current-images-grid {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    }
    
    .common-features {
        justify-content: center;
    }
    
    .dynamic-feature {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>
';

// Add JavaScript
$pageContent .= '
<script>
let featureCount = 0;
const propertyId = ' . $property['id'] . ';
const csrfToken = "' . ($csrfToken ?? '') . '";

// Image management functionality
document.addEventListener("click", function(e) {
    if (e.target.closest(".set-primary")) {
        const button = e.target.closest(".set-primary");
        const imageId = button.dataset.imageId;
        setPrimaryImage(imageId);
    }
    
    if (e.target.closest(".delete-image")) {
        const button = e.target.closest(".delete-image");
        const imageId = button.dataset.imageId;
        if (confirm("Are you sure you want to delete this image?")) {
            deleteImage(imageId);
        }
    }
});

// Primary image live preview
document.getElementById("primary_image_file")?.addEventListener("change", function(e){
    const file = e.target.files && e.target.files[0];
    const wrap = document.getElementById("primaryImagePreview");
    if (!wrap) return;
    const img = wrap.querySelector("img");
    const noTxt = wrap.querySelector(".no-primary-text");
    if (file && file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function(ev){
            if (img) { img.src = ev.target.result; img.style.display = "block"; }
            if (noTxt) { noTxt.style.display = "none"; }
        };
        reader.readAsDataURL(file);
    }
});

function setPrimaryImage(imageId) {
    const formData = new FormData();
    formData.append("csrf_token", csrfToken);
    formData.append("image_id", imageId);
    
    fetch("/admin/properties/" + propertyId + "/update-primary-image", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, "success");
            // Update UI
            updatePrimaryImageUI(imageId);
        } else {
            showNotification(data.message, "error");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showNotification("An error occurred while updating primary image", "error");
    });
}

function deleteImage(imageId) {
    const formData = new FormData();
    formData.append("csrf_token", csrfToken);
    formData.append("image_id", imageId);
    
    fetch("/admin/properties/" + propertyId + "/delete-image", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, "success");
            // Remove image from UI
            removeImageFromUI(imageId);
        } else {
            showNotification(data.message, "error");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showNotification("An error occurred while deleting image", "error");
    });
}

function updatePrimaryImageUI(imageId) {
    // Remove primary class from all images
    document.querySelectorAll(".current-image-item").forEach(item => {
        item.classList.remove("primary-image");
        const badge = item.querySelector(".primary-badge");
        if (badge) badge.remove();
        
        // Add set primary button if not exists
        const actions = item.querySelector(".image-actions");
        if (actions && !actions.querySelector(".set-primary")) {
            const setPrimaryBtn = document.createElement("button");
            setPrimaryBtn.type = "button";
            setPrimaryBtn.className = "btn btn-sm btn-primary set-primary";
            setPrimaryBtn.dataset.imageId = item.dataset.imageId;
            setPrimaryBtn.title = "Set as Primary";
            setPrimaryBtn.innerHTML = "<i class=\"fas fa-star\"></i>";
            actions.insertBefore(setPrimaryBtn, actions.firstChild);
        }
    });
    
    // Add primary class to selected image
    const selectedImage = document.querySelector("[data-image-id=\"" + imageId + "\"]");
    if (selectedImage) {
        selectedImage.classList.add("primary-image");
        
        // Remove set primary button
        const setPrimaryBtn = selectedImage.querySelector(".set-primary");
        if (setPrimaryBtn) setPrimaryBtn.remove();
        
        // Add primary badge
        const imageInfo = selectedImage.querySelector(".image-info");
        if (imageInfo && !imageInfo.querySelector(".primary-badge")) {
            const badge = document.createElement("span");
            badge.className = "primary-badge";
            badge.textContent = "Primary";
            imageInfo.appendChild(badge);
        }
    }
}

function removeImageFromUI(imageId) {
    const imageItem = document.querySelector("[data-image-id=\"" + imageId + "\"]");
    if (imageItem) {
        imageItem.remove();
        
        // Check if no images left
        const remainingImages = document.querySelectorAll(".current-image-item");
        if (remainingImages.length === 0) {
            const grid = document.getElementById("currentImagesGrid");
            if (grid) {
                grid.innerHTML = "<p class=\"no-images\">No images uploaded yet.</p>";
            }
        }
    }
}

// Notification system
function showNotification(message, type = "info") {
    const notification = document.createElement("div");
    notification.className = "notification notification-" + type;
    notification.textContent = message;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 5px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        animation: slideIn 0.3s ease;
    `;
    
    if (type === "success") {
        notification.style.backgroundColor = "#10b981";
    } else if (type === "error") {
        notification.style.backgroundColor = "#ef4444";
    } else {
        notification.style.backgroundColor = "#3b82f6";
    }
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = "slideOut 0.3s ease";
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Add CSS animations
const style = document.createElement("style");
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);

// Remove image preview
document.addEventListener("click", function(e) {
    if (e.target.closest(".remove-image")) {
        e.target.closest(".image-preview-item").remove();
    }
});

// Add feature functionality
document.getElementById("addFeatureBtn").addEventListener("click", function() {
    addFeatureField();
});

// Common feature tags
document.querySelectorAll(".feature-tag").forEach(tag => {
    tag.addEventListener("click", function() {
        const featureName = this.dataset.feature;
        addFeatureField(featureName);
        this.style.opacity = "0.5";
        this.style.pointerEvents = "none";
    });
});

function addFeatureField(featureName = "") {
    const container = document.getElementById("dynamicFeatures");
    const newFeature = document.createElement("div");
    newFeature.className = "dynamic-feature";
    newFeature.innerHTML = `
        <div class="form-group" style="flex: 1;">
            <label>Feature Name</label>
            <input type="text" name="features[${featureCount}][name]" class="form-control" placeholder="e.g., Air Conditioning" value="${featureName}">
        </div>
        <div class="form-group" style="flex: 1;">
            <label>Feature Value</label>
            <input type="text" name="features[${featureCount}][value]" class="form-control" placeholder="e.g., Central AC">
        </div>
        <div class="form-group">
            <label>&nbsp;</label>
            <button type="button" class="btn btn-outline-danger remove-feature">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    
    container.appendChild(newFeature);
    featureCount++;
}

// Remove feature field
document.addEventListener("click", function(e) {
    if (e.target.closest(".remove-feature")) {
        e.target.closest(".dynamic-feature").remove();
    }
});

// Remove current feature
document.addEventListener("click", function(e) {
    if (e.target.closest(".remove-current-feature")) {
        const featureName = e.target.closest(".remove-current-feature").dataset.feature;
        if (confirm("Remove feature \"" + featureName + "\"?")) {
            e.target.closest(".current-feature-item").remove();
        }
    }
});

// Form validation
document.getElementById("editPropertyForm").addEventListener("submit", function(e) {
    const requiredFields = ["title", "property_id", "short_description", "description", "price", "property_type", "bedrooms", "bathrooms", "location", "city", "district", "address"];
    
    for (let field of requiredFields) {
        const input = document.getElementById(field);
        if (!input.value.trim()) {
            e.preventDefault();
            alert("Please fill in the " + field.replace("_", " ") + " field.");
            input.focus();
            return;
        }
    }
});
</script>
';

// Add content to layout data
$layoutData['content'] = $pageContent;

// Create and render the layout
$layout = new BaseLayout($layoutData);
echo $layout->render();
?>
