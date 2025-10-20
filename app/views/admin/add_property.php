<?php
// Initialize components
require_once APP_PATH . '/components/BaseLayout.php';

// Prepare data for components
$layoutData = [
    'pageTitle' => 'Add New Property - Admin Dashboard',
    'pageDescription' => 'Add a new property to the real estate platform',
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
    <!-- Add Property Form Section -->
    <section class="admin-add-property">
        <div class="container">
            <div class="form-header">
                <h1>Add New Property</h1>
                <p>Fill in the details below to add a new property to the platform</p>
            </div>

            <form id="addPropertyForm" method="POST" action="/admin/properties/store" enctype="multipart/form-data" class="property-form">
                <input type="hidden" name="csrf_token" value="' . ($csrfToken ?? '') . '">
                
                <!-- Section 1: Basic Information -->
                <div class="form-section">
                    <h2><i class="fas fa-info-circle"></i> Basic Information</h2>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="title">Property Title <span class="required">*</span></label>
                                <input type="text" id="title" name="title" class="form-control" required maxlength="200" placeholder="e.g., 3-Bedroom Luxury Apartment in Colombo 07">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="property_id">Property ID <span class="required">*</span></label>
                                <input type="text" id="property_id" name="property_id" class="form-control" required maxlength="50" placeholder="e.g., PROP001">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="short_description">Short Description <span class="required">*</span></label>
                        <textarea id="short_description" name="short_description" class="form-control" required maxlength="500" rows="2" placeholder="Brief summary for listings"></textarea>
                        <small class="form-text text-muted">Maximum 500 characters</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Full Description <span class="required">*</span></label>
                        <textarea id="description" name="description" class="form-control" required rows="5" placeholder="Detailed property description"></textarea>
                    </div>
                </div>

                <!-- Section 2: Pricing & Status -->
                <div class="form-section">
                    <h2><i class="fas fa-dollar-sign"></i> Pricing & Status</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Price (LKR) <span class="required">*</span></label>
                                <input type="number" id="price" name="price" class="form-control" required min="0" step="1" placeholder="45000000" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <select id="currency" name="currency" class="form-control">
                                    <option value="LKR" selected>LKR</option>
                                    <option value="USD">USD</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="available" selected>Available</option>
                                    <option value="sold">Sold</option>
                                    <option value="rented">Rented</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" id="featured" name="featured" class="form-check-input" value="1">
                            <label for="featured" class="form-check-label">Mark as Featured Property</label>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Property Specifications -->
                <div class="form-section">
                    <h2><i class="fas fa-home"></i> Property Specifications</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="property_type">Property Type <span class="required">*</span></label>
                                <select id="property_type" name="property_type" class="form-control" required>
                                    <option value="">Select Type</option>
                                    <option value="apartment">Apartment</option>
                                    <option value="house">House</option>
                                    <option value="land">Land</option>
                                    <option value="commercial">Commercial</option>
                                    <option value="villa">Villa</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="bedrooms">Bedrooms <span class="required">*</span></label>
                                <input type="number" id="bedrooms" name="bedrooms" class="form-control" required min="0" max="20" value="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="bathrooms">Bathrooms <span class="required">*</span></label>
                                <input type="number" id="bathrooms" name="bathrooms" class="form-control" required min="0" max="20" value="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="floors">Floors</label>
                                <input type="number" id="floors" name="floors" class="form-control" min="1" max="50" value="1">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="area_sqft">Building Area (sq ft)</label>
                                <input type="number" id="area_sqft" name="area_sqft" class="form-control" min="0" step="0.01" placeholder="1200.00">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="land_area_sqft">Land Area (sq ft)</label>
                                <input type="number" id="land_area_sqft" name="land_area_sqft" class="form-control" min="0" step="0.01" placeholder="2500.00">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Location Details -->
                <div class="form-section">
                    <h2><i class="fas fa-map-marker-alt"></i> Location Details</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="location">Location <span class="required">*</span></label>
                                <input type="text" id="location" name="location" class="form-control" required maxlength="200" placeholder="e.g., Colombo 07">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="city">City <span class="required">*</span></label>
                                <input type="text" id="city" name="city" class="form-control" required maxlength="100" placeholder="e.g., Colombo">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="district">District <span class="required">*</span></label>
                                <input type="text" id="district" name="district" class="form-control" required maxlength="100" placeholder="e.g., Colombo">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Full Address <span class="required">*</span></label>
                        <textarea id="address" name="address" class="form-control" required rows="2" placeholder="Complete address including street name, number, etc."></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude">Latitude (Optional)</label>
                                <input type="number" id="latitude" name="latitude" class="form-control" step="any" min="-90" max="90" placeholder="6.9271">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude">Longitude (Optional)</label>
                                <input type="number" id="longitude" name="longitude" class="form-control" step="any" min="-180" max="180" placeholder="79.8612">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 5: Images Upload -->
                <div class="form-section">
                    <h2><i class="fas fa-images"></i> Property Images</h2>
                    <div class="form-group">
                        <label for="images">Upload Images <span class="required">*</span></label>
                        <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*" required>
                        <small class="form-text text-muted">Upload multiple images (JPG, PNG, WebP). Maximum 10MB per file.</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="primary_image">Primary Image</label>
                        <select id="primary_image" name="primary_image" class="form-control">
                            <option value="0">Select primary image (will be updated after upload)</option>
                        </select>
                    </div>
                    
                    <div id="image-preview" class="image-preview-container"></div>
                </div>

                <!-- Section 6: Features & Amenities -->
                <div class="form-section">
                    <h2><i class="fas fa-star"></i> Features & Amenities</h2>
                    <div id="features-container">
                        <div class="feature-item">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Feature Name</label>
                                        <input type="text" name="features[0][name]" class="form-control" placeholder="e.g., Air Conditioning">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Feature Value</label>
                                        <input type="text" name="features[0][value]" class="form-control" placeholder="e.g., Central AC">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-block remove-feature" style="display: none;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" id="add-feature" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Add Feature
                    </button>
                    
                    <div class="common-features mt-3">
                        <h5>Common Features:</h5>
                        <div class="feature-tags">
                            <span class="feature-tag" data-feature="Air Conditioning" data-value="Central AC">Air Conditioning</span>
                            <span class="feature-tag" data-feature="Balcony" data-value="Yes">Balcony</span>
                            <span class="feature-tag" data-feature="Elevator" data-value="Yes">Elevator</span>
                            <span class="feature-tag" data-feature="Parking" data-value="2 Cars">Parking</span>
                            <span class="feature-tag" data-feature="Security" data-value="24/7">Security</span>
                            <span class="feature-tag" data-feature="Swimming Pool" data-value="Yes">Swimming Pool</span>
                            <span class="feature-tag" data-feature="Gym" data-value="Yes">Gym</span>
                            <span class="feature-tag" data-feature="Garden" data-value="Yes">Garden</span>
                            <span class="feature-tag" data-feature="Sea View" data-value="Yes">Sea View</span>
                            <span class="feature-tag" data-feature="Backup Generator" data-value="Yes">Backup Generator</span>
                        </div>
                    </div>
                </div>

                <!-- Section 7: Submit -->
                <div class="form-section">
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Add Property
                        </button>
                        <a href="/admin/properties" class="btn btn-secondary btn-lg">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <style>
    .admin-add-property {
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
        text-align: center;
    }

    .form-header h1 {
        color: var(--primary-color);
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .form-header p {
        color: var(--text-color);
        font-size: 1.1rem;
        margin: 0;
    }

    .property-form {
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .form-section {
        margin-bottom: 40px;
        padding-bottom: 30px;
        border-bottom: 2px solid #e9ecef;
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .form-section h2 {
        color: var(--primary-color);
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 8px;
        display: block;
    }

    .required {
        color: #dc3545;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
    }

    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .feature-item {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .feature-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .feature-tag {
        background: var(--primary-color);
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        user-select: none;
    }

    .feature-tag:hover {
        background: #1e40af;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .feature-tag:active {
        transform: translateY(0);
    }

    .image-preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }

    .image-preview {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .image-preview img {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }

    .image-preview .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(220, 53, 69, 0.8);
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        cursor: pointer;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        padding-top: 30px;
        border-top: 2px solid #e9ecef;
    }

    .btn {
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background: #1e40af;
        border-color: #1e40af;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background: #5a6268;
        border-color: #5a6268;
        transform: translateY(-2px);
    }

    .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-outline-primary:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .btn-danger {
        background: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background: #c82333;
        border-color: #c82333;
    }

    @media (max-width: 768px) {
        .form-header h1 {
            font-size: 2rem;
        }
        
        .property-form {
            padding: 20px;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
    }
    </style>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Feature management
        let featureCount = 1;
        
        document.getElementById("add-feature").addEventListener("click", function() {
            const container = document.getElementById("features-container");
            const newFeature = document.createElement("div");
            newFeature.className = "feature-item";
            newFeature.innerHTML = \"<div class=\\\"row\\\"><div class=\\\"col-md-5\\\"><div class=\\\"form-group\\\"><label>Feature Name</label><input type=\\\"text\\\" name=\\\"features[\" + featureCount + \"][name]\\\" class=\\\"form-control\\\" placeholder=\\\"e.g., Air Conditioning\\\"></div></div><div class=\\\"col-md-5\\\"><div class=\\\"form-group\\\"><label>Feature Value</label><input type=\\\"text\\\" name=\\\"features[\" + featureCount + \"][value]\\\" class=\\\"form-control\\\" placeholder=\\\"e.g., Central AC\\\"></div></div><div class=\\\"col-md-2\\\"><div class=\\\"form-group\\\"><label>&nbsp;</label><button type=\\\"button\\\" class=\\\"btn btn-danger btn-block remove-feature\\\"><i class=\\\"fas fa-trash\\\"></i></button></div></div></div>\";
            container.appendChild(newFeature);
            featureCount++;
            
            // Show remove buttons for all features
            document.querySelectorAll(".remove-feature").forEach(btn => {
                btn.style.display = "block";
            });
        });
        
        // Remove feature
        document.addEventListener("click", function(e) {
            if (e.target.closest(".remove-feature")) {
                e.target.closest(".feature-item").remove();
            }
        });
        
        // Add common features
        document.querySelectorAll(".feature-tag").forEach(tag => {
            tag.addEventListener("click", function() {
                const featureName = this.dataset.feature;
                const featureValue = this.dataset.value;
                
                // Find first empty feature or add new one
                let emptyFeature = document.querySelector("input[name*=\"[name]\"]:not([value])");
                if (!emptyFeature) {
                    document.getElementById("add-feature").click();
                    emptyFeature = document.querySelector("input[name*=\"[name]\"]:not([value])");
                }
                
                if (emptyFeature) {
                    emptyFeature.value = featureName;
                    emptyFeature.nextElementSibling.querySelector("input").value = featureValue;
                }
            });
        });
        
        // Image preview
        document.getElementById("images").addEventListener("change", function(e) {
            const files = e.target.files;
            const previewContainer = document.getElementById("image-preview");
            const primarySelect = document.getElementById("primary_image");
            
            previewContainer.innerHTML = "";
            primarySelect.innerHTML = \"<option value=\\\"0\\\">Select primary image</option>\";
            
            Array.from(files).forEach((file, index) => {
                if (file.type.startsWith("image/")) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.createElement("div");
                        preview.className = "image-preview";
                        preview.innerHTML = \"<img src=\\\"\" + e.target.result + \"\\\" alt=\\\"Preview\\\"><button type=\\\"button\\\" class=\\\"remove-image\\\" data-index=\\\"\" + index + \"\\\"><i class=\\\"fas fa-times\\\"></i></button>\";
                        previewContainer.appendChild(preview);
                        
                        // Add to primary select
                        const option = document.createElement("option");
                        option.value = index;
                        option.textContent = \"Image \" + (index + 1);
                        primarySelect.appendChild(option);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
        
        // Form validation
        document.getElementById("addPropertyForm").addEventListener("submit", function(e) {
            const requiredFields = ["title", "property_id", "short_description", "description", "price", "property_type", "bedrooms", "bathrooms", "location", "city", "district", "address"];
            
            for (let field of requiredFields) {
                const input = document.querySelector(`[name="${field}"]`);
                if (!input.value.trim()) {
                    e.preventDefault();
                    alert(`${input.previousElementSibling.textContent.replace("*", "")} is required.`);
                    input.focus();
                    return;
                }
            }
            
            // Check if images are uploaded
            const images = document.getElementById("images");
            if (images.files.length === 0) {
                e.preventDefault();
                alert("Please upload at least one image.");
                images.focus();
                return;
            }
        });
    });
    </script>
';

// Add content to layout data
$layoutData['content'] = $pageContent;

// Render the page
$layout = new BaseLayout($layoutData);
echo $layout->render();
?>
