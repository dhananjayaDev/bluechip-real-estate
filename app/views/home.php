<?php
// Get featured properties from database
$propertyModel = new Property();
$featuredProperties = $propertyModel->search(['featured' => 1], 1, 6);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Find your dream property with Bluechip Realty. Premium apartments, houses, and commercial spaces in Sri Lanka.">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home - Bluechip Realty</title>
    
    <!-- Favicon -->
    <link rel="icon" href="/public/images/favicon.ico">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.carousel.min.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Custom CSS -->
    <style>
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
        
        /* Header Styles */
        .top-header {
            background-color: var(--secondary-color);
            color: var(--white);
            padding: 10px 0;
            font-size: 14px;
        }
        
        .main-header {
            background-color: var(--white);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color) !important;
        }
        
        .navbar-nav .nav-link {
            color: var(--secondary-color) !important;
            font-weight: 600;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 8px 20px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: #1e40af;
            border-color: #1e40af;
        }
        
        /* Hero Section with Background Carousel */
        .hero-section {
            height: 70vh;
            position: relative;
            display: flex;
            align-items: center;
            color: var(--white);
            text-align: center;
            overflow: hidden;
        }
        
        .hero-background-carousel {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .hero-bg-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hero-bg-slide.active {
            opacity: 1;
        }
        
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4));
            z-index: 2;
        }
        
        .hero-section .container {
            position: relative;
            z-index: 3;
        }
        
        .hero-indicators {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 4;
            display: flex;
            gap: 10px;
        }
        
        .hero-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.5);
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .hero-indicator.active {
            background-color: var(--primary-color);
            transform: scale(1.2);
        }
        
        .hero-control-prev,
        .hero-control-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            background-color: rgba(0,0,0,0.3);
            border-radius: 50%;
            border: none;
            color: var(--white);
            font-size: 24px;
            cursor: pointer;
            z-index: 4;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .hero-control-prev {
            left: 30px;
        }
        
        .hero-control-next {
            right: 30px;
        }
        
        .hero-control-prev:hover,
        .hero-control-next:hover {
            background-color: rgba(0,0,0,0.5);
            transform: translateY(-50%) scale(1.1);
        }
        
        .hero-control-icon {
            font-weight: bold;
        }
        
        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            animation: slideInUp 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateY(30px);
            opacity: 0;
            animation-fill-mode: forwards;
        }
        
        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            animation: slideInUp 1.5s cubic-bezier(0.4, 0, 0.2, 1) 0.3s both;
            transform: translateY(30px);
            opacity: 0;
            animation-fill-mode: forwards;
        }
        
        .hero-btn {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: slideInUp 1.5s cubic-bezier(0.4, 0, 0.2, 1) 0.6s both;
            transform: translateY(30px);
            opacity: 0;
            animation-fill-mode: forwards;
        }
        
        .hero-btn:hover {
            background-color: #1e40af;
            color: var(--white);
            transform: translateY(-2px);
        }
        
        /* Search Section */
        .search-section {
            background-color: var(--light-bg);
            padding: 60px 0;
        }
        
        .search-form {
            background-color: var(--white);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .search-form h3 {
            color: var(--secondary-color);
            margin-bottom: 30px;
            text-align: center;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 5px;
            padding: 12px 15px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(148, 112, 84, 0.25);
        }
        
        /* Properties Section */
        .properties-section {
            padding: 80px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-title h2 {
            color: var(--secondary-color);
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .section-title p {
            font-size: 1.1rem;
            color: var(--text-color);
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
        }
        
        .property-card:hover {
            transform: translateY(-5px);
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
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1920&h=1080&fit=crop');
            background-size: cover;
            background-position: center;
            padding: 80px 0;
            text-align: center;
            color: var(--white);
        }
        
        .cta-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .cta-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        
        /* Footer */
        .footer {
            background-color: var(--secondary-color);
            color: var(--white);
            padding: 60px 0 30px;
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
            color: var(--primary-color);
        }
        
        .footer-bottom {
            border-top: 1px solid #555;
            padding-top: 20px;
            margin-top: 40px;
            text-align: center;
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
        
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .animate-on-scroll.animated {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .hero-content p {
                font-size: 1rem;
            }
            
            .search-form {
                padding: 20px;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <!-- Top Header -->
        <div class="top-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <span><i class="fas fa-envelope me-2"></i>admin@bluechiprealty.com</span>
                    </div>
                    <div class="col-md-6 text-end">
                        <span><i class="fas fa-phone me-2"></i>+94 11 234 5678</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Header -->
        <nav class="navbar navbar-expand-lg main-header">
            <div class="container">
                <a class="navbar-brand" href="/" style="color: #1e3a8a !important;">
                    <i class="fas fa-building me-2"></i>Bluechip Realty
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/">Properties</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact</a>
                        </li>
                    </ul>
                    
                    <div class="d-flex">
                        <a href="/login" class="btn btn-outline-primary me-2">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                        <a href="/register" class="btn btn-primary">
                            <i class="fas fa-user-plus me-1"></i>Register
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section with Background Image Carousel -->
    <section class="hero-section">
        <div class="hero-background-carousel">
            <div class="hero-bg-slide active" style="background-image: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1920&h=1080&fit=crop')"></div>
            <div class="hero-bg-slide" style="background-image: url('https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1920&h=1080&fit=crop')"></div>
            <div class="hero-bg-slide" style="background-image: url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1920&h=1080&fit=crop')"></div>
        </div>
        
        <div class="hero-overlay"></div>
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="hero-content">
                        <h1>Your Perfect Home</h1>
                        <p>From cozy apartments to spacious villas, find your ideal living space</p>
                        <a href="#search" class="hero-btn">Start Your Journey</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Background Carousel Indicators -->
        <div class="hero-indicators">
            <button class="hero-indicator active" data-slide="0" aria-label="Background 1"></button>
            <button class="hero-indicator" data-slide="1" aria-label="Background 2"></button>
            <button class="hero-indicator" data-slide="2" aria-label="Background 3"></button>
        </div>
        
        <!-- Background Carousel Controls -->
        <button class="hero-control-prev" type="button" aria-label="Previous Background">
            <span class="hero-control-icon">‹</span>
        </button>
        <button class="hero-control-next" type="button" aria-label="Next Background">
            <span class="hero-control-icon">›</span>
        </button>
    </section>

    <!-- Search Section -->
    <section class="search-section" id="search">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="search-form">
                        <h3>Search Properties</h3>
                        <form action="/" method="GET">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <input type="text" class="form-control" name="search" placeholder="Keyword">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <select class="form-control" name="city">
                                        <option value="">All Cities</option>
                                        <option value="Colombo">Colombo</option>
                                        <option value="Kandy">Kandy</option>
                                        <option value="Galle">Galle</option>
                                        <option value="Negombo">Negombo</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <select class="form-control" name="property_type">
                                        <option value="">All Types</option>
                                        <option value="apartment">Apartment</option>
                                        <option value="house">House</option>
                                        <option value="villa">Villa</option>
                                        <option value="commercial">Commercial</option>
                                        <option value="land">Land</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <select class="form-control" name="bedrooms">
                                        <option value="">Bedrooms</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5+</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <select class="form-control" name="bathrooms">
                                        <option value="">Bathrooms</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5+</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <input type="number" class="form-control" name="min_price" placeholder="Min Price">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <input type="number" class="form-control" name="max_price" placeholder="Max Price">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search me-1"></i>Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Properties Section -->
    <section class="properties-section">
        <div class="container">
            <div class="section-title animate-on-scroll">
                <h2>Featured Properties</h2>
                <p>Discover our premium selection of properties across Sri Lanka</p>
            </div>
            
            <div class="row">
                <?php if (!empty($featuredProperties)): ?>
                    <?php foreach ($featuredProperties as $property): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="property-card animate-on-scroll">
                                <div class="property-image" style="background-image: url('<?= !empty($property['images']) ? explode(',', $property['images'])[0] : 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=400&h=300&fit=crop' ?>')">
                                    <div class="property-price">Rs. <?= number_format($property['price']) ?></div>
                                </div>
                                <div class="property-content">
                                    <h5><a href="/property/<?= $property['id'] ?>"><?= htmlspecialchars($property['title']) ?></a></h5>
                                    <div class="property-location">
                                        <i class="fas fa-map-marker-alt me-1"></i><?= htmlspecialchars($property['location']) ?>
                                    </div>
                                    <p><?= htmlspecialchars(substr($property['description'], 0, 100)) ?>...</p>
                                    <div class="property-features">
                                        <div class="feature">
                                            <i class="fas fa-bed"></i>
                                            <span><?= $property['bedrooms'] ?></span>
                                        </div>
                                        <div class="feature">
                                            <i class="fas fa-bath"></i>
                                            <span><?= $property['bathrooms'] ?></span>
                                        </div>
                                        <div class="feature">
                                            <i class="fas fa-car"></i>
                                            <span><?= !empty($property['parking']) ? $property['parking'] : ($property['floors'] ?? 'N/A') ?></span>
                                        </div>
                                        <div class="feature">
                                            <i class="fas fa-ruler-combined"></i>
                                            <span><?= $property['area_sqft'] ?? 'N/A' ?> sq ft</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p>No featured properties available at the moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="cta-content animate-on-scroll">
                        <h2>Ready to Find Your Perfect Home?</h2>
                        <p>Let our expert team help you discover the property of your dreams</p>
                        <a href="#search" class="hero-btn">Start Your Search</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5>About Bluechip Realty</h5>
                    <p>Your trusted partner in finding premium properties across Sri Lanka. We specialize in luxury apartments, houses, and commercial spaces.</p>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="/">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="/">Properties</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Contact Info</h5>
                    <p><i class="fas fa-phone me-2"></i>+94 11 234 5678</p>
                    <p><i class="fas fa-envelope me-2"></i>admin@bluechiprealty.com</p>
                    <p><i class="fas fa-map-marker-alt me-2"></i>123 Independence Avenue, Colombo 07</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Follow Us</h5>
                    <div class="social-links">
                        <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Bluechip Realty. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Animate elements on scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.animate-on-scroll');
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < window.innerHeight - elementVisible) {
                    element.classList.add('animated');
                }
            });
        }
        
        window.addEventListener('scroll', animateOnScroll);
        animateOnScroll(); // Run on page load
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const searchInput = this.querySelector('input[name="search"]');
            const citySelect = this.querySelector('select[name="city"]');
            const typeSelect = this.querySelector('select[name="property_type"]');
            
            if (!searchInput.value && !citySelect.value && !typeSelect.value) {
                e.preventDefault();
                alert('Please enter at least one search criteria.');
            }
        });
        
        // Background Image Carousel with Static Text
        document.addEventListener('DOMContentLoaded', function() {
            const heroSection = document.querySelector('.hero-section');
            const bgSlides = document.querySelectorAll('.hero-bg-slide');
            const indicators = document.querySelectorAll('.hero-indicator');
            const prevBtn = document.querySelector('.hero-control-prev');
            const nextBtn = document.querySelector('.hero-control-next');
            
            let currentSlide = 0;
            const totalSlides = bgSlides.length;
            let autoPlayInterval;
            
            // Function to show specific slide
            function showSlide(index) {
                // Remove active class from all slides and indicators
                bgSlides.forEach(slide => slide.classList.remove('active'));
                indicators.forEach(indicator => indicator.classList.remove('active'));
                
                // Add active class to current slide and indicator
                bgSlides[index].classList.add('active');
                indicators[index].classList.add('active');
                
                currentSlide = index;
            }
            
            // Function to go to next slide
            function nextSlide() {
                const nextIndex = (currentSlide + 1) % totalSlides;
                showSlide(nextIndex);
            }
            
            // Function to go to previous slide
            function prevSlide() {
                const prevIndex = (currentSlide - 1 + totalSlides) % totalSlides;
                showSlide(prevIndex);
            }
            
            // Function to start auto-play
            function startAutoPlay() {
                autoPlayInterval = setInterval(nextSlide, 5000); // 5 seconds
            }
            
            // Function to stop auto-play
            function stopAutoPlay() {
                clearInterval(autoPlayInterval);
            }
            
            // Event listeners for indicators
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    showSlide(index);
                    stopAutoPlay();
                    startAutoPlay(); // Restart auto-play
                });
            });
            
            // Event listeners for control buttons
            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    prevSlide();
                    stopAutoPlay();
                    startAutoPlay(); // Restart auto-play
                });
            }
            
            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    nextSlide();
                    stopAutoPlay();
                    startAutoPlay(); // Restart auto-play
                });
            }
            
            // Pause auto-play on hover
            if (heroSection) {
                heroSection.addEventListener('mouseenter', stopAutoPlay);
                heroSection.addEventListener('mouseleave', startAutoPlay);
            }
            
            // Start auto-play
            startAutoPlay();
        });
    </script>
</body>
</html>
</html>