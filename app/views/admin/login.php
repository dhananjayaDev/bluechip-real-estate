<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Bluechip Real Estate</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .admin-login-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        
        .admin-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .admin-logo img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 15px;
        }
        
        .admin-logo h1 {
            color: #1e40af;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .admin-logo p {
            color: #666;
            font-size: 0.9rem;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #1e40af;
        }
        
        .login-btn {
            width: 100%;
            padding: 12px;
            background: #1e40af;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .login-btn:hover {
            background: #1e3a8a;
        }
        
        .back-to-site {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-to-site a {
            color: #1e40af;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-to-site a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        
        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="admin-login-container">
        <div class="admin-logo">
            <img src="/public/images/uploads/logo.jpeg" alt="Bluechip Real Estate">
            <h1>Admin Login</h1>
            <p>Bluechip Real Estate Management</p>
        </div>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="/admin/login">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken ?? ''; ?>">
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Login to Admin
            </button>
        </form>
        
        <div class="back-to-site">
            <a href="/">
                <i class="fas fa-arrow-left"></i> Back to Main Site
            </a>
        </div>
    </div>
</body>
</html>
