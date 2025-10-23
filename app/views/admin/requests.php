<?php
// Initialize components
require_once APP_PATH . '/components/BaseLayout.php';

// Prepare data for components
$layoutData = [
    'pageTitle' => 'Manage Requests - Admin Dashboard',
    'pageDescription' => 'Manage property inquiries and requests',
    'activePage' => 'requests',
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
    <!-- Admin Requests Section -->
    <section class="admin-requests">
        <div class="container">
            <div class="admin-header">
                <h1>Manage Requests</h1>
                <p>View and manage all property inquiries and requests.</p>
            </div>
            
            <!-- Requests Table -->
            <div class="requests-table-container">
                <table class="requests-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Property</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . renderRequestsTable($requests) . '
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            ' . renderPagination($currentPage, $totalPages, '/admin/requests') . '
        </div>
    </section>
    
    <!-- Request Details Modal -->
    <div class="modal fade" id="requestDetailsModal" tabindex="-1" aria-labelledby="requestDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestDetailsModalLabel">
                        <i class="fas fa-envelope me-2"></i>
                        Request Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="requestDetailsContent">
                    <!-- Content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
';

// Function to render requests table
function renderRequestsTable($requests) {
    if (empty($requests)) {
        return '<tr><td colspan="9" class="text-center">No requests found.</td></tr>';
    }
    
    $html = '';
    foreach ($requests as $request) {
        $statusClass = $request['status'] === 'pending' ? 'status-pending' : 
                      ($request['status'] === 'contacted' ? 'status-contacted' : 'status-completed');
        
        $html .= '
        <tr>
            <td>' . $request['id'] . '</td>
            <td>
                <div class="property-info">
                    <strong>' . htmlspecialchars($request['property_title'] ?? 'Property #' . $request['property_id']) . '</strong>
                    <br><small>' . htmlspecialchars($request['property_location'] ?? 'Location not available') . '</small>
                </div>
            </td>
            <td>' . htmlspecialchars($request['name']) . '</td>
            <td>' . htmlspecialchars($request['email']) . '</td>
            <td>' . ($request['phone'] ? htmlspecialchars($request['phone']) : 'N/A') . '</td>
            <td>' . ucfirst($request['contact_method']) . '</td>
            <td><span class="status-badge ' . $statusClass . '">' . ucfirst($request['status']) . '</span></td>
            <td>' . date('M j, Y', strtotime($request['created_at'])) . '</td>
            <td>
                <div class="action-buttons">
                    <button class="btn btn-sm btn-outline-primary view-request-btn" data-request-id="' . $request['id'] . '" title="View Details">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-success" onclick="markContacted(' . $request['id'] . ')" ' . ($request['status'] !== 'pending' ? 'disabled' : '') . ' title="Mark as Contacted">
                        <i class="fas fa-phone"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-warning" onclick="markCompleted(' . $request['id'] . ')" ' . ($request['status'] === 'completed' ? 'disabled' : '') . ' title="Mark as Completed">
                        <i class="fas fa-check"></i>
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
/* Admin Requests Styles */
.admin-requests {
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

.admin-header h1 {
    color: var(--primary-color);
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 10px 0;
}

.admin-header p {
    color: var(--text-color);
    margin: 0;
}

/* Requests Table */
.requests-table-container {
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    overflow: hidden;
}

.requests-table {
    width: 100%;
    border-collapse: collapse;
}

.requests-table th {
    background: var(--primary-color);
    color: white;
    padding: 15px;
    text-align: left;
    font-weight: 600;
}

.requests-table td {
    padding: 15px;
    border-bottom: 1px solid #eee;
    vertical-align: middle;
}

.requests-table tr:hover {
    background: #f8f9fa;
}

.property-info strong {
    color: var(--secondary-color);
    font-size: 0.9rem;
}

.property-info small {
    color: #666;
    font-size: 0.8rem;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
}

.status-contacted {
    background: #dbeafe;
    color: #1e40af;
}

.status-completed {
    background: #dcfce7;
    color: #166534;
}

.action-buttons {
    display: flex;
    gap: 5px;
}

.action-buttons .btn {
    padding: 5px 8px;
    font-size: 0.8rem;
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

.btn-outline-success {
    background: transparent;
    color: #10b981;
    border: 1px solid #10b981;
}

.btn-outline-success:hover {
    background: #10b981;
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

.btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
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
    .requests-table-container {
        overflow-x: auto;
    }
    
    .requests-table {
        min-width: 800px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>
';

// Add JavaScript for request actions
$pageContent .= '
<script>
// CSRF token for AJAX requests
const csrfToken = "' . ($csrfToken ?? '') . '";

// Handle view request button clicks
document.addEventListener("click", function(e) {
    if (e.target.closest(".view-request-btn")) {
        const button = e.target.closest(".view-request-btn");
        const requestId = button.dataset.requestId;
        viewRequest(requestId);
    }
});

function viewRequest(requestId) {
    // Show loading state
    const modalContent = document.getElementById("requestDetailsContent");
    modalContent.innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading request details...</p>
        </div>
    `;
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById("requestDetailsModal"));
    modal.show();
    
    // Fetch request details
    fetch("/admin/requests/" + requestId + "/details", {
        method: "GET",
        headers: {
            "X-CSRF-Token": csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            modalContent.innerHTML = renderRequestDetails(data.request);
        } else {
            modalContent.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    \${data.message}
                </div>
            `;
        }
    })
    .catch(error => {
        console.error("Error:", error);
        modalContent.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                An error occurred while loading request details.
            </div>
        `;
    });
}

function renderRequestDetails(request) {
    return `
        <div class="request-details">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Contact Information</h6>
                    <div class="info-item">
                        <label>Name:</label>
                        <span>\${request.name}</span>
                    </div>
                    <div class="info-item">
                        <label>Email:</label>
                        <span><a href="mailto:\${request.email}">\${request.email}</a></span>
                    </div>
                    <div class="info-item">
                        <label>Phone:</label>
                        <span>\${request.phone || \'N/A\'}</span>
                    </div>
                    <div class="info-item">
                        <label>Contact Method:</label>
                        <span class="badge bg-info">\${request.contact_method}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary mb-3"><i class="fas fa-home me-2"></i>Property Information</h6>
                    <div class="info-item">
                        <label>Property:</label>
                        <span><strong>\${request.property_title || \'Property #\' + request.property_id}</strong></span>
                    </div>
                    <div class="info-item">
                        <label>Location:</label>
                        <span>\${request.property_location || \'N/A\'}</span>
                    </div>
                    <div class="info-item">
                        <label>Price:</label>
                        <span>\${request.property_price ? \'Rs. \' + new Intl.NumberFormat().format(request.property_price) : \'N/A\'}</span>
                    </div>
                    <div class="info-item">
                        <label>Status:</label>
                        <span class="badge bg-\${request.status === \'pending\' ? \'warning\' : (request.status === \'contacted\' ? \'info\' : \'success\')}">\${request.status}</span>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="row">
                <div class="col-12">
                    <h6 class="text-primary mb-3"><i class="fas fa-comment me-2"></i>Message</h6>
                    <div class="message-content p-3 bg-light rounded">
                        \${request.message}
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-primary mb-3"><i class="fas fa-calendar me-2"></i>Request Details</h6>
                    <div class="info-item">
                        <label>Request Date:</label>
                        <span>\${new Date(request.created_at).toLocaleDateString()}</span>
                    </div>
                    <div class="info-item">
                        <label>Request Time:</label>
                        <span>\${new Date(request.created_at).toLocaleTimeString()}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary mb-3"><i class="fas fa-tools me-2"></i>Quick Actions</h6>
                    <div class="d-flex gap-2">
                        <a href="mailto:\${request.email}?subject=Re: Property Inquiry - \${request.property_title || \'Property #\' + request.property_id}" class="btn btn-sm btn-primary">
                            <i class="fas fa-envelope me-1"></i>Reply Email
                        </a>
                        \${request.phone ? `<a href="tel:\${request.phone}" class="btn btn-sm btn-success">
                            <i class="fas fa-phone me-1"></i>Call
                        </a>` : \'\'}
                        <a href="/property/\${request.property_id}" target="_blank" class="btn btn-sm btn-info">
                            <i class="fas fa-external-link-alt me-1"></i>View Property
                        </a>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function markContacted(requestId) {
    if (confirm("Mark this request as contacted?")) {
        updateRequestStatus(requestId, "contacted");
    }
}

function markCompleted(requestId) {
    if (confirm("Mark this request as completed?")) {
        updateRequestStatus(requestId, "completed");
    }
}

function updateRequestStatus(requestId, status) {
    const formData = new FormData();
    formData.append("csrf_token", csrfToken);
    formData.append("status", status);
    
    fetch("/admin/requests/" + requestId + "/update-status", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, "success");
            // Reload the page to update the status
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showNotification(data.message, "error");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showNotification("An error occurred while updating status", "error");
    });
}

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
    .request-details .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }
    .request-details .info-item:last-child {
        border-bottom: none;
    }
    .request-details .info-item label {
        font-weight: 600;
        color: #666;
        margin: 0;
    }
    .request-details .info-item span {
        color: var(--primary-color);
        font-weight: 500;
    }
    .message-content {
        white-space: pre-wrap;
        line-height: 1.6;
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
