<?php

require_once 'Component.php';

class Footer extends Component {
    
    public function render() {
        $activePage = $this->getData('activePage', '');
        $adminPages = ['dashboard', 'admin-properties', 'users', 'requests', 'admin-property-detail'];
        
        // Show simplified footer for admin pages
        if (in_array($activePage, $adminPages)) {
            return "
            <footer class=\"footer admin-footer\">
                <div class=\"container\">
                    <div class=\"footer-bottom\">
                        <p>&copy; 2025 Bluechip Real Estate. All rights reserved.</p>
                    </div>
                </div>
            </footer>
            ";
        }
        
        // Full footer for regular pages
        $aboutText = $this->getData('aboutText', 'Bluechip Real Estate (PVT) Limited has been established with the vision To deliver the highest value in real estate industry through innovation and integrity.');
        $phone = $this->getData('phone', '(+94) 71 609 2918');
        $email = $this->getData('email', 'hello@bluechiplands.asia');
        $address = $this->getData('address', 'World Trade Center, West Tower,<br>Level 37, Colombo 01, Sri Lanka');
        $facebookUrl = $this->getData('facebookUrl', 'https://www.facebook.com/p/Bluechip-Real-Estate-100091440704853/');
        $whatsappUrl = $this->getData('whatsappUrl', 'https://wa.me/94716092918');
        $disabledNavItems = $this->getData('disabledNavItems', []);
        
        return "
        <footer class=\"footer\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-lg-4 col-md-6 mb-4\">
                        <h5>About Bluechip Real Estate</h5>
                        <p>{$aboutText}</p>
                    </div>
                    <div class=\"col-lg-2 col-md-6 mb-4\">
                        <h5>Quick Links</h5>
                        <ul class=\"list-unstyled\">
                            <li><a href=\"/#top\">Home</a></li>
                            <li>" . $this->renderFooterLink('about', '/#about', 'About', $disabledNavItems) . "</li>
                            <li><a href=\"/properties\">Properties</a></li>
                            <li>" . $this->renderFooterLink('contact', '/#contact', 'Contact', $disabledNavItems) . "</li>
                        </ul>
                    </div>
                    <div class=\"col-lg-3 col-md-6 mb-4\">
                        <h5>Contact Info</h5>
                        <p><i class=\"fas fa-phone me-2\"></i>{$phone}</p>
                        <p><i class=\"fas fa-envelope me-2\"></i>{$email}</p>
                        <p><i class=\"fas fa-map-marker-alt me-2\"></i><span>{$address}</span></p>
                    </div>
                    <div class=\"col-lg-3 col-md-6 mb-4\">
                        <h5>Follow Us</h5>
                        <div class=\"social-links\">
                            <a href=\"{$facebookUrl}\" class=\"me-3\"><i class=\"fab fa-facebook-f\"></i></a>
                            <a href=\"#\" class=\"me-3\"><i class=\"fab fa-twitter\"></i></a>
                            <a href=\"#\" class=\"me-3\"><i class=\"fab fa-linkedin-in\"></i></a>
                            <a href=\"{$whatsappUrl}\" class=\"me-3\"><i class=\"fab fa-whatsapp\"></i></a>
                        </div>
                    </div>
                </div>
                <div class=\"footer-bottom\">
                    <p>&copy; 2025 Bluechip Real Estate. All rights reserved.</p>
                </div>
            </div>
        </footer>
        ";
    }
    
    private function renderFooterLink($key, $href, $text, $disabledNavItems) {
        if (in_array($key, $disabledNavItems)) {
            return "<a href=\"#\" class=\"disabled\" onclick=\"return false;\">{$text}</a>";
        } else {
            return "<a href=\"{$href}\">{$text}</a>";
        }
    }
    
    protected function renderCSS() {
        return "
        .footer {
            background: var(--primary-color);
            color: var(--white);
            padding: 60px 0 30px;
        }
        
        .admin-footer {
            padding: 20px 0;
            background: #f8f9fa;
            color: #666;
        }
        
        .admin-footer .footer-bottom {
            text-align: center;
            margin: 0;
        }
        
        .admin-footer p {
            margin: 0;
            font-size: 0.9rem;
        }
        
        .footer h5 {
            color: var(--white);
            margin-bottom: 20px;
        }
        
        .footer a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer a:hover {
            color: #ffd700;
        }
        
        .footer .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .footer .social-links a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-2px);
        }
        
        .footer-bottom {
            border-top: 1px solid #555;
            padding-top: 20px;
            margin-top: 40px;
            text-align: center;
        }
        
        .footer-bottom p {
            text-align: center !important;
            margin: 0;
        }
        
        .footer a.disabled {
            color: #999 !important;
            cursor: not-allowed;
            opacity: 0.6;
            text-decoration: none;
        }
        
        .footer a.disabled:hover {
            color: #999 !important;
            text-decoration: none;
        }
        ";
    }
}
