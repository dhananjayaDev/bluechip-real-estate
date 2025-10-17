<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Bluechip Realty - Premium Properties in Sri Lanka' ?></title>
    <meta name="description" content="<?= $description ?? 'Find your dream property with Bluechip Realty. Premium apartments, houses, and commercial spaces in Colombo and beyond.' ?>">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" rel="stylesheet">
    <link href="/public/css/style.css" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/public/images/favicon.ico">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <i class="fas fa-building text-primary me-2"></i>
                    <span class="fw-bold"><?= SITE_NAME ?></span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Properties
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/?property_type=apartment">Apartments</a></li>
                                <li><a class="dropdown-item" href="/?property_type=house">Houses</a></li>
                                <li><a class="dropdown-item" href="/?property_type=villa">Villas</a></li>
                                <li><a class="dropdown-item" href="/?property_type=commercial">Commercial</a></li>
                                <li><a class="dropdown-item" href="/?property_type=land">Land</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Locations
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/?city=Colombo">Colombo</a></li>
                                <li><a class="dropdown-item" href="/?city=Kandy">Kandy</a></li>
                                <li><a class="dropdown-item" href="/?city=Galle">Galle</a></li>
                                <li><a class="dropdown-item" href="/?city=Negombo">Negombo</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact</a>
                        </li>
                    </ul>
                    
                    <div class="d-flex align-items-center">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <div class="dropdown me-3">
                                <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user me-1"></i>
                                    <?= htmlspecialchars($_SESSION['user_name']) ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/favorites"><i class="fas fa-heart me-2"></i>My Favorites</a></li>
                                    <li><a class="dropdown-item" href="/requests"><i class="fas fa-envelope me-2"></i>My Requests</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="/logout" class="d-inline">
                                            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?? '' ?>">
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="/login" class="btn btn-outline-primary me-2">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                            <a href="/register" class="btn btn-primary">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Breadcrumbs -->
        <?php if (isset($breadcrumbs) && !empty($breadcrumbs)): ?>
        <div class="breadcrumb-container bg-light py-2">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <?php foreach ($breadcrumbs as $index => $breadcrumb): ?>
                            <?php if ($index === count($breadcrumbs) - 1): ?>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?= htmlspecialchars($breadcrumb['name']) ?>
                                </li>
                            <?php else: ?>
                                <li class="breadcrumb-item">
                                    <a href="<?= htmlspecialchars($breadcrumb['url']) ?>">
                                        <?= htmlspecialchars($breadcrumb['name']) ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ol>
                </nav>
            </div>
        </div>
        <?php endif; ?>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="footer bg-dark text-light py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-building text-primary me-2"></i>
                        <?= SITE_NAME ?>
                    </h5>
                    <p class="text-muted">
                        Your trusted partner in finding premium properties across Sri Lanka. 
                        We specialize in luxury apartments, houses, and commercial spaces.
                    </p>
                    <div class="social-links">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="/" class="text-muted text-decoration-none">Home</a></li>
                        <li><a href="/?property_type=apartment" class="text-muted text-decoration-none">Apartments</a></li>
                        <li><a href="/?property_type=house" class="text-muted text-decoration-none">Houses</a></li>
                        <li><a href="/?property_type=commercial" class="text-muted text-decoration-none">Commercial</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Locations</h6>
                    <ul class="list-unstyled">
                        <li><a href="/?city=Colombo" class="text-muted text-decoration-none">Colombo</a></li>
                        <li><a href="/?city=Kandy" class="text-muted text-decoration-none">Kandy</a></li>
                        <li><a href="/?city=Galle" class="text-muted text-decoration-none">Galle</a></li>
                        <li><a href="/?city=Negombo" class="text-muted text-decoration-none">Negombo</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <h6 class="fw-bold mb-3">Contact Info</h6>
                    <div class="contact-info">
                        <p class="text-muted mb-2">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            123 Independence Avenue, Colombo 07
                        </p>
                        <p class="text-muted mb-2">
                            <i class="fas fa-phone text-primary me-2"></i>
                            +94 11 234 5678
                        </p>
                        <p class="text-muted mb-2">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            info@bluechiprealty.com
                        </p>
                        <p class="text-muted">
                            <i class="fas fa-clock text-primary me-2"></i>
                            Mon - Fri: 9:00 AM - 6:00 PM
                        </p>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted mb-0">
                        &copy; <?= date('Y') ?> <?= SITE_NAME ?>. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="/privacy" class="text-muted text-decoration-none me-3">Privacy Policy</a>
                    <a href="/terms" class="text-muted text-decoration-none">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="/public/js/main.js"></script>
    
    <?php if (isset($additionalScripts)): ?>
        <?= $additionalScripts ?>
    <?php endif; ?>
</body>
</html>
