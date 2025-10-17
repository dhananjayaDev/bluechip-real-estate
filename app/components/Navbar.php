<?php

require_once 'Component.php';

class Navbar extends Component {
    
    public function render() {
        $activePage = $this->getData('activePage', '');
        $logoPath = $this->getData('logoPath', '/public/images/uploads/logo.jpeg');
        $companyName = $this->getData('companyName', 'Bluechip Real Estate (Pvt) Limited');
        $tagline = $this->getData('tagline', 'අපේ රටේ ඉඩමක් ගන්න හොඳම තැන');
        $disabledNavItems = $this->getData('disabledNavItems', []);
        
        $navItems = [
            ['href' => '/', 'text' => 'Home', 'key' => 'home'],
            ['href' => '/#about', 'text' => 'About', 'key' => 'about'],
            ['href' => '/properties', 'text' => 'Properties', 'key' => 'properties'],
            ['href' => '/#contact', 'text' => 'Contact', 'key' => 'contact']
        ];
        
        $navLinks = '';
        foreach ($navItems as $item) {
            $activeClass = ($activePage === $item['key']) ? ' active' : '';
            $disabledClass = in_array($item['key'], $disabledNavItems) ? ' disabled' : '';
            $href = in_array($item['key'], $disabledNavItems) ? '#' : $item['href'];
            $onclick = in_array($item['key'], $disabledNavItems) ? ' onclick="return false;"' : '';
            
            $navLinks .= "
            <li class=\"nav-item\">
                <a class=\"nav-link{$activeClass}{$disabledClass}\" href=\"{$href}\"{$onclick}>{$item['text']}</a>
            </li>";
        }
        
        return "
        <!-- Main Header -->
        <nav class=\"navbar navbar-expand-lg main-header\">
            <div class=\"container\">
                <a class=\"navbar-brand\" href=\"/\" style=\"color: #1e3a8a !important;\">
                    <div class=\"logo-container\">
                        <img src=\"{$logoPath}\" alt=\"Bluechip Real Estate Logo\" style=\"height: 50px;\">
                        <div class=\"company-info\">
                            <div class=\"company-name\">{$companyName}</div>
                            <div class=\"tagline sinhala-text\">{$tagline}</div>
                        </div>
                    </div>
                </a>
                
                <button class=\"navbar-toggler\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#navbarNav\">
                    <span class=\"navbar-toggler-icon\"></span>
                </button>
                
                <div class=\"collapse navbar-collapse\" id=\"navbarNav\">
                    <ul class=\"navbar-nav ms-auto\">
                        {$navLinks}
                        <li class=\"nav-item dropdown language-dropdown\">
                            <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"languageDropdown\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                                <i class=\"fas fa-globe me-1\"></i><span id=\"currentLanguage\">EN</span>
                            </a>
                            <ul class=\"dropdown-menu\" aria-labelledby=\"languageDropdown\">
                                <li><a class=\"dropdown-item\" href=\"#\" onclick=\"changeLanguage('en')\"><i class=\"fas fa-flag-usa me-2\"></i>English</a></li>
                                <li><a class=\"dropdown-item\" href=\"#\" onclick=\"changeLanguage('si')\"><i class=\"fas fa-flag me-2\"></i>සිංහල</a></li>
                            </ul>
                        </li>
                        <li class=\"nav-item dropdown\">
                            <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"joinDropdown\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                                Join
                            </a>
                            <ul class=\"dropdown-menu\" aria-labelledby=\"joinDropdown\">
                                <li><a class=\"dropdown-item\" href=\"#\" data-bs-toggle=\"modal\" data-bs-target=\"#loginModal\"><i class=\"fas fa-sign-in-alt me-2\"></i>Login</a></li>
                                <li><a class=\"dropdown-item\" href=\"#\" data-bs-toggle=\"modal\" data-bs-target=\"#registerModal\"><i class=\"fas fa-user-plus me-2\"></i>Register</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        ";
    }
    
    protected function renderCSS() {
        return "
        .main-header {
            background-color: var(--white);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            height: 50px;
        }
        
        .navbar-brand .logo-container {
            display: flex;
            align-items: center;
            height: 50px;
        }
        
        .navbar-brand .company-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-left: 15px;
            height: 50px;
        }
        
        .navbar-brand .company-name {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary-color);
            line-height: 1.2;
            margin: 0;
        }
        
        .navbar-brand .tagline {
            font-size: 12px;
            font-weight: 400;
            color: var(--text-color);
            line-height: 1.2;
            margin: 0;
            margin-top: 2px;
        }
        
        .navbar-nav .nav-link {
            color: var(--secondary-color) !important;
            font-weight: 600;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
        }
        
        .navbar-nav .nav-link.disabled {
            color: #ccc !important;
            cursor: not-allowed;
            opacity: 0.6;
        }
        
        .navbar-nav .nav-link.disabled:hover {
            color: #ccc !important;
        }
        
        .dropdown-toggle::after {
            margin-left: 8px;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        
        .dropdown-item {
            padding: 10px 20px;
            color: var(--text-color);
            transition: all 0.3s ease;
        }
        
        .dropdown-item:hover {
            background-color: var(--light-bg);
            color: var(--primary-color);
        }
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            .main-header {
                padding: 8px 0;
            }
            
            .navbar-brand {
                height: 40px;
                font-size: 16px;
            }
            
            .navbar-brand .logo-container {
                height: 40px;
            }
            
            .navbar-brand .company-info {
                margin-left: 8px;
                height: 40px;
            }
            
            .navbar-brand .company-name {
                font-size: 12px;
            }
            
            .navbar-brand .tagline {
                font-size: 9px;
            }
            
            .navbar-brand img {
                height: 35px !important;
            }
            
            .navbar-nav {
                text-align: center;
                margin-top: 15px;
            }
            
            .navbar-nav .nav-item {
                margin: 5px 0;
            }
            
            .navbar-nav .nav-link {
                padding: 8px 15px;
                font-size: 14px;
            }
        }
        
        @media (max-width: 576px) {
            .main-header {
                padding: 6px 0;
            }
            
            .navbar-brand {
                height: 35px;
                font-size: 14px;
            }
            
            .navbar-brand .logo-container {
                height: 35px;
            }
            
            .navbar-brand .company-info {
                margin-left: 6px;
                height: 35px;
            }
            
            .navbar-brand .company-name {
                font-size: 11px;
            }
            
            .navbar-brand .tagline {
                font-size: 8px;
            }
            
            .navbar-brand img {
                height: 30px !important;
            }
        }
        ";
    }
}
