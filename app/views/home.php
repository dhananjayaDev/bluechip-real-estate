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
    <!-- Sinhala Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Sinhala:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        
        html {
            scroll-behavior: smooth;
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
        
        /* Responsive Header Styles */
        @media (max-width: 768px) {
            .top-header {
                padding: 6px 0;
                font-size: 12px;
            }
            
            .top-header .col-md-6:first-child {
                text-align: center;
                margin-bottom: 4px;
            }
            
            .top-header .col-md-6:last-child {
                text-align: center;
            }
            
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
            
            .dropdown-menu {
                text-align: left;
                border: none;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
        }
        
        @media (max-width: 576px) {
            .top-header {
                padding: 4px 0;
                font-size: 11px;
            }
            
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
            
            .navbar-toggler {
                padding: 4px 8px;
                font-size: 14px;
            }
        }
        
        .btn-outline-primary:hover {
            background-color: #1e3a8a !important;
            border-color: #1e3a8a !important;
            color: white !important;
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
            background-color: #1e3a8a;
            color: white;
        }
        
        .dropdown-item i {
            color: #1e3a8a;
        }
        
        .dropdown-item:hover i {
            color: white;
        }
        
        .language-dropdown .dropdown-toggle {
            color: var(--secondary-color) !important;
            font-weight: 600;
            margin: 0 10px;
        }
        
        .language-dropdown .dropdown-toggle:hover {
            color: var(--primary-color) !important;
        }
        
        .language-dropdown .dropdown-toggle::after {
            margin-left: 5px;
        }
        
        .nav-item.dropdown .nav-link {
            color: #1e3a8a !important;
            font-weight: 700;
        }
        
        .top-header {
            background-color: #1e3a8a;
        }
        
        .top-header span {
            color: white;
            font-weight: 600;
        }
        
        .top-header i {
            color: white;
        }
        
        .footer .contact-info {
            background-color: #1e3a8a;
            padding: 20px;
            border-radius: 10px;
        }
        
        .footer .contact-info p {
            color: white;
        }
        
        .footer .contact-info i {
            color: white;
        }
        
        .footer .contact-info p {
            display: flex;
            align-items: flex-start;
        }
        
        .footer .contact-info p span {
            flex: 1;
        }
        
        /* About Section */
        .about-section {
            position: relative;
            min-height: 30vh;
            padding: 40px 0;
            background-image: url('https://images.pexels.com/photos/18599747/pexels-photo-18599747.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
        }
        
        .about-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(30, 58, 138, 0.85);
            z-index: 1;
        }
        
        .about-section .container {
            position: relative;
            z-index: 2;
        }
        
        .about-content {
            background: transparent;
            padding: 0;
        }

        .about-text h2 {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 25px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .about-text p {
            color: white;
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 20px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .about-text .highlight {
            color: #ffd700;
            font-weight: 600;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
        }

        .ceo-signature {
            color: #ffd700 !important;
            font-size: 1.2rem !important;
            font-weight: 600 !important;
            font-style: italic !important;
            margin-top: 25px !important;
            margin-bottom: 0 !important;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7) !important;
        }
        
        .ceo-photo {
            text-align: center;
        }
        
        .ceo-image {
            width: 100%;
            max-width: 400px;
            height: 500px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 3px solid rgba(255, 255, 255, 0.2);
        }

        /* Partners Section */
        .partners-section {
            background: white;
            padding: 60px 0;
            overflow: hidden;
        }
         
         .partners-section .section-title {
             color: var(--secondary-color);
             font-size: 2.5rem;
             font-weight: 700;
             margin-bottom: 15px;
         }
         
         .partners-section .section-subtitle {
             color: var(--text-color);
             font-size: 1.1rem;
             margin-bottom: 0;
         }
         
        .partners-container {
            position: relative;
            width: 100%;
            overflow: hidden;
            background: white;
            padding: 30px 0;
        }
         
         .partners-container::before,
         .partners-container::after {
             content: '';
             position: absolute;
             top: 0;
             bottom: 0;
             width: 100px;
             z-index: 2;
             pointer-events: none;
         }
         
         .partners-container::before {
             left: 0;
             background: linear-gradient(to right, white, transparent);
         }
         
         .partners-container::after {
             right: 0;
             background: linear-gradient(to left, white, transparent);
         }
         
         .partners-reel {
             display: flex;
             animation: scroll-right 20s linear infinite;
             width: max-content;
             align-items: center;
             gap: 40px;
         }
         
         .partners-reel:hover {
             animation-play-state: paused;
         }
         
         .partner-item {
             flex-shrink: 0;
             display: flex;
             align-items: center;
             justify-content: center;
             height: 80px;
             min-width: 200px;
         }
         
         .partner-logo {
             max-height: 60px;
             max-width: 180px;
             width: auto;
             height: auto;
             object-fit: contain;
             filter: grayscale(100%);
             opacity: 0.7;
             transition: all 0.3s ease;
             display: block;
         }
         
         .partner-logo:hover {
             filter: grayscale(0%);
             opacity: 1;
             transform: scale(1.05);
         }
         
         @keyframes scroll-right {
             0% {
                 transform: translateX(0);
             }
             100% {
                 transform: translateX(-50%);
             }
         }
         
         /* Responsive Design for Partners */
         @media (max-width: 768px) {
             .partners-section {
                 padding: 40px 0;
             }
             
             .partners-section .section-title {
                 font-size: 2rem;
             }
             
             .partners-container::before,
             .partners-container::after {
                 width: 60px;
             }
             
             .partners-reel {
                 gap: 30px;
                 animation-duration: 25s;
             }
             
             .partner-item {
                 min-width: 150px;
             }
             
             .partner-logo {
                 max-height: 50px;
                 max-width: 140px;
             }
         }
         
         @media (max-width: 480px) {
             .partners-container::before,
             .partners-container::after {
                 width: 40px;
             }
             
             .partners-reel {
                 gap: 20px;
                 animation-duration: 20s;
             }
             
             .partner-item {
                 min-width: 120px;
             }
             
             .partner-logo {
                 max-height: 40px;
                 max-width: 120px;
             }
         }

         /* Contact Section */
         .contact-section {
             position: relative;
             min-height: 30vh;
             padding: 40px 0;
             background: #f8f9fa;
         }

        .contact-section .container {
            position: relative;
            z-index: 2;
        }

        /* Contact Brand (Left Side) */
        .contact-brand {
            padding-right: 30px;
        }

        .contact-logo-container {
            margin-bottom: 20px;
        }

        .contact-logo {
            height: 120px;
            width: auto;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .contact-brand-info {
            margin-left: 0;
        }

        .contact-brand-name {
            color: var(--primary-color);
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .contact-tagline {
            color: var(--primary-color);
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 15px;
            font-style: italic;
        }

        .contact-description {
            color: var(--text-color);
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        /* Contact Info Details */
        .contact-info-details {
            margin-top: 20px;
        }
        
        .contact-info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            color: var(--text-color);
        }
        
        .contact-info-item i {
            color: var(--primary-color);
            margin-right: 12px;
            margin-top: 2px;
            font-size: 16px;
            width: 20px;
            flex-shrink: 0;
        }
        
        .contact-info-item span {
            font-size: 14px;
            line-height: 1.5;
        }
        
        /* Social Media in Contact Section */
        .contact-info-item.social-handles {
            align-items: center;
            margin-top: 20px;
        }
        
        .contact-info-item.social-handles i.fas.fa-share-alt {
            color: var(--primary-color);
            margin-right: 12px;
            margin-top: 2px;
            font-size: 16px;
            width: 20px;
            flex-shrink: 0;
        }
        
        .social-links-contact {
            display: flex !important;
            gap: 12px;
            margin-left: 8px;
            flex-wrap: wrap;
        }
        
        .social-link {
            display: flex !important;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background-color: var(--primary-color) !important;
            color: white !important;
            border-radius: 50%;
            text-decoration: none !important;
            transition: all 0.3s ease;
            font-size: 14px;
            border: none;
            outline: none;
        }
        
        .social-link:hover {
            background-color: #1e40af !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(30, 58, 138, 0.3);
            color: white !important;
        }
        
        .social-link i {
            margin: 0 !important;
            font-size: 16px;
            color: white !important;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Contact Content (Right Side) */
        .contact-content {
            background: #f8f9fa;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid #e9ecef;
        }

        .contact-content h3 {
            color: var(--primary-color);
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .contact-content p {
            color: var(--text-color);
            margin-bottom: 25px;
            font-size: 1rem;
        }

        .contact-form .form-group {
            margin-bottom: 20px;
        }

        .contact-form label {
            color: var(--text-color);
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            font-size: 0.95rem;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        .contact-form textarea {
            height: 100px;
            resize: vertical;
        }

        .contact-form .btn-submit {
            background: var(--primary-color);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .contact-form .btn-submit:hover {
            background: #1e40af;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 58, 138, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .contact-section {
                padding: 40px 0;
            }
            
            .contact-brand {
                padding-right: 0;
                margin-bottom: 30px;
                text-align: center;
            }
            
            .contact-logo {
                height: 80px;
            }
            
            .contact-brand-name {
                font-size: 1.5rem;
            }
            
            .contact-content {
                padding: 30px 20px;
            }
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
        
        /* Testimonials Section */
        .testimonials-section {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 80px 0;
        }
        
        .testimonials-section .section-title {
            color: var(--secondary-color);
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .testimonials-section .section-subtitle {
            color: var(--text-color);
            font-size: 1.1rem;
            margin-bottom: 0;
        }
        
        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .testimonial-content {
            flex: 1;
            margin-bottom: 25px;
        }
        
        .stars {
            color: #ffd700;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        
        .stars i {
            margin-right: 2px;
        }
        
        .testimonial-text {
            color: var(--text-color);
            font-size: 1rem;
            line-height: 1.6;
            font-style: italic;
            margin: 0;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
            margin-top: auto;
        }
        
        .author-avatar {
            margin-right: 15px;
        }
        
        .avatar-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
        }
        
        .author-name {
            color: var(--secondary-color);
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0 0 5px 0;
        }
        
        .author-title {
            color: var(--text-color);
            font-size: 0.9rem;
            margin: 0;
        }
        
        /* Responsive Design for Testimonials */
        @media (max-width: 768px) {
            .testimonials-section {
                padding: 60px 0;
            }
            
            .testimonials-section .section-title {
                font-size: 2rem;
            }
            
            .testimonial-card {
                padding: 25px;
            }
        }
        
        @media (max-width: 576px) {
            .testimonials-section {
                padding: 40px 0;
            }
            
            .testimonials-section .section-title {
                font-size: 1.8rem;
            }
            
            .testimonial-card {
                padding: 20px;
            }
            
            .testimonial-text {
                font-size: 0.95rem;
            }
        }

        /* Modal Styles */
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .login-modal-content,
        .register-modal-content {
            max-width: 450px;
        }

        .login-modal-header,
        .register-modal-header {
            background: white;
            border: none;
            padding: 30px 30px 20px 30px;
            position: relative;
        }

        .login-header-content,
        .register-header-content {
            text-align: center;
        }

        .login-modal-header .modal-title,
        .register-modal-header .modal-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            color: #1f2937;
        }

        .btn-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #f3f4f6;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            opacity: 1;
            border: none;
        }

        .btn-close:hover {
            background: #e5e7eb;
        }

        .btn-close::before {
            content: '×';
            color: #6b7280;
            font-size: 18px;
            font-weight: bold;
        }

        .modal-body {
            padding: 0 30px 30px 30px;
            background: white;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: none;
        }

        .form-control {
            border: 1px solid #d1d5db;
            padding: 14px 16px;
            font-size: 1rem;
            border-radius: 8px;
            background: white;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #1e3a8a;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            z-index: 10;
            padding: 4px;
        }

        .password-toggle:hover {
            color: #374151;
        }

        .password-field {
            position: relative;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: #1e3a8a;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password a:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        .login-btn,
        .register-btn {
            background: #1e3a8a;
            border: none;
            padding: 14px 20px;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 8px;
            width: 100%;
            color: white;
            transition: all 0.2s ease;
        }

        .login-btn:hover,
        .register-btn:hover {
            background: #1e40af;
            color: white;
        }

        .register-link,
        .login-link {
            color: #1e3a8a;
            text-decoration: none;
            font-weight: 500;
        }

        .register-link:hover,
        .login-link:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            padding: 0 15px;
        }

        .social-login {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            background: white;
        }

        .social-btn:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }

        .social-btn.facebook {
            background: #1877f2;
            color: white;
            border-color: #1877f2;
        }

        .social-btn.facebook:hover {
            background: #166fe5;
            color: white;
        }

        .social-btn.google {
            color: #374151;
        }

        .social-btn i {
            margin-right: 12px;
            font-size: 1.1rem;
        }

        /* Modal backdrop */
        .modal-backdrop {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        /* Responsive Design for Modals */
        @media (max-width: 576px) {
            .login-modal-content,
            .register-modal-content {
                margin: 20px;
                max-width: none;
            }
            
            .login-modal-header,
            .register-modal-header {
                padding: 25px 20px 15px 20px;
            }
            
            .modal-body {
                padding: 0 20px 25px 20px;
            }
        }

        /* Footer */
        .footer {
            background: var(--primary-color);
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
                    <div class="col-md-6 col-12">
                        <span><i class="fas fa-envelope me-2"></i>hello@bluechiplands.asia</span>
                    </div>
                    <div class="col-md-6 col-12 text-md-end text-center">
                        <span><i class="fas fa-phone me-2"></i>(+94) 71 609 2918</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Header -->
        <nav class="navbar navbar-expand-lg main-header">
            <div class="container">
                <a class="navbar-brand" href="/" style="color: #1e3a8a !important;">
                    <div class="logo-container">
                        <img src="/public/images/uploads/logo.jpeg" alt="Bluechip Real Estate Logo" style="height: 50px;">
                        <div class="company-info">
                            <div class="company-name">Bluechip Real Estate (Pvt) Limited</div>
                            <div class="tagline sinhala-text">අපේ රටේ ඉඩමක් ගන්න හොඳම තැන</div>
                        </div>
                    </div>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/properties">Properties</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#contact">Contact</a>
                        </li>
                        <li class="nav-item dropdown language-dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-globe me-1"></i><span id="currentLanguage">EN</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                                <li><a class="dropdown-item" href="#" onclick="changeLanguage('en')"><i class="fas fa-flag-usa me-2"></i>English</a></li>
                                <li><a class="dropdown-item" href="#" onclick="changeLanguage('si')"><i class="fas fa-flag me-2"></i>සිංහල</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="joinDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Join
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="joinDropdown">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fas fa-sign-in-alt me-2"></i>Login</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#registerModal"><i class="fas fa-user-plus me-2"></i>Register</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section with Background Image Carousel -->
    <section id="top" class="hero-section">
        <div class="hero-background-carousel">
            <div class="hero-bg-slide active" style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1920&h=1080&fit=crop')"></div>
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
    <section id="properties" class="properties-section">
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
                                <?php
                                // Unique images for each property - using property ID for variety
                                $allImages = [
                                    'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=400&h=300&fit=crop',
                                    'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=400&h=300&fit=crop',
                                    'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=400&h=300&fit=crop',
                                    'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=400&h=300&fit=crop',
                                    'https://images.unsplash.com/photo-1497366216548-37526070297c?w=400&h=300&fit=crop',
                                    'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=400&h=300&fit=crop',
                                    'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=400&h=300&fit=crop',
                                    'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=400&h=300&fit=crop'
                                ];
                                
                                // Use property ID to select a unique image
                                $imageIndex = ($property['id'] - 1) % count($allImages);
                                $defaultImage = $allImages[$imageIndex];
                                $imageUrl = !empty($property['images']) ? explode(',', $property['images'])[0] : $defaultImage;
                                ?>
                                <div class="property-image" style="background-image: url('<?= $imageUrl ?>')">
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
                                            <span><?= !empty($property['parking']) ? explode(',', $property['parking'])[0] : 'N/A' ?></span>
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

    <!-- About Section -->
    <section class="about-section" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-content">
                        <div class="about-text">
                            <h2>Bluechip Real Estate</h2>
                            <p><span class="highlight">Bluechip Real Estate (Pvt) Limited</span> is recognized as Sri Lanka's premier real estate company, established with the vision of making property ownership accessible and rewarding for everyone.</p>
                            
                            <p>Over a decade of experience in the Sri Lankan real estate market has built a reputation for <span class="highlight">excellence, integrity, and customer satisfaction</span>. The company is committed to maintaining the highest standards of professionalism while ensuring every client's property goals are achieved.</p>
                            
                            <p class="ceo-signature">CEO - Uditha Bandara</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ceo-photo">
                        <img src="/public/images/uploads/CEO.png" alt="CEO of Bluechip Real Estate" class="ceo-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

     <!-- Partners Section -->
     <section class="partners-section">
         <div class="container">
             <div class="row">
                 <div class="col-12 text-center mb-5">
                     <h2 class="section-title">Our Trusted Partners</h2>
                     <p class="section-subtitle">Working with Sri Lanka's leading institutions to serve you better</p>
                 </div>
             </div>
             
             <div class="partners-container">
                 <div class="partners-reel">
                    <!-- Banks -->
                      <div class="partner-item">
                         <img src="/public/images/uploads/Commercial_Bank_logo.svg" alt="Commercial Bank of Ceylon" class="partner-logo">
                      </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/Peoplesbanklk.png" alt="People's Bank" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/sampath.png" alt="Sampath Bank" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/DFCC_Bank_logo.svg" alt="DFCC Bank" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/NDB-Logo-study-2026.jpg" alt="National Development Bank" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/HNB_New_Logo.png" alt="Hatton National Bank" class="partner-logo">
                    </div>
                    
                    <!-- Insurance Companies -->
                    <div class="partner-item">
                        <img src="/public/images/uploads/Ceylinco_Insurance_logo.png" alt="Ceylinco Insurance" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/Allianz.svg" alt="Allianz Insurance" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/Union_Assurance_logo.png" alt="Union Assurance" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/Janashakthi_Insurance_logo.png" alt="Janashakthi Insurance" class="partner-logo">
                    </div>
                    
                    <!-- Legal Partners -->
                    <div class="partner-item">
                        <img src="/public/images/uploads/Lanka_legal_logo.png" alt="Legal Partners" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/law-firm-associates.jpg" alt="Law Firm Associates" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/prime-group-logo.png" alt="Property Legal Services" class="partner-logo">
                    </div>
                    
                    <!-- Construction Companies -->
                    <div class="partner-item">
                        <img src="/public/images/uploads/Access_Engineering_logo.jpg" alt="Access Engineering" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/magil_logo.png" alt="Magil" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/kedellla_logo.png" alt="Kedella" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/araliya_logo.png" alt="Araliya" class="partner-logo">
                    </div>
                     
                    <!-- Duplicate for seamless loop -->
                    <div class="partner-item">
                        <img src="/public/images/uploads/Commercial_Bank_logo.svg" alt="Commercial Bank of Ceylon" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/Peoplesbanklk.png" alt="People's Bank" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/sampath.png" alt="Sampath Bank" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/DFCC_Bank_logo.svg" alt="DFCC Bank" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/NDB-Logo-study-2026.jpg" alt="National Development Bank" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/HNB_New_Logo.png" alt="Hatton National Bank" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/Ceylinco_Insurance_logo.png" alt="Ceylinco Insurance" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/Allianz.svg" alt="Allianz Insurance" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/Union_Assurance_logo.png" alt="Union Assurance" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/Janashakthi_Insurance_logo.png" alt="Janashakthi Insurance" class="partner-logo">
                    </div>
                    
                    <!-- Legal Partners -->
                    <div class="partner-item">
                        <img src="/public/images/uploads/Lanka_legal_logo.png" alt="Legal Partners" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/law-firm-associates.jpg" alt="Law Firm Associates" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/prime-group-logo.png" alt="Property Legal Services" class="partner-logo">
                    </div>
                    
                    <!-- Construction Companies -->
                    <div class="partner-item">
                        <img src="/public/images/uploads/Access_Engineering_logo.jpg" alt="Access Engineering" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/magil_logo.png" alt="Magil" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/kedellla_logo.png" alt="Kedella" class="partner-logo">
                    </div>
                    <div class="partner-item">
                        <img src="/public/images/uploads/araliya_logo.png" alt="Araliya" class="partner-logo">
                    </div>
                 </div>
             </div>
         </div>
     </section>

     <!-- Testimonials Section -->
     <section class="testimonials-section">
         <div class="container">
             <div class="row">
                 <div class="col-12 text-center mb-5">
                     <h2 class="section-title">What Our Clients Say</h2>
                     <p class="section-subtitle">Hear from satisfied customers who found their dream homes with us</p>
                 </div>
             </div>
             
             <div class="row">
                 <div class="col-lg-4 col-md-6 mb-4">
                     <div class="testimonial-card">
                         <div class="testimonial-content">
                             <div class="stars">
                                 <i class="fas fa-star"></i>
                                 <i class="fas fa-star"></i>
                                 <i class="fas fa-star"></i>
                                 <i class="fas fa-star"></i>
                                 <i class="fas fa-star"></i>
                             </div>
                             <p class="testimonial-text">"Bluechip Real Estate made our property search effortless. Their team's expertise and dedication helped us find the perfect home in Colombo. Highly recommended!"</p>
                         </div>
                         <div class="testimonial-author">
                             <div class="author-avatar">
                                 <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face" alt="Client" class="avatar-img">
                             </div>
                             <div class="author-info">
                                 <h5 class="author-name">Rajesh Perera</h5>
                                 <p class="author-title">Business Owner</p>
                             </div>
                         </div>
                     </div>
                 </div>
                 
                 <div class="col-lg-4 col-md-6 mb-4">
                     <div class="testimonial-card">
                         <div class="testimonial-content">
                             <div class="stars">
                                 <i class="fas fa-star"></i>
                                 <i class="fas fa-star"></i>
                                 <i class="fas fa-star"></i>
                                 <i class="fas fa-star"></i>
                                 <i class="fas fa-star"></i>
                             </div>
                             <p class="testimonial-text">"Professional service from start to finish. The team understood our requirements and delivered exactly what we were looking for. Thank you Bluechip!"</p>
                         </div>
                         <div class="testimonial-author">
                             <div class="author-avatar">
                                 <img src="https://images.pexels.com/photos/14587417/pexels-photo-14587417.jpeg?w=100&h=100&fit=crop&crop=face" alt="Client" class="avatar-img">
                             </div>
                             <div class="author-info">
                                 <h5 class="author-name">Priya Fernando</h5>
                                 <p class="author-title">Marketing Manager</p>
                             </div>
                         </div>
                     </div>
                 </div>
                 
                 <div class="col-lg-4 col-md-6 mb-4">
                     <div class="testimonial-card">
                         <div class="testimonial-content">
                             <div class="stars">
                                 <i class="fas fa-star"></i>
                                 <i class="fas fa-star"></i>
                                 <i class="fas fa-star"></i>
                                 <i class="fas fa-star"></i>
                                 <i class="fas fa-star"></i>
                             </div>
                             <p class="testimonial-text">"Outstanding customer service and attention to detail. They guided us through every step of the buying process. We couldn't be happier with our new home!"</p>
                         </div>
                         <div class="testimonial-author">
                             <div class="author-avatar">
                                 <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face" alt="Client" class="avatar-img">
                             </div>
                             <div class="author-info">
                                 <h5 class="author-name">David Silva</h5>
                                 <p class="author-title">Engineer</p>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>

     <!-- Contact Section -->
     <section class="contact-section" id="contact">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Side - Logo and Tagline -->
                <div class="col-lg-7 col-md-6">
                    <div class="contact-brand">
                        <div class="contact-logo-container">
                            <img src="/public/images/uploads/logo.jpeg" alt="Bluechip Real Estate Logo" class="contact-logo">
                        </div>
                        <div class="contact-brand-info">
                            <h2 class="contact-brand-name">Bluechip Real Estate (Pvt) Limited</h2>
                            <p class="contact-tagline sinhala-text">අපේ රටේ ඉඩමක් ගන්න හොඳම තැන</p>
                            <p class="contact-description">Your trusted partner in real estate excellence. We're here to help you find your perfect property and provide exceptional service every step of the way.</p>
                            
                            <!-- Contact Information -->
                            <div class="contact-info-details">
                                <div class="contact-info-item">
                                    <i class="fas fa-phone"></i>
                                    <span>(+94) 71 609 2918</span>
                                </div>
                                <div class="contact-info-item">
                                    <i class="fas fa-envelope"></i>
                                    <span>hello@bluechiplands.asia</span>
                                </div>
                                <div class="contact-info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>World Trade Center, West Tower,<br>Level 37, Colombo 01, Sri Lanka</span>
                                </div>
                                
                                <!-- Social Media -->
                                <div class="contact-info-item social-handles">
                                    <i class="fas fa-share-alt"></i>
                                    <div class="social-links-contact">
                                        <a href="https://www.facebook.com/p/Bluechip-Real-Estate-100091440704853/" target="_blank" class="social-link">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <a href="#" target="_blank" class="social-link">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a href="#" target="_blank" class="social-link">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                        <a href="https://wa.me/94716092918" target="_blank" class="social-link">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side - Contact Form -->
                <div class="col-lg-5 col-md-6">
                    <div class="contact-content">
                        <h3>Get In Touch</h3>
                        <p>Send us a message and we'll get back to you soon.</p>
                        <form class="contact-form" id="contactForm" method="POST" action="/contact">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea id="message" name="message" placeholder="Tell us about your property needs..." required></textarea>
                            </div>
                            <button type="submit" class="btn-submit">Send Message</button>
                        </form>
                    </div>
                </div>
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
                    <h5>About Bluechip Real Estate</h5>
                    <p>Your trusted partner in finding premium properties across Sri Lanka. We specialize in luxury apartments, houses, and commercial spaces.</p>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#top">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#properties">Properties</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Contact Info</h5>
                    <p><i class="fas fa-phone me-2"></i>(+94) 71 609 2918</p>
                    <p><i class="fas fa-envelope me-2"></i>hello@bluechiplands.asia</p>
                    <p><i class="fas fa-map-marker-alt me-2"></i><span>World Trade Center, West Tower,<br>Level 37, Colombo 01, Sri Lanka</span></p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Follow Us</h5>
                    <div class="social-links">
                        <a href="https://www.facebook.com/p/Bluechip-Real-Estate-100091440704853/" class="me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://wa.me/94716092918" class="me-3"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Bluechip Real Estate. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content login-modal-content">
                <div class="modal-header login-modal-header">
                    <div class="login-header-content">
                        <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="loginMessage" class="alert alert-info" style="display: none; margin-bottom: 20px;">
                        <i class="fas fa-info-circle me-2"></i>
                        Please sign in to submit your contact request. This helps us provide better service and track your inquiries.
                    </div>
                    <form id="loginForm">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                        
                        <div class="form-group">
                            <input type="email" class="form-control" id="loginEmail" name="email" placeholder="Email" required>
                        </div>
                        
                        <div class="form-group password-field">
                            <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Password" required>
                            <button type="button" class="password-toggle" id="toggleLoginPassword">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                        
                        <div class="forgot-password">
                            <a href="#" class="forgot-password-link">Forgot password?</a>
                        </div>
                        
                        <button type="submit" class="btn login-btn">Login</button>
                        
                        <div class="text-center mt-3">
                            <p class="mb-0">Don't have an account? <a href="#" class="register-link" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Signup</a></p>
                        </div>
                        
                        <div class="divider">
                            <span>Or</span>
                        </div>
                        
                        <div class="social-login">
                            <a href="#" class="social-btn facebook">
                                <i class="fab fa-facebook-f"></i>
                                Login with Facebook
                            </a>
                            <a href="#" class="social-btn google">
                                <i class="fab fa-google"></i>
                                Login with Google
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content register-modal-content">
                <div class="modal-header register-modal-header">
                    <div class="register-header-content">
                        <h5 class="modal-title" id="registerModalLabel">Signup</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                        
                        <div class="form-group">
                            <input type="email" class="form-control" id="registerEmail" name="email" placeholder="Email" required>
                        </div>
                        
                        <div class="form-group password-field">
                            <input type="password" class="form-control" id="registerPassword" name="password" placeholder="Create password" required>
                            <button type="button" class="password-toggle" id="toggleRegisterPassword">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                        
                        <div class="form-group password-field">
                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Confirm password" required>
                            <button type="button" class="password-toggle" id="toggleConfirmPassword">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                        
                        <button type="submit" class="btn register-btn">Signup</button>
                        
                        <div class="text-center mt-3">
                            <p class="mb-0">Already have an account? <a href="#" class="login-link" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Login</a></p>
                        </div>
                        
                        <div class="divider">
                            <span>Or</span>
                        </div>
                        
                        <div class="social-login">
                            <a href="#" class="social-btn facebook">
                                <i class="fab fa-facebook-f"></i>
                                Login with Facebook
                            </a>
                            <a href="#" class="social-btn google">
                                <i class="fab fa-google"></i>
                                Login with Google
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Language Change Functionality
        function changeLanguage(lang) {
            const languageToggle = document.getElementById('languageDropdown');
            const currentLang = lang === 'en' ? 'EN' : 'සිංහල';
            
            // Update the dropdown button text
            languageToggle.innerHTML = `<i class="fas fa-globe me-1"></i>${currentLang}`;
            
            // Store language preference in localStorage
            localStorage.setItem('selectedLanguage', lang);
            
            // Show a simple alert for now (can be enhanced later)
            if (lang === 'en') {
                alert('Language changed to English');
            } else {
                alert('භාෂාව සිංහලට වෙනස් කරන ලදී');
            }
            
            // Close the dropdown
            const dropdown = bootstrap.Dropdown.getInstance(languageToggle);
            if (dropdown) {
                dropdown.hide();
            }
        }
        
        // Load saved language preference on page load
        document.addEventListener('DOMContentLoaded', function() {
            const savedLang = localStorage.getItem('selectedLanguage');
            if (savedLang) {
                const languageToggle = document.getElementById('languageDropdown');
                const currentLang = savedLang === 'en' ? 'EN' : 'සිංහල';
                languageToggle.innerHTML = `<i class="fas fa-globe me-1"></i>${currentLang}`;
            }
        });
        
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
                autoPlayInterval = setInterval(nextSlide, 7000); // 7 seconds
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

            // Modal functionality
            // Clean up any lingering backdrop when all modals are closed
            const loginModal = document.getElementById('loginModal');
            const registerModal = document.getElementById('registerModal');
            
            // Add cleanup function
            function cleanupModals() {
                const openModals = document.querySelectorAll('.modal.show');
                if (openModals.length === 0) {
                    // Remove any lingering backdrop
                    const backdrops = document.querySelectorAll('.modal-backdrop');
                    backdrops.forEach(backdrop => backdrop.remove());
                    // Remove modal-open class from body
                    document.body.classList.remove('modal-open');
                    // Reset body padding
                    document.body.style.paddingRight = '';
                }
            }
            
            // Clean up when modals are hidden
            [loginModal, registerModal].forEach(modal => {
                modal.addEventListener('hidden.bs.modal', cleanupModals);
            });

            // Hide login message when modal is opened from navbar
            const loginModalTrigger = document.querySelector('[data-bs-target="#loginModal"]');
            if (loginModalTrigger) {
                loginModalTrigger.addEventListener('click', function() {
                    const loginMessage = document.getElementById('loginMessage');
                    if (loginMessage) {
                        loginMessage.style.display = 'none';
                    }
                });
            }

            // Password toggle functionality
            const toggleLoginPassword = document.getElementById('toggleLoginPassword');
            const loginPassword = document.getElementById('loginPassword');
            const toggleRegisterPassword = document.getElementById('toggleRegisterPassword');
            const registerPassword = document.getElementById('registerPassword');

            if (toggleLoginPassword && loginPassword) {
                toggleLoginPassword.addEventListener('click', function() {
                    const type = loginPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                    loginPassword.setAttribute('type', type);
                    const icon = this.querySelector('i');
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            }

            if (toggleRegisterPassword && registerPassword) {
                toggleRegisterPassword.addEventListener('click', function() {
                    const type = registerPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                    registerPassword.setAttribute('type', type);
                    const icon = this.querySelector('i');
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            }

            // Confirm password toggle
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const confirmPassword = document.getElementById('confirmPassword');

            if (toggleConfirmPassword && confirmPassword) {
                toggleConfirmPassword.addEventListener('click', function() {
                    const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                    confirmPassword.setAttribute('type', type);
                    const icon = this.querySelector('i');
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            }

            // Form submission handling
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');

            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    
                    fetch('/login', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
                            if (loginModal) loginModal.hide();
                            window.location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
                });
            }

            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    
                    fetch('/register', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const registerModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
                            if (registerModal) registerModal.hide();
                            window.location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
                });
            }

            // Modal link switching
            const registerLink = document.querySelector('.register-link');
            const loginLink = document.querySelector('.login-link');

            if (registerLink) {
                registerLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
                    const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
                    if (loginModal) loginModal.hide();
                    registerModal.show();
                });
            }

            if (loginLink) {
                loginLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    const registerModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
                    const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                    if (registerModal) registerModal.hide();
                    loginModal.show();
                });
            }
        });

        // Ensure navbar home link scrolls to top
        document.addEventListener('DOMContentLoaded', function() {
            // Try multiple selectors to find the navbar home link
            const navbarHomeLink = document.querySelector('.navbar-nav .home-link') ||
                                 document.querySelector('.navbar-nav .nav-link[href="/#top"]') || 
                                 document.querySelector('.navbar-nav .nav-link[href*="#top"]') ||
                                 document.querySelector('.navbar-nav a[href="/#top"]') ||
                                 document.querySelector('.navbar-nav a[href*="#top"]');
            
            if (navbarHomeLink) {
                navbarHomeLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    const topElement = document.getElementById('top');
                    if (topElement) {
                        topElement.scrollIntoView({ 
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            }
            
            // Also add a general handler for any link with #top
            document.addEventListener('click', function(e) {
                if (e.target.matches('a[href*="#top"]') && e.target.closest('.navbar-nav')) {
                    e.preventDefault();
                    const topElement = document.getElementById('top');
                    if (topElement) {
                        topElement.scrollIntoView({ 
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });

        // Contact form authentication check
        document.addEventListener('DOMContentLoaded', function() {
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Check if user is authenticated
                    fetch('/contact/check-auth')
                        .then(response => response.json())
                        .then(data => {
                            if (data.isLoggedIn) {
                                // User is logged in, submit the form
                                submitContactForm();
                            } else {
                                // User is not logged in, show existing login modal with message
                                const loginMessage = document.getElementById('loginMessage');
                                if (loginMessage) {
                                    loginMessage.style.display = 'block';
                                }
                                const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                                loginModal.show();
                            }
                        })
                        .catch(error => {
                            console.error('Error checking authentication:', error);
                            // Fallback: show login modal with message
                            const loginMessage = document.getElementById('loginMessage');
                            if (loginMessage) {
                                loginMessage.style.display = 'block';
                            }
                            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                            loginModal.show();
                        });
                });
            }
        });
        
        function submitContactForm() {
            const formData = new FormData(document.getElementById('contactForm'));
            
            fetch('/contact', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    document.getElementById('contactForm').reset();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
    </script>
</body>
</html>