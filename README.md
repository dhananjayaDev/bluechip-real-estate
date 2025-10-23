# Bluechip Real Estate Website

A modern, responsive real estate website built with PHP, featuring property search, user management, and admin panel functionality.

## 🏠 Features

### Public Features
- **Property Search**: Advanced search with filters (location, type, price, bedrooms, bathrooms)
- **Property Listings**: Browse all available properties with detailed information
- **Property Details**: View individual property details with images and features
- **Contact Forms**: Submit inquiries for specific properties
- **User Authentication**: Register, login, and manage user accounts
- **Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices

### Admin Features
- **Property Management**: Add, edit, delete, and manage properties
- **User Management**: View and manage user accounts
- **Request Management**: Handle property inquiries and contact requests
- **Dashboard**: Overview of system statistics and recent activity

## 🚀 Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Styling**: Custom CSS with responsive design
- **Architecture**: MVC (Model-View-Controller) pattern

## 📁 Project Structure

```
├── app/
│   ├── components/          # Reusable UI components
│   ├── config/             # Configuration files
│   ├── controllers/        # MVC Controllers
│   ├── core/               # Core framework files
│   ├── helpers/            # Helper functions
│   ├── models/             # MVC Models
│   └── views/              # MVC Views
├── database/
│   └── schema.sql          # Database schema
├── public/
│   ├── css/                # Stylesheets
│   ├── js/                  # JavaScript files
│   └── images/             # Images and uploads
├── .gitignore              # Git ignore rules
└── index.php               # Application entry point
```

## 🛠️ Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/dhananjayaDev/bluechip-real-estate.git
   cd bluechip-real-estate
   ```

2. **Database Setup**
   - Create a MySQL database named `real_estate`
   - Import the database schema:
     ```bash
     mysql -u root -p real_estate < database/schema.sql
     ```

3. **Configuration**
   - Copy `.env.example` to `.env` (if available)
   - Update database credentials in `app/config/database.php`
   - Set up file permissions for uploads directory

4. **Web Server Configuration**
   - Point your web server document root to the project directory
   - Ensure mod_rewrite is enabled (for Apache)

## 🔧 Configuration

### Database Configuration
Update the database settings in `app/config/database.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'real_estate');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

### File Uploads
- Upload directory: `public/uploads/`
- Maximum file size: 5MB
- Allowed extensions: jpg, jpeg, png, gif, webp

## 🔒 Security Features

- **CSRF Protection**: All forms include CSRF tokens
- **Input Validation**: Server-side validation for all inputs
- **SQL Injection Prevention**: Prepared statements used throughout
- **XSS Protection**: Output escaping implemented
- **File Upload Security**: Restricted file types and sizes
- **Session Management**: Secure session handling

## 📱 Responsive Design

The website is fully responsive and optimized for:
- Desktop computers (1200px+)
- Tablets (768px - 1199px)
- Mobile phones (320px - 767px)

## 🧪 Testing

Before deployment, ensure you test:
- User registration and login
- Property search functionality
- Admin panel features
- File uploads
- Responsive design on different devices
- Cross-browser compatibility

## 📄 License

This project is proprietary software developed for Bluechip Real Estate.

## 🤝 Contributing

For internal development team only.

## 📞 Support

For technical support or questions, contact the development team.

---

**Bluechip Real Estate (Pvt) Limited**  
*අපේ රටේ ඉඩම්ක් ගන්න හොඳම තැන*