<?php

require_once 'Component.php';
require_once 'Header.php';
require_once 'Navbar.php';
require_once 'Footer.php';
require_once 'Modal.php';
require_once 'SearchSection.php';

class BaseLayout extends Component {
    
    public function render() {
        $pageTitle = $this->getData('pageTitle', 'Bluechip Real Estate');
        $pageDescription = $this->getData('pageDescription', 'Find your dream property with Bluechip Realty. Premium apartments, houses, and commercial spaces in Sri Lanka.');
        $activePage = $this->getData('activePage', '');
        $content = $this->getData('content', '');
        $csrfToken = $this->getData('csrfToken', '');
        $includeModals = $this->getData('includeModals', true);
        
        // Initialize components
        $header = new Header($this->data);
        $navbar = new Navbar(['activePage' => $activePage] + $this->data);
        
        // Only include search section for properties management page and non-admin pages
        $searchSection = null;
        $searchAssets = ['html' => '', 'css' => '', 'js' => ''];
        if ($activePage === 'properties' || (!in_array($activePage, ['dashboard', 'admin-properties', 'users', 'requests', 'admin-property-detail', 'property-detail']) && !str_contains($activePage, 'property'))) {
            $searchData = $this->data;
            if ($activePage === 'properties') {
                $searchData['targetUrl'] = '/properties';
                $searchData['enableAjax'] = true; // Enable AJAX search for properties page
            } else {
                $searchData['targetUrl'] = '/properties'; // Home page search now goes to /properties
            }
            $searchSection = new SearchSection($searchData);
            $searchAssets = $searchSection->renderWithAssets();
        }
        
        $footer = new Footer(['activePage' => $activePage] + $this->data);
        $modal = $includeModals ? new Modal(['csrfToken' => $csrfToken]) : null;
        
        // Get component assets
        $headerAssets = $header->renderWithAssets();
        $navbarAssets = $navbar->renderWithAssets();
        $footerAssets = $footer->renderWithAssets();
        $modalAssets = $modal ? $modal->renderWithAssets() : ['html' => '', 'css' => '', 'js' => ''];
        
        // Combine all CSS
        $allCSS = $this->renderBaseCSS() . 
                 $headerAssets['css'] . 
                 $navbarAssets['css'] . 
                 $searchAssets['css'] . 
                 $footerAssets['css'] . 
                 $modalAssets['css'];
        
        // Combine all JS
        $allJS = $this->renderBaseJS() . 
                $headerAssets['js'] . 
                $navbarAssets['js'] . 
                $searchAssets['js'] . 
                $footerAssets['js'] . 
                $modalAssets['js'];
        
        return "
        <!DOCTYPE html>
        <html lang=\"en\">
        <head>
            <meta charset=\"UTF-8\">
            <meta name=\"description\" content=\"{$pageDescription}\">
            <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
            <title>{$pageTitle}</title>
            
            <!-- Favicon -->
            <link rel=\"icon\" href=\"/public/images/favicon.ico\">
            
            <!-- Bootstrap CSS -->
            <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css\" rel=\"stylesheet\">
            <!-- Font Awesome -->
            <link href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css\" rel=\"stylesheet\">
            <!-- Google Fonts -->
            <link href=\"https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap\" rel=\"stylesheet\">
            <!-- Sinhala Fonts -->
            <link href=\"https://fonts.googleapis.com/css2?family=Noto+Sans+Sinhala:wght@300;400;500;600;700&display=swap\" rel=\"stylesheet\">
            <!-- Owl Carousel -->
            <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.carousel.min.css\">
            <!-- Animate CSS -->
            <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css\">
            
            <!-- Custom CSS -->
            <style>
                {$allCSS}
            </style>
        </head>
        <body>
            <!-- Header -->
            <header>
                {$headerAssets['html']}
                {$navbarAssets['html']}
            </header>

            <!-- Search Section -->
            {$searchAssets['html']}

            <!-- Main Content -->
            <main>
                {$content}
            </main>

            <!-- Footer -->
            {$footerAssets['html']}

            <!-- Modals -->
            {$modalAssets['html']}

            <!-- Scripts -->
            <script src=\"https://code.jquery.com/jquery-3.6.0.min.js\"></script>
            <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js\"></script>
            <script src=\"https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js\"></script>
            
            <script>
                {$allJS}
            </script>
        </body>
        </html>
        ";
    }
    
    protected function renderBaseCSS() {
        return "
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #323232;
            --text-color: #7d7d7d;
            --white: #ffffff;
            --light-bg: #f8f9fa;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
        }
        
        .sinhala-text {
            font-family: 'Noto Sans Sinhala', sans-serif;
            font-weight: 400;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .animate-slideInUp {
            animation: slideInUp 0.8s ease-out;
        }
        ";
    }
    
    protected function renderBaseJS() {
        return "
        // Language Change Functionality
        function changeLanguage(lang) {
            const currentLanguageSpan = document.getElementById(\"currentLanguage\");
            const currentLang = lang === \"en\" ? \"EN\" : \"සිංහල\";
            
            // Update the dropdown button text
            if (currentLanguageSpan) {
                currentLanguageSpan.textContent = currentLang;
            }
            
            // Store language preference
            localStorage.setItem(\"preferredLanguage\", lang);
            
            // You can add translation logic here
            console.log(\"Language changed to:\", lang);
        }

        // Load saved language preference
        document.addEventListener(\"DOMContentLoaded\", function() {
            const savedLang = localStorage.getItem(\"preferredLanguage\");
            if (savedLang) {
                changeLanguage(savedLang);
            }
        });
        ";
    }
}
