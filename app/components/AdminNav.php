<?php

class AdminNav extends Component {
    
    public function render() {
        $currentPage = $this->getData('currentPage', 'dashboard');
        
        return '
        <nav class="admin-nav">
            <div class="admin-nav-container">
                <div class="admin-nav-brand">
                    <i class="fas fa-cogs"></i>
                    <span>Admin Panel</span>
                </div>
                
                <ul class="admin-nav-menu">
                    <li class="admin-nav-item">
                        <a href="/admin" class="admin-nav-link ' . ($currentPage === 'dashboard' ? 'active' : '') . '">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="admin-nav-item">
                        <a href="/admin/properties" class="admin-nav-link ' . ($currentPage === 'properties' ? 'active' : '') . '">
                            <i class="fas fa-home"></i>
                            <span>Properties</span>
                        </a>
                    </li>
                    <li class="admin-nav-item">
                        <a href="/admin/users" class="admin-nav-link ' . ($currentPage === 'users' ? 'active' : '') . '">
                            <i class="fas fa-users"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    <li class="admin-nav-item">
                        <a href="/admin/requests" class="admin-nav-link ' . ($currentPage === 'requests' ? 'active' : '') . '">
                            <i class="fas fa-envelope"></i>
                            <span>Requests</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        ';
    }
    
    public function renderCSS() {
        return '
        <style>
        /* Admin Navigation Styles */
        .admin-nav {
            background: var(--primary-color);
            padding: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .admin-nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }
        
        .admin-nav-brand {
            display: flex;
            align-items: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            padding: 15px 0;
        }
        
        .admin-nav-brand i {
            margin-right: 10px;
            font-size: 1.5rem;
        }
        
        .admin-nav-menu {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 0;
        }
        
        .admin-nav-item {
            margin: 0;
        }
        
        .admin-nav-link {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 5px;
            margin: 5px;
        }
        
        .admin-nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
        }
        
        .admin-nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .admin-nav-link i {
            margin-right: 8px;
            font-size: 1rem;
        }
        
        .admin-nav-link span {
            font-weight: 500;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .admin-nav-container {
                flex-direction: column;
                padding: 10px;
            }
            
            .admin-nav-menu {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }
            
            .admin-nav-link {
                padding: 10px 15px;
                font-size: 0.9rem;
            }
            
            .admin-nav-link span {
                display: none;
            }
            
            .admin-nav-link i {
                margin-right: 0;
            }
        }
        </style>
        ';
    }
}
