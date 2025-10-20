<?php
// Initialize components
require_once APP_PATH . '/components/BaseLayout.php';

// Prepare data for components
$layoutData = [
    'pageTitle' => 'Manage Users - Admin Dashboard',
    'pageDescription' => 'Manage user accounts and permissions',
    'activePage' => 'users',
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
    <!-- Admin Users Section -->
    <section class="admin-users">
        <div class="container">
            <div class="admin-header">
                <h1>Manage Users</h1>
                <p>View and manage all user accounts in your system.</p>
            </div>
            
            <!-- Admin Users Table -->
            <div class="admin-section">
                <h3 class="section-title">Admin Users</h3>
                <div class="users-table-container">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            ' . renderAdminUsersTable($adminUsers) . '
                        </tbody>
                    </table>
                </div>
                
                <!-- Admin Pagination -->
                ' . renderPagination($currentPage, $totalPagesAdmins, '/admin/users', 'admin') . '
            </div>
            
            <!-- Regular Users Table -->
            <div class="users-section">
                <h3 class="section-title">Regular Users</h3>
                <div class="users-table-container">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Requests</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            ' . renderRegularUsersTable($regularUsers) . '
                        </tbody>
                    </table>
                </div>
                
                <!-- Users Pagination -->
                ' . renderPagination($currentPage, $totalPagesUsers, '/admin/users', 'users') . '
            </div>
        </div>
    </section>
';

// Function to render admin users table
function renderAdminUsersTable($adminUsers) {
    if (empty($adminUsers)) {
        return '<tr><td colspan="7" class="text-center">No admin users found.</td></tr>';
    }
    
    $html = '';
    foreach ($adminUsers as $user) {
        $html .= '
        <tr>
            <td>' . $user['id'] . '</td>
            <td>
                <div class="user-info">
                    <strong>' . htmlspecialchars($user['name']) . '</strong>
                </div>
            </td>
            <td>' . htmlspecialchars($user['email']) . '</td>
            <td>' . ($user['phone'] ? htmlspecialchars($user['phone']) : 'N/A') . '</td>
            <td><span class="role-badge role-admin">Admin</span></td>
            <td>' . date('M j, Y', strtotime($user['created_at'])) . '</td>
            <td>
                <div class="action-buttons">
                    <button class="btn btn-sm btn-outline-primary" onclick="viewUser(' . $user['id'] . ')" title="View User Details">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </td>
        </tr>';
    }
    
    return $html;
}

// Function to render regular users table
function renderRegularUsersTable($regularUsers) {
    if (empty($regularUsers)) {
        return '<tr><td colspan="8" class="text-center">No regular users found.</td></tr>';
    }
    
    $html = '';
    foreach ($regularUsers as $user) {
        $isBanned = $user['is_banned'] ?? false;
        $statusClass = $isBanned ? 'status-banned' : 'status-active';
        $statusText = $isBanned ? 'Banned' : 'Active';
        
        $html .= '
        <tr>
            <td>' . $user['id'] . '</td>
            <td>
                <div class="user-info">
                    <strong>' . htmlspecialchars($user['name']) . '</strong>
                </div>
            </td>
            <td>' . htmlspecialchars($user['email']) . '</td>
            <td>' . ($user['phone'] ? htmlspecialchars($user['phone']) : 'N/A') . '</td>
            <td>
                <span class="request-count">' . ($user['request_count'] ?? 0) . '</span>
            </td>
            <td>
                <span class="status-badge ' . $statusClass . '">' . $statusText . '</span>
            </td>
            <td>' . date('M j, Y', strtotime($user['created_at'])) . '</td>
            <td>
                <div class="action-buttons">
                    <button class="btn btn-sm btn-outline-primary" onclick="viewUser(' . $user['id'] . ')" title="View User Details">
                        <i class="fas fa-eye"></i>
                    </button>';
                    
        if ($isBanned) {
            $html .= '
                    <button class="btn btn-sm btn-outline-success unban-user" data-id="' . $user['id'] . '" data-email="' . htmlspecialchars($user['email']) . '" title="Unban User">
                        <i class="fas fa-unlock"></i>
                    </button>';
        } else {
            $html .= '
                    <button class="btn btn-sm btn-outline-danger ban-user" data-id="' . $user['id'] . '" data-email="' . htmlspecialchars($user['email']) . '" title="Ban User">
                        <i class="fas fa-ban"></i>
                    </button>';
        }
        
        $html .= '
                    <button class="btn btn-sm btn-outline-danger delete-user" data-id="' . $user['id'] . '" data-email="' . htmlspecialchars($user['email']) . '" title="Delete User">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>';
    }
    
    return $html;
}

// Function to render pagination
function renderPagination($currentPage, $totalPages, $baseUrl, $section = '') {
    if ($totalPages <= 1) return '';
    
    $html = '<div class="pagination-container">';
    $html .= '<nav class="pagination-nav">';
    $html .= '<ul class="pagination">';
    
    // Previous button
    if ($currentPage > 1) {
        $url = $section ? $baseUrl . '?page=' . ($currentPage - 1) . '&section=' . $section : $baseUrl . '?page=' . ($currentPage - 1);
        $html .= '<li class="page-item"><a class="page-link" href="' . $url . '">Previous</a></li>';
    }
    
    // Page numbers
    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($i == $currentPage) ? 'active' : '';
        $url = $section ? $baseUrl . '?page=' . $i . '&section=' . $section : $baseUrl . '?page=' . $i;
        $html .= '<li class="page-item ' . $activeClass . '"><a class="page-link" href="' . $url . '">' . $i . '</a></li>';
    }
    
    // Next button
    if ($currentPage < $totalPages) {
        $url = $section ? $baseUrl . '?page=' . ($currentPage + 1) . '&section=' . $section : $baseUrl . '?page=' . ($currentPage + 1);
        $html .= '<li class="page-item"><a class="page-link" href="' . $url . '">Next</a></li>';
    }
    
    $html .= '</ul>';
    $html .= '</nav>';
    $html .= '</div>';
    
    return $html;
}

// Add page-specific CSS
$pageContent .= '
<style>
/* Admin Users Styles */
.admin-users {
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

/* Section Titles */
.section-title {
    color: var(--primary-color);
    font-size: 1.5rem;
    font-weight: 600;
    margin: 30px 0 20px 0;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--primary-color);
}

.admin-section {
    margin-bottom: 40px;
}

.users-section {
    margin-bottom: 20px;
}

/* Users Table */
.users-table-container {
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    overflow: hidden;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
}

.users-table th {
    background: var(--primary-color);
    color: white;
    padding: 15px;
    text-align: left;
    font-weight: 600;
}

.users-table td {
    padding: 15px;
    border-bottom: 1px solid #eee;
    vertical-align: middle;
}

.users-table tr:hover {
    background: #f8f9fa;
}

.user-info strong {
    color: var(--secondary-color);
    font-size: 0.9rem;
}

.role-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.role-admin {
    background: #fef3c7;
    color: #92400e;
}

.role-user {
    background: #dcfce7;
    color: #166534;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.status-active {
    background: #dcfce7;
    color: #166534;
}

.status-banned {
    background: #fee2e2;
    color: #991b1b;
}

.request-count {
    background: var(--primary-color);
    color: white;
    padding: 2px 6px;
    border-radius: 10px;
    font-size: 0.7rem;
    font-weight: 500;
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

.btn-outline-danger:disabled {
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
    .users-table-container {
        overflow-x: auto;
    }
    
    .users-table {
        min-width: 600px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>
';

// Add JavaScript for user actions
$pageContent .= '
<script>
// CSRF token for AJAX requests
const csrfToken = "' . ($csrfToken ?? '') . '";

// Ban user functionality
document.addEventListener("click", function(e) {
    if (e.target.closest(".ban-user")) {
        const button = e.target.closest(".ban-user");
        const userId = button.dataset.id;
        const userEmail = button.dataset.email;
        
        const reason = prompt("Enter reason for banning this user:", "Violation of terms");
        if (reason !== null) {
            banUser(userId, reason);
        }
    }
});

// Unban user functionality
document.addEventListener("click", function(e) {
    if (e.target.closest(".unban-user")) {
        const button = e.target.closest(".unban-user");
        const userId = button.dataset.id;
        
        if (confirm("Are you sure you want to unban this user?")) {
            unbanUser(userId);
        }
    }
});

// Delete user functionality
document.addEventListener("click", function(e) {
    if (e.target.closest(".delete-user")) {
        const button = e.target.closest(".delete-user");
        const userId = button.dataset.id;
        const userEmail = button.dataset.email;
        
        if (confirm(`Are you sure you want to delete user "${userEmail}"? This action cannot be undone.`)) {
            deleteUser(userId);
        }
    }
});

function banUser(userId, reason) {
    const formData = new FormData();
    formData.append("csrf_token", csrfToken);
    formData.append("reason", reason);
    
    fetch(`/admin/users/${userId}/ban`, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, "success");
            // Update the UI
            updateUserStatus(userId, true);
        } else {
            showNotification(data.message, "error");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showNotification("An error occurred while banning user", "error");
    });
}

function unbanUser(userId) {
    const formData = new FormData();
    formData.append("csrf_token", csrfToken);
    
    fetch(`/admin/users/${userId}/unban`, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, "success");
            // Update the UI
            updateUserStatus(userId, false);
        } else {
            showNotification(data.message, "error");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showNotification("An error occurred while unbanning user", "error");
    });
}

function deleteUser(userId) {
    const formData = new FormData();
    formData.append("csrf_token", csrfToken);
    
    fetch(`/admin/users/${userId}/delete`, {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, "success");
            // Remove the user row from the table
            removeUserRow(userId);
        } else {
            showNotification(data.message, "error");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showNotification("An error occurred while deleting user", "error");
    });
}

function updateUserStatus(userId, isBanned) {
    const row = document.querySelector(`[data-id="${userId}"]`).closest("tr");
    const statusBadge = row.querySelector(".status-badge");
    const actionButtons = row.querySelector(".action-buttons");
    
    if (isBanned) {
        statusBadge.textContent = "Banned";
        statusBadge.className = "status-badge status-banned";
        
        // Replace ban button with unban button
        const banButton = actionButtons.querySelector(".ban-user");
        if (banButton) {
            banButton.outerHTML = `
                <button class="btn btn-sm btn-outline-success unban-user" data-id="${userId}" data-email="${banButton.dataset.email}" title="Unban User">
                    <i class="fas fa-unlock"></i>
                </button>
            `;
        }
    } else {
        statusBadge.textContent = "Active";
        statusBadge.className = "status-badge status-active";
        
        // Replace unban button with ban button
        const unbanButton = actionButtons.querySelector(".unban-user");
        if (unbanButton) {
            unbanButton.outerHTML = `
                <button class="btn btn-sm btn-outline-danger ban-user" data-id="${userId}" data-email="${unbanButton.dataset.email}" title="Ban User">
                    <i class="fas fa-ban"></i>
                </button>
            `;
        }
    }
}

function removeUserRow(userId) {
    const row = document.querySelector(`[data-id="${userId}"]`).closest("tr");
    if (row) {
        row.remove();
        
        // Check if table is empty
        const tbody = document.querySelector(".users-table tbody");
        const remainingRows = tbody.querySelectorAll("tr");
        if (remainingRows.length === 0) {
            tbody.innerHTML = "<tr><td colspan=\"9\" class=\"text-center\">No users found.</td></tr>";
        }
    }
}

function viewUser(userId) {
    console.log("View user:", userId);
    // Add view user functionality here
    showNotification("View user functionality coming soon", "info");
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
