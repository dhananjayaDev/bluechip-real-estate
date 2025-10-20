<?php
// Initialize components
require_once APP_PATH . '/components/BaseLayout.php';

// Prepare data for components
$layoutData = [
    'pageTitle' => 'Manage Properties - Admin Dashboard',
    'pageDescription' => 'Manage your real estate properties',
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
    <!-- Admin Properties Section -->
    <section class="admin-properties">
        <div class="container">
            <div class="admin-header">
                <div class="header-content">
                    <div class="header-text">
                        <h1>Manage Properties</h1>
                        <p>View and manage all properties in your system.</p>
                    </div>
                    <div class="header-actions">
                        <a href="/admin/properties/add" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Property
                        </a>
                    </div>
                </div>
                
                <!-- Search and Filter Section -->
                <div class="search-filter-section">
                    <form method="GET" action="/admin/properties" class="search-filter-form">
                        <div class="search-row">
                            <div class="search-group">
                                <label for="search">Search Properties</label>
                                <input type="text" id="search" name="search" class="form-control" placeholder="Search by title, location, or description..." value="' . htmlspecialchars($_GET['search'] ?? '') . '">
                            </div>
                            <div class="filter-group">
                                <label for="status_filter">Status</label>
                                <select id="status_filter" name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="available" ' . (($_GET['status'] ?? '') === 'available' ? 'selected' : '') . '>Available</option>
                                    <option value="unavailable" ' . (($_GET['status'] ?? '') === 'unavailable' ? 'selected' : '') . '>Unavailable</option>
                                    <option value="sold" ' . (($_GET['status'] ?? '') === 'sold' ? 'selected' : '') . '>Sold</option>
                                    <option value="rented" ' . (($_GET['status'] ?? '') === 'rented' ? 'selected' : '') . '>Rented</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label for="type_filter">Type</label>
                                <select id="type_filter" name="type" class="form-control">
                                    <option value="">All Types</option>
                                    <option value="house" ' . (($_GET['type'] ?? '') === 'house' ? 'selected' : '') . '>House</option>
                                    <option value="apartment" ' . (($_GET['type'] ?? '') === 'apartment' ? 'selected' : '') . '>Apartment</option>
                                    <option value="condo" ' . (($_GET['type'] ?? '') === 'condo' ? 'selected' : '') . '>Condo</option>
                                    <option value="villa" ' . (($_GET['type'] ?? '') === 'villa' ? 'selected' : '') . '>Villa</option>
                                    <option value="land" ' . (($_GET['type'] ?? '') === 'land' ? 'selected' : '') . '>Land</option>
                                    <option value="commercial" ' . (($_GET['type'] ?? '') === 'commercial' ? 'selected' : '') . '>Commercial</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label for="featured_filter">Featured</label>
                                <select id="featured_filter" name="featured" class="form-control">
                                    <option value="">All Properties</option>
                                    <option value="1" ' . (($_GET['featured'] ?? '') === '1' ? 'selected' : '') . '>Featured Only</option>
                                    <option value="0" ' . (($_GET['featured'] ?? '') === '0' ? 'selected' : '') . '>Non-Featured</option>
                                </select>
                            </div>
                            <div class="filter-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <a href="/admin/properties" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Bulk Actions -->
            <div class="bulk-actions-section">
                <form method="POST" action="/admin/properties/bulk-action" id="bulkActionForm">
                    <input type="hidden" name="csrf_token" value="' . ($csrfToken ?? '') . '">
                    <div class="bulk-controls">
                        <div class="bulk-select">
                            <input type="checkbox" id="selectAll" class="form-check-input">
                            <label for="selectAll">Select All</label>
                        </div>
                        <div class="bulk-actions">
                            <select name="bulk_action" id="bulkAction" class="form-control" required>
                                <option value="">Choose Action</option>
                                <option value="featured">Mark as Featured</option>
                                <option value="unfeatured">Remove Featured</option>
                                <option value="available">Mark as Available</option>
                                <option value="unavailable">Mark as Unavailable</option>
                                <option value="delete">Delete Selected</option>
                            </select>
                            <button type="submit" class="btn btn-warning" id="bulkActionBtn" disabled>
                                <i class="fas fa-cogs"></i> Apply to Selected
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Properties Table -->
            <div class="properties-table-container">
                <table class="properties-table">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="selectAllHeader" class="form-check-input">
                            </th>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . renderPropertiesTable($properties) . '
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            ' . renderPagination($currentPage, $totalPages, '/admin/properties') . '
        </div>
    </section>
';

// Function to render properties table
function renderPropertiesTable($properties) {
    if (empty($properties)) {
        return '<tr><td colspan="11" class="text-center">No properties found.</td></tr>';
    }
    
    $html = '';
    foreach ($properties as $property) {
        $statusClass = $property['status'] === 'available' ? 'status-available' : 
                      ($property['status'] === 'sold' ? 'status-sold' : 
                      ($property['status'] === 'rented' ? 'status-rented' : 'status-unavailable'));
        $featuredClass = $property['featured'] ? 'featured-yes' : 'featured-no';
        
        // Get property image
        $imageUrl = !empty($property['images']) ? explode(',', $property['images'])[0] : 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=100&h=75&fit=crop';
        
        $html .= '
        <tr>
            <td>
                <input type="checkbox" name="selected_properties[]" value="' . $property['id'] . '" class="property-checkbox form-check-input">
            </td>
            <td>' . $property['id'] . '</td>
            <td>
                <div class="property-thumb">
                    <img src="' . $imageUrl . '" alt="' . htmlspecialchars($property['title']) . '">
                </div>
            </td>
            <td>
                <div class="property-title">
                    <strong>' . htmlspecialchars($property['title']) . '</strong>
                    <br><small>' . htmlspecialchars(substr($property['description'], 0, 50)) . '...</small>
                </div>
            </td>
            <td>' . ucfirst($property['property_type']) . '</td>
            <td>' . htmlspecialchars($property['location']) . '</td>
            <td>Rs. ' . number_format($property['price']) . '</td>
            <td>
                <div class="status-controls">
                    <span class="status-badge ' . $statusClass . '">' . ucfirst($property['status']) . '</span>
                    <button class="btn btn-xs btn-outline-primary toggle-status" data-id="' . $property['id'] . '" data-current="' . $property['status'] . '" title="Toggle Status">
                        <i class="fas fa-sync"></i>
                    </button>
                </div>
            </td>
            <td>
                <div class="featured-controls">
                    <span class="featured-badge ' . $featuredClass . '">' . ($property['featured'] ? 'Yes' : 'No') . '</span>
                    <button class="btn btn-xs btn-outline-warning toggle-featured" data-id="' . $property['id'] . '" data-current="' . $property['featured'] . '" title="Toggle Featured">
                        <i class="fas fa-star"></i>
                    </button>
                </div>
            </td>
            <td>' . date('M j, Y', strtotime($property['created_at'])) . '</td>
            <td>
                <div class="action-buttons">
                        <a href="/admin/property/' . $property['id'] . '" class="btn btn-sm btn-outline-primary" target="_blank" title="View Property">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="/admin/properties/' . $property['id'] . '/edit" class="btn btn-sm btn-outline-warning" title="Edit Property">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger delete-property" data-id="' . $property['id'] . '" title="Delete Property">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>';
    }
    
    return $html;
}

// Function to render pagination
function renderPagination($currentPage, $totalPages, $baseUrl) {
    if ($totalPages <= 1) return '';
    
    $html = '<div class="pagination-container">';
    $html .= '<nav class="pagination-nav">';
    $html .= '<ul class="pagination">';
    
    // Previous button
    if ($currentPage > 1) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '?page=' . ($currentPage - 1) . '">Previous</a></li>';
    }
    
    // Page numbers
    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($i == $currentPage) ? 'active' : '';
        $html .= '<li class="page-item ' . $activeClass . '"><a class="page-link" href="' . $baseUrl . '?page=' . $i . '">' . $i . '</a></li>';
    }
    
    // Next button
    if ($currentPage < $totalPages) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '?page=' . ($currentPage + 1) . '">Next</a></li>';
    }
    
    $html .= '</ul>';
    $html .= '</nav>';
    $html .= '</div>';
    
    return $html;
}

// Add page-specific CSS
$pageContent .= '
<style>
/* Admin Properties Styles */
.admin-properties {
    padding: 40px 0;
    background: #f8f9fa;
    min-height: 80vh;
}

.admin-header {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header-text h1 {
    color: var(--primary-color);
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
}

.header-text p {
    color: var(--text-color);
    margin: 5px 0 0 0;
}

/* Search and Filter Section */
.search-filter-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-top: 20px;
}

.search-filter-form {
    width: 100%;
}

.search-row {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr auto;
    gap: 15px;
    align-items: end;
}

.search-group, .filter-group {
    display: flex;
    flex-direction: column;
}

.search-group label, .filter-group label {
    font-weight: 500;
    margin-bottom: 5px;
    color: var(--text-color);
}

.filter-actions {
    display: flex;
    gap: 10px;
}

/* Bulk Actions */
.bulk-actions-section {
    background: white;
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.bulk-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.bulk-select {
    display: flex;
    align-items: center;
    gap: 10px;
}

.bulk-actions {
    display: flex;
    gap: 10px;
    align-items: center;
}

.bulk-actions select {
    min-width: 150px;
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

.btn-sm {
    padding: 5px 10px;
    font-size: 0.875rem;
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

.btn-outline-warning {
    background: transparent;
    color: #f59e0b;
    border: 1px solid #f59e0b;
}

.btn-outline-warning:hover {
    background: #f59e0b;
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

/* Properties Table */
.properties-table-container {
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    overflow: hidden;
}

.properties-table {
    width: 100%;
    border-collapse: collapse;
}

.properties-table th {
    background: var(--primary-color);
    color: white;
    padding: 15px;
    text-align: left;
    font-weight: 600;
}

.properties-table td {
    padding: 15px;
    border-bottom: 1px solid #eee;
    vertical-align: middle;
}

.properties-table tr:hover {
    background: #f8f9fa;
}

.property-thumb {
    width: 60px;
    height: 45px;
    border-radius: 5px;
    overflow: hidden;
}

.property-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.property-title {
    max-width: 200px;
}

.property-title strong {
    color: var(--secondary-color);
    font-size: 0.9rem;
}

.property-title small {
    color: #666;
    font-size: 0.8rem;
}

.status-badge, .featured-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.status-available {
    background: #dcfce7;
    color: #166534;
}

.status-unavailable {
    background: #fee2e2;
    color: #991b1b;
}

.status-sold {
    background: #dbeafe;
    color: #1e40af;
}

.status-rented {
    background: #fef3c7;
    color: #92400e;
}

/* Status and Featured Controls */
.status-controls, .featured-controls {
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-xs {
    padding: 3px 6px;
    font-size: 0.7rem;
    min-width: auto;
}

.toggle-status, .toggle-featured {
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.toggle-status:hover, .toggle-featured:hover {
    opacity: 1;
}

.featured-yes {
    background: #fef3c7;
    color: #92400e;
}

.featured-no {
    background: #f3f4f6;
    color: #6b7280;
}

.action-buttons {
    display: flex;
    gap: 5px;
}

.action-buttons .btn {
    padding: 5px 8px;
    font-size: 0.8rem;
}

/* Pagination */
.pagination-container {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

.pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
}

.page-item {
    margin: 0 2px;
}

.page-link {
    display: block;
    padding: 8px 12px;
    color: var(--primary-color);
    text-decoration: none;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.page-link:hover {
    background: var(--primary-color);
    color: white;
    text-decoration: none;
}

.page-item.active .page-link {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

/* Responsive Design */
@media (max-width: 768px) {
    .admin-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .properties-table-container {
        overflow-x: auto;
    }
    
    .properties-table {
        min-width: 800px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>
';

// Add JavaScript for enhanced functionality
$pageContent .= '
<script>
// CSRF token for AJAX requests
const csrfToken = "' . ($csrfToken ?? '') . '";

// Select All functionality
document.getElementById("selectAll").addEventListener("change", function() {
    const checkboxes = document.querySelectorAll(".property-checkbox");
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActionButton();
});

document.getElementById("selectAllHeader").addEventListener("change", function() {
    const checkboxes = document.querySelectorAll(".property-checkbox");
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    document.getElementById("selectAll").checked = this.checked;
    updateBulkActionButton();
});

// Individual checkbox change
document.addEventListener("change", function(e) {
    if (e.target.classList.contains("property-checkbox")) {
        updateBulkActionButton();
        updateSelectAllState();
    }
});

function updateBulkActionButton() {
    const selectedCount = document.querySelectorAll(".property-checkbox:checked").length;
    const bulkActionBtn = document.getElementById("bulkActionBtn");
    const bulkAction = document.getElementById("bulkAction");
    
    if (selectedCount > 0 && bulkAction.value) {
        bulkActionBtn.disabled = false;
        bulkActionBtn.textContent = `Apply to ${selectedCount} Selected`;
    } else {
        bulkActionBtn.disabled = true;
        bulkActionBtn.innerHTML = "<i class=\"fas fa-cogs\"></i> Apply to Selected";
    }
}

function updateSelectAllState() {
    const checkboxes = document.querySelectorAll(".property-checkbox");
    const checkedCount = document.querySelectorAll(".property-checkbox:checked").length;
    const selectAllCheckbox = document.getElementById("selectAll");
    const selectAllHeaderCheckbox = document.getElementById("selectAllHeader");
    
    if (checkedCount === 0) {
        selectAllCheckbox.indeterminate = false;
        selectAllCheckbox.checked = false;
        selectAllHeaderCheckbox.indeterminate = false;
        selectAllHeaderCheckbox.checked = false;
    } else if (checkedCount === checkboxes.length) {
        selectAllCheckbox.indeterminate = false;
        selectAllCheckbox.checked = true;
        selectAllHeaderCheckbox.indeterminate = false;
        selectAllHeaderCheckbox.checked = true;
    } else {
        selectAllCheckbox.indeterminate = true;
        selectAllCheckbox.checked = false;
        selectAllHeaderCheckbox.indeterminate = true;
        selectAllHeaderCheckbox.checked = false;
    }
}

// Bulk action form submission
document.getElementById("bulkActionForm").addEventListener("submit", function(e) {
    const selectedCount = document.querySelectorAll(".property-checkbox:checked").length;
    const action = document.getElementById("bulkAction").value;
    
    if (selectedCount === 0) {
        e.preventDefault();
        alert("Please select at least one property.");
        return;
    }
    
    if (!action) {
        e.preventDefault();
        alert("Please select an action.");
        return;
    }
    
    if (action === "delete") {
        if (!confirm(`Are you sure you want to delete ${selectedCount} properties? This action cannot be undone.`)) {
            e.preventDefault();
            return;
        }
    } else {
        if (!confirm(`Are you sure you want to apply this action to ${selectedCount} properties?`)) {
            e.preventDefault();
            return;
        }
    }
});

// Toggle status functionality
document.addEventListener("click", function(e) {
    if (e.target.closest(".toggle-status")) {
        const button = e.target.closest(".toggle-status");
        const propertyId = button.dataset.id;
        const currentStatus = button.dataset.current;
        
        togglePropertyStatus(propertyId, currentStatus);
    }
});

// Toggle featured functionality
document.addEventListener("click", function(e) {
    if (e.target.closest(".toggle-featured")) {
        const button = e.target.closest(".toggle-featured");
        const propertyId = button.dataset.id;
        const currentFeatured = button.dataset.current;
        
        toggleFeatured(propertyId, currentFeatured);
    }
});

// Delete property functionality
document.addEventListener("click", function(e) {
    if (e.target.closest(".delete-property")) {
        const button = e.target.closest(".delete-property");
        const propertyId = button.dataset.id;
        
        if (confirm("Are you sure you want to delete this property? This action cannot be undone.")) {
            deleteProperty(propertyId);
        }
    }
});

// AJAX functions
function togglePropertyStatus(propertyId, currentStatus) {
    const formData = new FormData();
    formData.append("csrf_token", csrfToken);
    
    fetch(`/admin/properties/${propertyId}/toggle-status`, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the status badge and button
            const row = document.querySelector(`[data-id="${propertyId}"]`).closest("tr");
            const statusBadge = row.querySelector(".status-badge");
            const toggleButton = row.querySelector(".toggle-status");
            
            statusBadge.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
            statusBadge.className = `status-badge status-${data.status}`;
            toggleButton.dataset.current = data.status;
            
            showNotification("Status updated successfully!", "success");
        } else {
            showNotification(data.message || "Failed to update status", "error");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showNotification("An error occurred while updating status", "error");
    });
}

function toggleFeatured(propertyId, currentFeatured) {
    const formData = new FormData();
    formData.append("csrf_token", csrfToken);
    
    fetch(`/admin/properties/${propertyId}/toggle-featured`, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the featured badge and button
            const row = document.querySelector(`[data-id="${propertyId}"]`).closest("tr");
            const featuredBadge = row.querySelector(".featured-badge");
            const toggleButton = row.querySelector(".toggle-featured");
            
            featuredBadge.textContent = data.featured ? "Yes" : "No";
            featuredBadge.className = `featured-badge ${data.featured ? "featured-yes" : "featured-no"}`;
            toggleButton.dataset.current = data.featured;
            
            showNotification("Featured status updated successfully!", "success");
        } else {
            showNotification(data.message || "Failed to update featured status", "error");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showNotification("An error occurred while updating featured status", "error");
    });
}

function deleteProperty(propertyId) {
    const formData = new FormData();
    formData.append("csrf_token", csrfToken);
    
    fetch(`/admin/properties/${propertyId}/delete`, {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (response.ok) {
            // Remove the row from the table
            const row = document.querySelector(`[data-id="${propertyId}"]`).closest("tr");
            row.remove();
            showNotification("Property deleted successfully!", "success");
        } else {
            showNotification("Failed to delete property", "error");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showNotification("An error occurred while deleting property", "error");
    });
}

// Notification system
function showNotification(message, type = "info") {
    const notification = document.createElement("div");
    notification.className = `notification notification-${type}`;
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
</script>
';

// Add content to layout data
$layoutData['content'] = $pageContent;

// Create and render the layout
$layout = new BaseLayout($layoutData);
echo $layout->render();
?>
