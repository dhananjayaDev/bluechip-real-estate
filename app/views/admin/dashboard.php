<?php
// Initialize components
require_once APP_PATH . '/components/BaseLayout.php';

// Prepare data for components
$layoutData = [
    'pageTitle' => 'Admin Dashboard - Bluechip Real Estate',
    'pageDescription' => 'Manage your real estate properties and users',
    'activePage' => 'dashboard',
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
    <!-- Admin Dashboard Section -->
    <section class="admin-dashboard">
        <div class="container">
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="stat-content">
                        <h3>' . $stats['total_properties'] . '</h3>
                        <p>Total Properties</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-content">
                        <h3>' . $stats['featured_properties'] . '</h3>
                        <p>Featured Properties</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3>' . $stats['total_users'] . '</h3>
                        <p>Total Users</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stat-content">
                        <h3>' . $stats['pending_requests'] . '</h3>
                        <p>Pending Requests</p>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="quick-actions">
                <h2>Quick Actions</h2>
                <div class="action-buttons">
                    <a href="/admin/properties" class="action-btn">
                        <i class="fas fa-home"></i>
                        <span>Manage Properties</span>
                    </a>
                    <a href="/admin/users" class="action-btn">
                        <i class="fas fa-users"></i>
                        <span>Manage Users</span>
                    </a>
                    <a href="/admin/requests" class="action-btn">
                        <i class="fas fa-envelope"></i>
                        <span>View Requests</span>
                    </a>
                    <a href="/admin/properties/add" class="action-btn">
                        <i class="fas fa-plus"></i>
                        <span>Add Property</span>
                    </a>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="recent-activity">
                <div class="activity-section">
                    <h3>Recent Properties</h3>
                    <div class="activity-list">
                        ' . renderRecentProperties($recent_properties) . '
                    </div>
                </div>
                
                <div class="activity-section">
                    <h3>Recent Requests</h3>
                    <div class="activity-list">
                        ' . renderRecentRequests($recent_requests) . '
                    </div>
                </div>
            </div>
        </div>
    </section>
';

// Function to render recent properties
function renderRecentProperties($properties) {
    if (empty($properties)) {
        return '<p class="no-data">No recent properties found.</p>';
    }
    
    $html = '';
    foreach ($properties as $property) {
        $html .= '
        <div class="activity-item">
            <div class="activity-icon">
                <i class="fas fa-home"></i>
            </div>
            <div class="activity-content">
                <h4>' . htmlspecialchars($property['title']) . '</h4>
                <p>' . htmlspecialchars($property['location']) . ' • Rs. ' . number_format($property['price']) . '</p>
                <small>' . date('M j, Y', strtotime($property['created_at'])) . '</small>
            </div>
        </div>';
    }
    
    return $html;
}

// Function to render recent requests
function renderRecentRequests($requests) {
    if (empty($requests)) {
        return '<p class="no-data">No recent requests found.</p>';
    }
    
    $html = '';
    foreach ($requests as $request) {
        $html .= '
        <div class="activity-item">
            <div class="activity-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="activity-content">
                <h4>Property Inquiry</h4>
                <p>Property ID: ' . $request['property_id'] . ' • ' . ucfirst($request['contact_method']) . '</p>
                <small>' . date('M j, Y', strtotime($request['created_at'])) . '</small>
            </div>
        </div>';
    }
    
    return $html;
}

// Add page-specific CSS
$pageContent .= '
<style>
/* Admin Dashboard Styles */
.admin-dashboard {
    padding: 40px 0;
    background: #f8f9fa;
    min-height: 80vh;
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

.btn-outline-primary {
    background: transparent;
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
}

.btn-outline-primary:hover {
    background: var(--primary-color);
    color: white;
    text-decoration: none;
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

.btn i {
    margin-right: 5px;
}

/* Statistics Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
}

.stat-icon i {
    color: white;
    font-size: 24px;
}

.stat-content h3 {
    color: var(--primary-color);
    font-size: 2rem;
    font-weight: 700;
    margin: 0 0 5px 0;
}

.stat-content p {
    color: var(--text-color);
    margin: 0;
    font-weight: 500;
}

/* Quick Actions */
.quick-actions {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin-bottom: 40px;
}

.quick-actions h2 {
    color: var(--primary-color);
    margin-bottom: 20px;
}

.action-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.action-btn {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.action-btn:hover {
    background: #1e40af;
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
}

.action-btn i {
    margin-right: 10px;
    font-size: 18px;
}

/* Recent Activity */
.recent-activity {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 30px;
}

.activity-section {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.activity-section h3 {
    color: var(--primary-color);
    margin-bottom: 20px;
    border-bottom: 2px solid var(--primary-color);
    padding-bottom: 10px;
}

.activity-item {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 40px;
    height: 40px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
}

.activity-icon i {
    color: var(--primary-color);
    font-size: 16px;
}

.activity-content h4 {
    color: var(--secondary-color);
    font-size: 1rem;
    margin: 0 0 5px 0;
}

.activity-content p {
    color: var(--text-color);
    font-size: 0.9rem;
    margin: 0 0 5px 0;
}

.activity-content small {
    color: #999;
    font-size: 0.8rem;
}

.no-data {
    color: var(--text-color);
    font-style: italic;
    text-align: center;
    padding: 20px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        grid-template-columns: 1fr;
    }
    
    .recent-activity {
        grid-template-columns: 1fr;
    }
    
    .header-content h1 {
        font-size: 2rem;
    }
}
</style>
';

// Add content to layout data
$layoutData['content'] = $pageContent;

// Create and render the layout
$layout = new BaseLayout($layoutData);
echo $layout->render();
?>
