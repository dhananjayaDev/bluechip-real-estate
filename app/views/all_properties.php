<?php
// Properties data is now passed from the controller
$allProperties = $properties ?? [];

// Properties data is passed from the controller via extract()
// $properties, $filters, $totalProperties are available from the controller

// Initialize components
require_once APP_PATH . '/components/BaseLayout.php';

// Prepare data for components
$layoutData = [
    'pageTitle' => 'All Properties - Bluechip Real Estate',
    'pageDescription' => 'Discover your perfect home from our extensive collection of premium properties across Sri Lanka.',
    'activePage' => 'properties',
    'csrfToken' => $csrfToken ?? '',
    'includeModals' => true,
    'email' => 'hello@bluechiplands.asia',
    'phone' => '(+94) 71 609 2918',
    'logoPath' => '/public/images/uploads/logo.jpeg',
    'companyName' => 'Bluechip Real Estate (Pvt) Limited',
    'tagline' => 'අපේ රටේ ඉඩමක් ගන්න හොඳම තැන',
    'aboutText' => 'Bluechip Real Estate (PVT) Limited has been established with the vision To deliver the highest value in real estate industry through innovation and integrity.',
    'address' => 'World Trade Center, West Tower,<br>Level 37, Colombo 01, Sri Lanka',
    'facebookUrl' => 'https://www.facebook.com/p/Bluechip-Real-Estate-100091440704853/',
    'whatsappUrl' => 'https://wa.me/94716092918',
    'disabledNavItems' => ['about', 'contact'] // Disable About and Contact links
];

// Function to render properties
function renderProperties($properties) {
    if (empty($properties)) {
        return '<div class="text-center"><p>No properties available at the moment.</p></div>';
    }
    
    $html = '';
    foreach ($properties as $property) {
        // Unique images for each property - using property ID for variety
        $allImages = [
            'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1497366216548-37526070297c?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=400&h=300&fit=crop',
            'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=400&h=300&fit=crop'
        ];
        
        // Use property ID to select a unique image
        $imageIndex = ($property['id'] - 1) % count($allImages);
        $defaultImage = $allImages[$imageIndex];
        $imageUrl = !empty($property['images']) ? explode(',', $property['images'])[0] : $defaultImage;
        
        $html .= '<a href="/property/' . $property['id'] . '" class="property-card">';
        $html .= '<div class="property-image" style="background-image: url(\'' . $imageUrl . '\')">';
        $html .= '<div class="property-price">Rs. ' . number_format($property['price']) . '</div>';
        $html .= '</div>';
        $html .= '<div class="property-content">';
        $html .= '<h5>' . htmlspecialchars($property['title']) . '</h5>';
        $html .= '<div class="property-location">';
        $html .= '<i class="fas fa-map-marker-alt"></i> ' . htmlspecialchars($property['location']);
        $html .= '</div>';
        $html .= '<p>' . htmlspecialchars(substr($property['description'], 0, 100)) . '...</p>';
        $html .= '<div class="property-features">';
        $html .= '<div class="feature"><i class="fas fa-bed"></i><span>' . $property['bedrooms'] . '</span></div>';
        $html .= '<div class="feature"><i class="fas fa-bath"></i><span>' . $property['bathrooms'] . '</span></div>';
        $html .= '<div class="feature"><i class="fas fa-car"></i><span>' . (!empty($property['parking']) ? explode(',', $property['parking'])[0] : 'N/A') . '</span></div>';
        $html .= '<div class="feature"><i class="fas fa-ruler-combined"></i><span>' . ($property['area_sqft'] ?? 'N/A') . ' sq ft</span></div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</a>';
    }
    
    return $html;
}

// Determine if this is a search result or all properties
$isSearchResult = !empty(array_filter($filters ?? []));
$totalProperties = $totalProperties ?? count($allProperties);

// Create the page content
$pageContent = '
    <!-- Properties Section -->
    <section class="properties-section">
        <div class="container">
            <h2 class="section-title">' . ($isSearchResult ? 'Search Results' : 'All Properties') . '</h2>
            <p class="section-subtitle">' . ($isSearchResult ? 'Properties matching your search criteria' : 'Discover your perfect home from our extensive collection') . '</p>
            
            ' . ($isSearchResult ? '<div class="search-results-info mb-4"><strong>' . $totalProperties . ' Properties Found</strong></div>' : '') . '
            
            <div class="properties-grid">
                ' . renderProperties($allProperties) . '
            </div>
        </div>
    </section>
';

// Add page-specific CSS
$pageContent .= '
<style>

/* Properties Section */
.properties-section {
    padding: 80px 0;
    background: #ffffff;
}

.search-results-info {
    background-color: #f8fafc;
    padding: 15px 20px;
    border-radius: 8px;
    border-left: 4px solid var(--primary-color);
    color: #374151;
    font-size: 1.1rem;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1f2937;
    text-align: center;
    margin-bottom: 20px;
}

.section-subtitle {
    font-size: 1.1rem;
    color: #6b7280;
    text-align: center;
    margin-bottom: 60px;
}

.properties-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 60px;
}

.property-card {
    background-color: var(--white);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    margin-bottom: 30px;
    height: 100%;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    color: inherit;
}

.property-card:hover {
    transform: translateY(-5px);
    text-decoration: none;
    color: inherit;
}

.property-image {
    height: 250px;
    background-size: cover;
    background-position: center;
    position: relative;
}

.property-price {
    position: absolute;
    top: 15px;
    right: 15px;
    background-color: var(--primary-color);
    color: var(--white);
    padding: 8px 15px;
    border-radius: 20px;
    font-weight: 600;
}

.property-content {
    padding: 25px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.property-content h5 {
    color: var(--secondary-color);
    font-weight: 600;
    margin-bottom: 10px;
}

.property-content h5 a {
    color: var(--secondary-color);
    text-decoration: none;
}

.property-content h5 a:hover {
    color: var(--primary-color);
}

.property-location {
    color: var(--text-color);
    margin-bottom: 15px;
}

.property-content p {
    flex: 1;
    margin-bottom: 15px;
    min-height: 60px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}

.property-features {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid #e9ecef;
    margin-top: auto;
}

.feature {
    display: flex;
    align-items: center;
    color: var(--text-color);
    font-size: 14px;
}

.feature i {
    margin-right: 5px;
    color: var(--primary-color);
}

/* Responsive Design */
@media (max-width: 768px) {
    .search-form {
        grid-template-columns: 1fr;
        padding: 30px 20px;
    }
    
    .search-form-container h2 {
        font-size: 2rem;
    }
    
    .properties-grid {
        grid-template-columns: 1fr;
    }
    
    .section-title {
        font-size: 2rem;
    }
}
</style>
';

// Add page-specific JavaScript
$pageContent .= '
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Search form submission
    const searchForm = document.querySelector(".search-form");
    if (searchForm) {
        searchForm.addEventListener("submit", function(e) {
            e.preventDefault();
            // For now, just show an alert
            alert(\'Search functionality will be implemented soon!\');
        });
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