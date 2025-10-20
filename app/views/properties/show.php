<?php
// Initialize components
require_once APP_PATH . '/components/BaseLayout.php';

$title = $property['title'] . ' - ' . SITE_NAME;
$description = $property['short_description'];

// Prepare data for components (use public styling and website footer)
$layoutData = [
    'pageTitle' => $title,
    'pageDescription' => $description,
    'activePage' => 'property-detail',
    'csrfToken' => $csrfToken ?? '',
    'includeModals' => false,
    'email' => 'hello@bluechiplands.asia',
    'phone' => '(+94) 71 609 2918',
    'logoPath' => '/public/images/uploads/logo.jpeg',
    'companyName' => 'Bluechip Real Estate (Pvt) Limited',
    'tagline' => 'අපේ රටේ ඉඩම් ගන්න හොඳම තැන',
    'aboutText' => 'Bluechip Real Estate (PVT) Limited has been established with the vision To deliver the highest value in real estate industry through innovation and integrity.',
    'address' => 'World Trade Center, West Tower,<br>Level 37, Colombo 01, Sri Lanka',
    'facebookUrl' => 'https://www.facebook.com/p/Bluechip-Real-Estate-100091440704853/',
    'whatsappUrl' => 'https://wa.me/94716092918'
];

// Create the page content
$pageContent = '
<section class="admin-property-detail user-variant">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="admin-header">
                    <h1><i class="fas fa-home"></i> ' . htmlspecialchars($property['title']) . '</h1>
                    <div class="property-meta">
                        <span class="badge badge-primary">ID: ' . htmlspecialchars($property['property_id']) . '</span>
                        <span class="badge badge-success">Posted: ' . date('M d, Y', strtotime($property['created_at'])) . '</span>
                        <span class="badge badge-info">' . htmlspecialchars($property['location']) . '</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="property-details-card">
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
                            <span class="currency">' . ($property['currency'] === 'USD' ? '$' : 'Rs.') . '</span>
                            <span class="amount">' . number_format($property['price']) . '</span>
                        </div>
                        <div class="property-status">
                            <span class="status-badge status-' . $property['status'] . '">' . ucfirst($property['status']) . '</span>
                        </div>
                    </div>
                    
                    <div class="property-info-card">
                        <h3><i class="fas fa-info-circle"></i> Property Information</h3>
                        <div class="info-grid">
                            <div class="info-item"><label>Property Type:</label><span>' . ucfirst($property['property_type']) . '</span></div>
                            <div class="info-item"><label>Bedrooms:</label><span>' . $property['bedrooms'] . '</span></div>
                            <div class="info-item"><label>Bathrooms:</label><span>' . $property['bathrooms'] . '</span></div>
                            <div class="info-item"><label>Floors:</label><span>' . $property['floors'] . '</span></div>
                            ' . ($property['area_sqft'] ? '<div class="info-item"><label>Built Area:</label><span>' . number_format($property['area_sqft']) . ' sq ft</span></div>' : '') . '
                            ' . ($property['land_area_sqft'] ? '<div class="info-item"><label>Land Area:</label><span>' . number_format($property['land_area_sqft']) . ' sq ft</span></div>' : '') . '
                        </div>
                    </div>
                    
                    <div class="location-card">
                        <h3><i class="fas fa-map-marker-alt"></i> Location</h3>
                        <div class="location-info">
                            <p><strong>Address:</strong><br>' . htmlspecialchars($property['address']) . '</p>
                            <p><strong>City:</strong> ' . htmlspecialchars($property['city']) . '</p>
                            <p><strong>District:</strong> ' . htmlspecialchars($property['district']) . '</p>
                        </div>
                    </div>
                    
                    <div class="request-card">
                        <h3><i class="fas fa-envelope"></i> Request Information</h3>
                        <p class="request-description">Interested in this property? Send us your details and we\'ll get back to you.</p>
                        <button class="btn btn-primary w-100 request-btn" data-property-id="' . $property['id'] . '">
                            <i class="fas fa-paper-plane me-2"></i>
                            Request Information
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
    .admin-property-detail.user-variant{padding:20px 0;background-color:#f8f9fa}
    .admin-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;padding:20px;background:#fff;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,.1)}
    .admin-header h1{color:var(--primary-color);margin:0;font-size:2rem}
    .property-meta{display:flex;gap:10px;flex-wrap:wrap}
    .badge{padding:8px 15px;border-radius:20px;font-size:.9rem;font-weight:500}
    .badge-primary{background:var(--primary-color);color:#fff}.badge-success{background:#28a745;color:#fff}.badge-info{background:#17a2b8;color:#fff}
    .property-details-card{background:#fff;border-radius:10px;padding:30px;box-shadow:0 2px 10px rgba(0,0,0,.1);margin-bottom:20px}
    .property-images h3,.property-description-section h3,.property-features h3{color:var(--primary-color);margin-bottom:20px;font-size:1.3rem}
    .image-gallery{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:15px}
    .image-item{position:relative;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.1)}
    .image-item img{width:100%;height:150px;object-fit:cover}
    .image-item.primary::after{content:"Primary";position:absolute;top:10px;right:10px;background:var(--primary-color);color:#fff;padding:4px 8px;border-radius:4px;font-size:.8rem}
    .features-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:15px}
    .feature-item{background:#f8f9fa;padding:15px;border-radius:8px;border-left:4px solid var(--primary-color)}
    .feature-item strong{color:var(--primary-color);display:block;margin-bottom:5px}
    .property-sidebar{display:flex;flex-direction:column;gap:20px}
    .pricing-card,.property-info-card,.location-card{background:#fff;border-radius:10px;padding:25px;box-shadow:0 2px 10px rgba(0,0,0,.1)}
    .pricing-card h3,.property-info-card h3,.location-card h3{color:var(--primary-color);margin-bottom:20px;font-size:1.2rem}
    .price-display{text-align:center;margin-bottom:20px}
    .price-display .currency{font-size:1.2rem;color:#666}.price-display .amount{font-size:2.5rem;font-weight:700;color:var(--primary-color)}
    .status-badge{display:inline-block;padding:8px 15px;border-radius:20px;font-weight:500;text-transform:uppercase;font-size:.9rem}
    .status-available{background:#d4edda;color:#155724}.status-sold{background:#f8d7da;color:#721c24}.status-rented{background:#fff3cd;color:#856404}
    .info-grid{display:grid;gap:15px}
    .info-item{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #eee}
    .info-item:last-child{border-bottom:none}
    .info-item label{font-weight:600;color:#666}.info-item span{color:var(--primary-color);font-weight:500}
    .request-card{background:#fff;border-radius:10px;padding:25px;box-shadow:0 2px 10px rgba(0,0,0,.1)}
    .request-card h3{color:var(--primary-color);margin-bottom:15px;font-size:1.2rem}
    .request-description{color:#666;margin-bottom:20px;font-size:.9rem}
    .request-btn{padding:12px 20px;font-weight:500;border-radius:8px;transition:all .3s ease}
    .request-btn:hover{transform:translateY(-2px);box-shadow:0 4px 15px rgba(0,0,0,.2)}
    </style>
    
    <!-- Property Request Modal -->
    <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestModalLabel">
                        <i class="fas fa-envelope me-2"></i>
                        Request Information
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="propertyRequestForm">
                    <div class="modal-body">
                        <input type="hidden" id="propertyId" name="property_id">
                        <input type="hidden" name="csrf_token" value="' . ($csrfToken ?? '') . '">
                        
                        <div class="mb-3">
                            <label for="requestName" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="requestName" name="name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="requestEmail" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="requestEmail" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="requestPhone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="requestPhone" name="phone">
                        </div>
                        
                        <div class="mb-3">
                            <label for="contactMethod" class="form-label">Preferred Contact Method</label>
                            <select class="form-select" id="contactMethod" name="contact_method">
                                <option value="email">Email</option>
                                <option value="phone">Phone Call</option>
                                <option value="whatsapp">WhatsApp</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="requestMessage" class="form-label">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="requestMessage" name="message" rows="4" required placeholder="I\'d like to schedule a viewing or get more information about this property..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>
                            Send Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Handle request button click
        document.addEventListener("click", function(e) {
            if (e.target.closest(".request-btn")) {
                const button = e.target.closest(".request-btn");
                const propertyId = button.dataset.propertyId;
                
                // Set property ID in form
                document.getElementById("propertyId").value = propertyId;
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById("requestModal"));
                modal.show();
            }
        });
        
        // Handle form submission
        document.getElementById("propertyRequestForm").addEventListener("submit", function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector("button[type=\'submit\']");
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = \'<i class="fas fa-spinner fa-spin me-2"></i>Sending...\';
            submitBtn.disabled = true;
            
            fetch("/property/" + formData.get("property_id") + "/request", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showNotification(data.message, "success");
                    
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById("requestModal"));
                    modal.hide();
                    
                    // Reset form
                    this.reset();
                } else {
                    showNotification(data.message, "error");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                showNotification("An error occurred. Please try again.", "error");
            })
            .finally(() => {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
        
        // Notification system
        function showNotification(message, type = "info") {
            const notification = document.createElement("div");
            notification.className = "notification notification-" + type;
            notification.textContent = message;
            
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
            
            setTimeout(() => {
                notification.style.animation = "slideOut 0.3s ease";
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
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
    });
    </script>
</section>';

// Create BaseLayout instance and render
$layout = new BaseLayout(array_merge($layoutData, ['content' => $pageContent]));
echo $layout->render();

// Helper methods
function renderPropertyImages($images) {
    if (empty($images)) {
        return '<div class="image-item"><img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&h=600&fit=crop" alt="Property Image"></div>';
    }
    $html = '';
    foreach ($images as $img) {
        $primaryClass = !empty($img['is_primary']) ? ' primary' : '';
        $html .= '<div class="image-item' . $primaryClass . '"><img src="' . e($img['image_path']) . '" alt="' . e($img['alt_text']) . '"></div>';
    }
    return $html;
}

function renderPropertyFeatures($features) {
    if (empty($features)) {
        return '';
    }
    
    $html = '';
    foreach ($features as $feature) {
        $html .= '<div class="feature-item"><strong>' . e($feature['feature_name']) . '</strong>' . ($feature['feature_value'] ? e($feature['feature_value']) : 'Yes') . '</div>';
    }
    return $html;
}

function renderLocationMap($property) {
    if (!$property['latitude'] || !$property['longitude']) {
        return '';
    }
    
    return '<div class="location-map mb-5">
                <h3 class="mb-4">
                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                    Location
                </h3>
                <div class="map-container" style="height: 400px; background: #f8f9fa; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <div class="text-center">
                        <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Interactive map would be displayed here</p>
                        <small class="text-muted">Coordinates: ' . $property['latitude'] . ', ' . $property['longitude'] . '</small>
                    </div>
                </div>
            </div>';
}

function renderAgentContact($property) {
    return '<div class="agent-contact">
                <h4 class="mb-3">
                    <i class="fas fa-user-tie text-primary me-2"></i>
                    Contact Agent
                </h4>
                <div class="agent-card p-3 bg-light rounded">
                    <div class="agent-info text-center">
                        <div class="agent-avatar mb-3">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face" alt="Agent" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                        <h5 class="agent-name">John Smith</h5>
                        <p class="agent-title text-muted">Senior Real Estate Agent</p>
                        <div class="agent-contact-info">
                            <p class="mb-1">
                                <i class="fas fa-phone text-primary me-2"></i>
                                (+94) 71 609 2918
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                john@bluechiprealty.com
                            </p>
                        </div>
                    </div>
                </div>
            </div>';
}

function renderSimilarProperties($similarProperties) {
    if (empty($similarProperties)) {
        return '';
    }
    
    $html = '<div class="similar-properties">
                <div class="container">
                    <h3 class="mb-4">
                        <i class="fas fa-home text-primary me-2"></i>
                        Similar Properties
                    </h3>
                    <div class="row">';
    
    foreach ($similarProperties as $property) {
        $html .= '<div class="col-lg-4 col-md-6 mb-4">
                    <div class="card property-card h-100">
                        <div class="property-image-container">
                            <img src="' . e($property['primary_image'] ?? 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=400&h=300&fit=crop') . '" class="card-img-top" alt="' . e($property['title']) . '" style="height: 200px; object-fit: cover;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">' . e($property['title']) . '</h5>
                            <p class="card-text text-muted">' . e($property['short_description']) . '</p>
                            <div class="property-meta mb-3">
                                <span class="badge bg-primary me-2">' . e($property['property_type']) . '</span>
                                <span class="badge bg-secondary me-2">' . $property['bedrooms'] . ' Bed</span>
                                <span class="badge bg-info">' . $property['bathrooms'] . ' Bath</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-primary mb-0">' . formatCurrency($property['price'], $property['currency']) . '</span>
                                <a href="/property/' . $property['id'] . '" class="btn btn-outline-primary btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>';
    }
    
    $html .= '</div></div></div>';
    return $html;
}
?>