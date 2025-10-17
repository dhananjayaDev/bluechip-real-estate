# Bluechip Realty - Modern PHP Real Estate Website

A modern, responsive real estate website built with PHP using MVC architecture. Features include property listings, user authentication, property details pages, image galleries, and more.

## Features

### 🏠 Property Management
- Property listings with search and filtering
- Detailed property pages with image galleries
- Property features and amenities
- Location maps integration
- Similar properties suggestions

### 👤 User Features
- User registration and authentication
- Property favorites system
- Property request forms
- User dashboard (favorites, requests)

### 🎨 Modern Design
- Responsive Bootstrap 5 design
- Modern UI with smooth animations
- Mobile-friendly interface
- Print-friendly property pages
- Social sharing capabilities

### 🔒 Security Features
- CSRF protection
- Input validation and sanitization
- Password hashing
- SQL injection prevention
- XSS protection

## Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

### Setup Instructions

1. **Clone or download the project**
   ```bash
   git clone <repository-url>
   cd real-estate-01
   ```

2. **Configure Database**
   - Create a MySQL database named `real_estate`
   - Import the database schema:
     ```bash
     mysql -u root -p real_estate < database/schema.sql
     ```

3. **Configure Application**
   - Update database credentials in `app/config/database.php`:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'real_estate');
     define('DB_USER', 'your_username');
     define('DB_PASS', 'your_password');
     ```

4. **Set Permissions**
   ```bash
   chmod 755 public/uploads/
   chmod 755 public/images/
   ```

5. **Configure Web Server**
   
   **For Apache (.htaccess):**
   ```apache
   RewriteEngine On
   RewriteCond %{REQUEST_FILENAME} !-f
   RewriteCond %{REQUEST_FILENAME} !-d
   RewriteRule ^(.*)$ index.php [QSA,L]
   ```
   
   **For Nginx:**
   ```nginx
   location / {
       try_files $uri $uri/ /index.php?$query_string;
   }
   ```

6. **Access the Website**
   - Open your browser and navigate to your domain
   - Default admin credentials:
     - Email: `admin@bluechiprealty.com`
     - Password: `password`

## Project Structure

```
real-estate-01/
├── app/
│   ├── config/          # Configuration files
│   ├── controllers/      # MVC Controllers
│   ├── core/            # Core framework classes
│   ├── helpers/          # Helper functions
│   ├── models/           # MVC Models
│   └── views/            # MVC Views
├── database/             # Database schema
├── public/               # Public assets
│   ├── css/              # Stylesheets
│   ├── js/               # JavaScript files
│   ├── images/           # Images
│   └── uploads/          # User uploads
└── index.php             # Entry point
```

## Key Components

### Models
- **Property**: Handles property data and operations
- **User**: Manages user authentication and profiles
- **UserRequest**: Handles property requests

### Controllers
- **PropertyController**: Manages property listings and details
- **AuthController**: Handles user authentication

### Views
- **Layouts**: Main application layout
- **Properties**: Property listing and detail pages
- **Auth**: Login and registration pages

## Configuration

### Site Settings
Update `app/config/config.php` to customize:
- Site name and URL
- Email settings
- File upload limits
- Image dimensions

### Database Schema
The database includes tables for:
- `users`: User accounts and authentication
- `properties`: Property listings
- `property_images`: Property photos
- `property_features`: Property amenities
- `user_requests`: User inquiries
- `user_favorites`: User saved properties

## Features Overview

### Property Details Page
- **Header**: Site logo, navigation, breadcrumbs
- **Property Info**: Title, description, key details
- **Image Gallery**: Swiper.js carousel with thumbnails
- **Property Features**: Amenities and facilities
- **Location Map**: Google Maps integration
- **Request Form**: Contact form for logged-in users
- **Agent Contact**: Contact information
- **Similar Properties**: Related listings
- **User Actions**: Favorites, share, print

### User Authentication
- Secure registration and login
- Password hashing with PHP's `password_hash()`
- Session management
- CSRF protection

### Security Features
- Input validation and sanitization
- SQL injection prevention with prepared statements
- XSS protection with `htmlspecialchars()`
- CSRF tokens for forms
- Password strength requirements

## Customization

### Adding New Property Types
1. Update the `property_type` enum in the database
2. Add options to the property type filter
3. Update property type display logic

### Styling
- Modify `public/css/style.css` for custom styling
- Bootstrap 5 classes are used throughout
- CSS custom properties for easy theming

### Adding Features
- Follow MVC pattern for new features
- Add routes in `index.php`
- Create corresponding controllers and models
- Add views in appropriate directories

## Browser Support
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## License
This project is open source and available under the MIT License.

## Support
For support and questions, please contact the development team.

---

**Note**: Remember to update the Google Maps API key in the property details view for map functionality to work properly.
