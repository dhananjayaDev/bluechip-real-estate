<?php
require_once APP_PATH . '/helpers/functions.php';

$title = $property['title'] . ' - ' . SITE_NAME;
$description = $property['short_description'];

ob_start();
?>

<div class="property-details">
    <!-- Property Title & Summary -->
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="property-header mb-4">
                    <h1 class="property-title h2 mb-2"><?= e($property['title']) ?></h1>
                    <p class="property-summary text-muted mb-3"><?= e($property['short_description']) ?></p>
                    
                    <div class="property-meta d-flex flex-wrap gap-3 mb-3">
                        <span class="badge bg-primary">
                            <i class="fas fa-tag me-1"></i>
                            ID: <?= e($property['property_id']) ?>
                        </span>
                        <span class="badge bg-success">
                            <i class="fas fa-calendar me-1"></i>
                            Posted: <?= formatDate($property['created_at']) ?>
                        </span>
                        <span class="badge bg-info">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            <?= e($property['location']) ?>
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="property-price-card text-center p-4 bg-light rounded">
                    <div class="price-display mb-3">
                        <span class="h3 text-primary fw-bold"><?= formatCurrency($property['price'], $property['currency']) ?></span>
                    </div>
                    
                    <div class="property-actions d-flex gap-2 justify-content-center">
                        <!-- Favorite Button -->
                        <button class="btn btn-outline-danger favorite-btn" data-property-id="<?= $property['id'] ?>">
                            <i class="fas fa-heart <?= $isFavorite ? '' : 'far' ?>"></i>
                            <span class="favorite-text"><?= $isFavorite ? 'Saved' : 'Save' ?></span>
                        </button>
                        
                        <!-- Share Button -->
                        <button class="btn btn-outline-primary" onclick="shareProperty()">
                            <i class="fas fa-share-alt"></i>
                            Share
                        </button>
                        
                        <!-- Print Button -->
                        <button class="btn btn-outline-secondary" onclick="window.print()">
                            <i class="fas fa-print"></i>
                            Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Gallery -->
    <div class="property-gallery mb-5">
        <div class="container">
            <?php if (!empty($property['images'])): ?>
                <div class="swiper property-swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($property['images'] as $image): ?>
                            <div class="swiper-slide">
                                <div class="gallery-item">
                                    <img src="<?= imageUrl($image['image_path']) ?>" 
                                         alt="<?= e($image['alt_text'] ?: $property['title']) ?>"
                                         class="img-fluid rounded">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            <?php else: ?>
                <div class="no-images text-center py-5">
                    <i class="fas fa-image text-muted" style="font-size: 4rem;"></i>
                    <p class="text-muted mt-3">No images available for this property</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Key Property Information -->
                <div class="property-info-card mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                Property Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <strong>Property Type:</strong>
                                        <span class="text-capitalize"><?= e($property['property_type']) ?></span>
                                    </div>
                                    <div class="info-item mb-3">
                                        <strong>Bedrooms:</strong>
                                        <span><?= $property['bedrooms'] ?></span>
                                    </div>
                                    <div class="info-item mb-3">
                                        <strong>Bathrooms:</strong>
                                        <span><?= $property['bathrooms'] ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <strong>Floors:</strong>
                                        <span><?= $property['floors'] ?></span>
                                    </div>
                                    <div class="info-item mb-3">
                                        <strong>Area:</strong>
                                        <span><?= number_format($property['area_sqft']) ?> sq ft</span>
                                    </div>
                                    <?php if ($property['land_area_sqft']): ?>
                                    <div class="info-item mb-3">
                                        <strong>Land Area:</strong>
                                        <span><?= number_format($property['land_area_sqft']) ?> sq ft</span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Description -->
                <div class="property-description mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-file-alt text-primary me-2"></i>
                                Description
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="description-content">
                                <?= nl2br(e($property['description'])) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Property Features -->
                <?php if (!empty($property['features'])): ?>
                <div class="property-features mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-check-circle text-primary me-2"></i>
                                Features & Amenities
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($property['features'] as $feature): ?>
                                    <div class="col-md-6 mb-2">
                                        <div class="feature-item d-flex align-items-center">
                                            <i class="fas fa-check text-success me-2"></i>
                                            <span><?= e($feature['feature_name']) ?>
                                                <?php if ($feature['feature_value']): ?>
                                                    <small class="text-muted">(<?= e($feature['feature_value']) ?>)</small>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Location Map -->
                <?php if ($property['latitude'] && $property['longitude']): ?>
                <div class="property-map mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                Location
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div id="property-map" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Request Section -->
                <div class="request-section mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                Request Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <!-- Request Form for Logged-in Users -->
                                <form id="request-form" class="request-form">
                                    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Preferred Contact Method</label>
                                        <select name="contact_method" class="form-select" required>
                                            <option value="email">Email</option>
                                            <option value="phone">Phone</option>
                                            <option value="whatsapp">WhatsApp</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Message</label>
                                        <textarea name="message" class="form-control" rows="4" 
                                                  placeholder="I'd like to schedule a viewing..." required></textarea>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Preferred Date</label>
                                            <input type="date" name="preferred_date" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Preferred Time</label>
                                            <input type="time" name="preferred_time" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        Send Request
                                    </button>
                                </form>
                            <?php else: ?>
                                <!-- Login Required Message -->
                                <div class="text-center">
                                    <i class="fas fa-lock text-muted mb-3" style="font-size: 2rem;"></i>
                                    <p class="text-muted mb-3">
                                        Please <a href="/login" class="text-primary">Login</a> or 
                                        <a href="/register" class="text-primary">Register</a> to request more details or schedule a visit.
                                    </p>
                                    <a href="/login" class="btn btn-primary me-2">
                                        <i class="fas fa-sign-in-alt me-1"></i>Login
                                    </a>
                                    <a href="/register" class="btn btn-outline-primary">
                                        <i class="fas fa-user-plus me-1"></i>Register
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Agent Contact Info -->
                <div class="agent-contact mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-user-tie text-primary me-2"></i>
                                Contact Agent
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="agent-info">
                                <div class="agent-avatar mb-3">
                                    <i class="fas fa-user-circle text-muted" style="font-size: 4rem;"></i>
                                </div>
                                <h6 class="agent-name">Admin</h6>
                                <p class="text-muted mb-3">Bluechip Realty</p>
                                
                                <div class="contact-buttons">
                                    <a href="tel:+94112345678" class="btn btn-outline-primary btn-sm me-2 mb-2">
                                        <i class="fas fa-phone me-1"></i>Call
                                    </a>
                                    <a href="mailto:admin@bluechiprealty.com" class="btn btn-outline-primary btn-sm me-2 mb-2">
                                        <i class="fas fa-envelope me-1"></i>Email
                                    </a>
                                    <a href="https://wa.me/94112345678" class="btn btn-outline-success btn-sm mb-2" target="_blank">
                                        <i class="fab fa-whatsapp me-1"></i>WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Legal Notice -->
                <div class="legal-notice">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-shield-alt text-primary me-2"></i>
                                Legal & Compliance
                            </h6>
                            <p class="card-text small text-muted">
                                All property details are verified by admin. Prices and availability subject to change. 
                                Ownership verification status: <span class="text-success">Verified</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Similar Properties -->
    <?php if (!empty($similarProperties)): ?>
    <div class="similar-properties py-5 bg-light">
        <div class="container">
            <h3 class="mb-4">
                <i class="fas fa-home text-primary me-2"></i>
                You Might Also Like
            </h3>
            
            <div class="row">
                <?php foreach ($similarProperties as $similar): ?>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card property-card h-100">
                            <div class="property-image">
                                <img src="<?= imageUrl($similar['thumbnail_path'] ?: $similar['image_path']) ?>" 
                                     alt="<?= e($similar['title']) ?>"
                                     class="card-img-top">
                                <div class="property-badge">
                                    <span class="badge bg-primary"><?= formatCurrency($similar['price'], $similar['currency']) ?></span>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title"><?= e(truncate($similar['title'], 50)) ?></h6>
                                <p class="card-text text-muted small"><?= e(truncate($similar['short_description'], 80)) ?></p>
                                <div class="property-meta small text-muted">
                                    <span><i class="fas fa-bed me-1"></i><?= $similar['bedrooms'] ?> BR</span>
                                    <span class="ms-3"><i class="fas fa-bath me-1"></i><?= $similar['bathrooms'] ?> BA</span>
                                    <span class="ms-3"><i class="fas fa-ruler-combined me-1"></i><?= number_format($similar['area_sqft']) ?> sq ft</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="<?= propertyUrl($similar['id']) ?>" class="btn btn-primary btn-sm w-100">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();

$additionalScripts = '
<script>
// Initialize Swiper for image gallery
const swiper = new Swiper(".property-swiper", {
    loop: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});

// Initialize map
' . ($property['latitude'] && $property['longitude'] ? '
function initMap() {
    const propertyLocation = { lat: ' . $property['latitude'] . ', lng: ' . $property['longitude'] . ' };
    const map = new google.maps.Map(document.getElementById("property-map"), {
        zoom: 15,
        center: propertyLocation,
    });
    const marker = new google.maps.Marker({
        position: propertyLocation,
        map: map,
        title: "' . e($property['title']) . '",
    });
}
' : '') . '

// Handle favorite toggle
document.querySelector(".favorite-btn").addEventListener("click", function() {
    const propertyId = this.dataset.propertyId;
    const icon = this.querySelector("i");
    const text = this.querySelector(".favorite-text");
    
    fetch("/property/" + propertyId + "/favorite", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "csrf_token=' . $csrfToken . '"
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.isFavorite) {
                icon.classList.remove("far");
                icon.classList.add("fas");
                text.textContent = "Saved";
                this.classList.add("btn-danger");
                this.classList.remove("btn-outline-danger");
            } else {
                icon.classList.remove("fas");
                icon.classList.add("far");
                text.textContent = "Save";
                this.classList.remove("btn-danger");
                this.classList.add("btn-outline-danger");
            }
        } else {
            alert(data.message);
        }
    });
});

// Handle request form submission
document.getElementById("request-form").addEventListener("submit", function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch("/property/' . $property['id'] . '/request", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            this.reset();
        } else {
            alert(data.message);
        }
    });
});

// Share property function
function shareProperty() {
    if (navigator.share) {
        navigator.share({
            title: "' . e($property['title']) . '",
            text: "' . e($property['short_description']) . '",
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert("Property link copied to clipboard!");
        });
    }
}
</script>
' . ($property['latitude'] && $property['longitude'] ? '<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>' : '');

// Include the layout
extract(compact('title', 'description', 'content', 'additionalScripts', 'csrfToken'));
include APP_PATH . '/views/layouts/app.php';
?>
