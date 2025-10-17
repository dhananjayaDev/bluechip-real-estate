<?php
require_once APP_PATH . '/helpers/functions.php';

$title = 'Properties - ' . SITE_NAME;
$description = 'Browse our collection of premium properties in Sri Lanka';

ob_start();
?>

<div class="properties-page">
    <!-- Hero Section -->
    <div class="hero-section bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Find Your Dream Property</h1>
                    <p class="lead mb-4">
                        Discover premium apartments, houses, and commercial spaces across Sri Lanka. 
                        Your perfect home or investment awaits.
                    </p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fas fa-home" style="font-size: 6rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="search-filters-section py-4 bg-light">
        <div class="container">
            <form method="GET" action="/" id="filter-form" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               name="search" 
                               placeholder="Search properties..."
                               value="<?= e($filters['search']) ?>">
                    </div>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">City</label>
                    <select name="city" class="form-select">
                        <option value="">All Cities</option>
                        <option value="Colombo" <?= $filters['city'] === 'Colombo' ? 'selected' : '' ?>>Colombo</option>
                        <option value="Kandy" <?= $filters['city'] === 'Kandy' ? 'selected' : '' ?>>Kandy</option>
                        <option value="Galle" <?= $filters['city'] === 'Galle' ? 'selected' : '' ?>>Galle</option>
                        <option value="Negombo" <?= $filters['city'] === 'Negombo' ? 'selected' : '' ?>>Negombo</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">Type</label>
                    <select name="property_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="apartment" <?= $filters['property_type'] === 'apartment' ? 'selected' : '' ?>>Apartment</option>
                        <option value="house" <?= $filters['property_type'] === 'house' ? 'selected' : '' ?>>House</option>
                        <option value="villa" <?= $filters['property_type'] === 'villa' ? 'selected' : '' ?>>Villa</option>
                        <option value="commercial" <?= $filters['property_type'] === 'commercial' ? 'selected' : '' ?>>Commercial</option>
                        <option value="land" <?= $filters['property_type'] === 'land' ? 'selected' : '' ?>>Land</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">Bedrooms</label>
                    <select name="bedrooms" class="form-select">
                        <option value="">Any</option>
                        <option value="1" <?= $filters['bedrooms'] === '1' ? 'selected' : '' ?>>1+</option>
                        <option value="2" <?= $filters['bedrooms'] === '2' ? 'selected' : '' ?>>2+</option>
                        <option value="3" <?= $filters['bedrooms'] === '3' ? 'selected' : '' ?>>3+</option>
                        <option value="4" <?= $filters['bedrooms'] === '4' ? 'selected' : '' ?>>4+</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">Max Price</label>
                    <select name="max_price" class="form-select">
                        <option value="">No Limit</option>
                        <option value="10000000" <?= $filters['max_price'] === '10000000' ? 'selected' : '' ?>>Rs. 10M</option>
                        <option value="25000000" <?= $filters['max_price'] === '25000000' ? 'selected' : '' ?>>Rs. 25M</option>
                        <option value="50000000" <?= $filters['max_price'] === '50000000' ? 'selected' : '' ?>>Rs. 50M</option>
                        <option value="100000000" <?= $filters['max_price'] === '100000000' ? 'selected' : '' ?>>Rs. 100M</option>
                    </select>
                </div>
                
                <div class="col-md-1">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Section -->
    <div class="results-section py-5">
        <div class="container">
            <!-- Results Header -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h3 class="mb-0">
                        <?= $totalProperties ?> Properties Found
                        <?php if (!empty(array_filter($filters))): ?>
                            <small class="text-muted">(filtered)</small>
                        <?php endif; ?>
                    </h3>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary active" onclick="setView('grid')">
                            <i class="fas fa-th"></i>
                        </button>
                        <button type="button" class="btn btn-outline-primary" onclick="setView('list')">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Properties Grid -->
            <div class="row" id="properties-container">
                <?php if (empty($properties)): ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-search text-muted mb-3" style="font-size: 4rem;"></i>
                            <h4 class="text-muted">No properties found</h4>
                            <p class="text-muted">Try adjusting your search criteria</p>
                            <a href="/" class="btn btn-primary">Clear Filters</a>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($properties as $property): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card property-card h-100">
                                <div class="property-image position-relative">
                                    <img src="<?= imageUrl($property['thumbnail_path'] ?: $property['image_path']) ?>" 
                                         alt="<?= e($property['title']) ?>"
                                         class="card-img-top">
                                    <div class="property-badges">
                                        <span class="badge bg-primary position-absolute top-0 start-0 m-2">
                                            <?= formatCurrency($property['price'], $property['currency']) ?>
                                        </span>
                                        <?php if ($property['featured']): ?>
                                            <span class="badge bg-warning position-absolute top-0 end-0 m-2">
                                                <i class="fas fa-star me-1"></i>Featured
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="property-overlay">
                                        <div class="property-actions">
                                            <a href="<?= propertyUrl($property['id']) ?>" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <a href="<?= propertyUrl($property['id']) ?>" class="text-decoration-none text-dark">
                                            <?= e(truncate($property['title'], 60)) ?>
                                        </a>
                                    </h6>
                                    
                                    <p class="card-text text-muted small">
                                        <?= e(truncate($property['short_description'], 100)) ?>
                                    </p>
                                    
                                    <div class="property-meta mb-3">
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <div class="meta-item">
                                                    <i class="fas fa-bed text-primary"></i>
                                                    <div class="small"><?= $property['bedrooms'] ?> BR</div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="meta-item">
                                                    <i class="fas fa-bath text-primary"></i>
                                                    <div class="small"><?= $property['bathrooms'] ?> BA</div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="meta-item">
                                                    <i class="fas fa-ruler-combined text-primary"></i>
                                                    <div class="small"><?= number_format($property['area_sqft']) ?> sq ft</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="property-location">
                                        <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                        <span class="small text-muted"><?= e($property['location']) ?></span>
                                    </div>
                                </div>
                                
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            <?= formatDate($property['created_at']) ?>
                                        </small>
                                        <div class="property-actions">
                                            <a href="<?= propertyUrl($property['id']) ?>" class="btn btn-primary btn-sm">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <nav aria-label="Properties pagination" class="mt-5">
                    <ul class="pagination justify-content-center">
                        <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?<?= http_build_query(array_merge($filters, ['page' => $currentPage - 1])) ?>">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                            <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                                <a class="page-link" href="?<?= http_build_query(array_merge($filters, ['page' => $i])) ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if ($currentPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?<?= http_build_query(array_merge($filters, ['page' => $currentPage + 1])) ?>">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function setView(view) {
    const container = document.getElementById('properties-container');
    const buttons = document.querySelectorAll('.btn-group .btn');
    
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    if (view === 'list') {
        container.classList.add('list-view');
    } else {
        container.classList.remove('list-view');
    }
}
</script>

<style>
.property-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.property-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.property-image {
    overflow: hidden;
    position: relative;
}

.property-image img {
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.property-card:hover .property-image img {
    transform: scale(1.05);
}

.property-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.property-card:hover .property-overlay {
    opacity: 1;
}

.meta-item {
    text-align: center;
}

.meta-item i {
    font-size: 1.2rem;
    margin-bottom: 0.25rem;
}

.list-view .col-lg-4 {
    flex: 0 0 100%;
    max-width: 100%;
}

.list-view .property-card {
    display: flex;
    flex-direction: row;
}

.list-view .property-image {
    width: 300px;
    flex-shrink: 0;
}

.list-view .card-body {
    flex: 1;
}
</style>

<?php
$content = ob_get_clean();

// Include the layout
extract(compact('title', 'description', 'content'));
include APP_PATH . '/views/layouts/app.php';
?>
