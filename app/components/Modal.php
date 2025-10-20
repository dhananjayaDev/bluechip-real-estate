<?php

require_once 'Component.php';

class Modal extends Component {
    
    public function render() {
        $csrfToken = $this->getData('csrfToken', '');
        
        return "
        <!-- Login Modal -->
        <div class=\"modal fade\" id=\"loginModal\" tabindex=\"-1\" aria-labelledby=\"loginModalLabel\" aria-hidden=\"true\">
            <div class=\"modal-dialog modal-dialog-centered\">
                <div class=\"modal-content login-modal-content\">
                    <div class=\"modal-header login-modal-header\">
                        <div class=\"login-header-content\">
                            <h5 class=\"modal-title\" id=\"loginModalLabel\">Login</h5>
                        </div>
                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                    </div>
                    <div class=\"modal-body\">
                        <form id=\"loginForm\">
                            <input type=\"hidden\" name=\"csrf_token\" value=\"{$csrfToken}\">
                            
                            <div class=\"form-group\">
                                <input type=\"email\" class=\"form-control\" id=\"loginEmail\" name=\"email\" placeholder=\"Email\" required>
                            </div>
                            
                            <div class=\"form-group password-field\">
                                <input type=\"password\" class=\"form-control\" id=\"loginPassword\" name=\"password\" placeholder=\"Password\" required>
                                <button type=\"button\" class=\"password-toggle\" id=\"toggleLoginPassword\">
                                    <i class=\"fas fa-eye-slash\"></i>
                                </button>
                            </div>
                            
                            <div class=\"forgot-password\">
                                <a href=\"#\" class=\"forgot-password-link\">Forgot password?</a>
                            </div>
                            
                            <button type=\"submit\" class=\"btn login-btn\">Login</button>
                            
                            <div class=\"text-center mt-3\">
                                <p class=\"mb-0\">Don't have an account? <a href=\"#\" class=\"register-link\" data-bs-toggle=\"modal\" data-bs-target=\"#registerModal\" data-bs-dismiss=\"modal\">Signup</a></p>
                            </div>
                            
                            <div class=\"divider\">
                                <span>Or</span>
                            </div>
                            
                            <div class=\"social-login\">
                                <a href=\"#\" class=\"social-btn facebook\">
                                    <i class=\"fab fa-facebook-f\"></i>
                                    Login with Facebook
                                </a>
                                <a href=\"#\" class=\"social-btn google\">
                                    <i class=\"fab fa-google\"></i>
                                    Login with Google
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Register Modal -->
        <div class=\"modal fade\" id=\"registerModal\" tabindex=\"-1\" aria-labelledby=\"registerModalLabel\" aria-hidden=\"true\">
            <div class=\"modal-dialog modal-dialog-centered\">
                <div class=\"modal-content register-modal-content\">
                    <div class=\"modal-header register-modal-header\">
                        <div class=\"register-header-content\">
                            <h5 class=\"modal-title\" id=\"registerModalLabel\">Signup</h5>
                        </div>
                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                    </div>
                    <div class=\"modal-body\">
                        <form id=\"registerForm\">
                            <input type=\"hidden\" name=\"csrf_token\" value=\"{$csrfToken}\">
                            
                            <div class=\"form-group\">
                                <input type=\"email\" class=\"form-control\" id=\"registerEmail\" name=\"email\" placeholder=\"Email\" required>
                            </div>
                            
                            <div class=\"form-group password-field\">
                                <input type=\"password\" class=\"form-control\" id=\"registerPassword\" name=\"password\" placeholder=\"Create password\" required>
                                <button type=\"button\" class=\"password-toggle\" id=\"toggleRegisterPassword\">
                                    <i class=\"fas fa-eye-slash\"></i>
                                </button>
                            </div>
                            
                            <div class=\"form-group password-field\">
                                <input type=\"password\" class=\"form-control\" id=\"confirmPassword\" name=\"confirm_password\" placeholder=\"Confirm password\" required>
                                <button type=\"button\" class=\"password-toggle\" id=\"toggleConfirmPassword\">
                                    <i class=\"fas fa-eye-slash\"></i>
                                </button>
                            </div>
                            
                            <button type=\"submit\" class=\"btn register-btn\">Signup</button>
                            
                            <div class=\"text-center mt-3\">
                                <p class=\"mb-0\">Already have an account? <a href=\"#\" class=\"login-link\" data-bs-toggle=\"modal\" data-bs-target=\"#loginModal\" data-bs-dismiss=\"modal\">Login</a></p>
                            </div>
                            
                            <div class=\"divider\">
                                <span>Or</span>
                            </div>
                            
                            <div class=\"social-login\">
                                <a href=\"#\" class=\"social-btn facebook\">
                                    <i class=\"fab fa-facebook-f\"></i>
                                    Login with Facebook
                                </a>
                                <a href=\"#\" class=\"social-btn google\">
                                    <i class=\"fab fa-google\"></i>
                                    Login with Google
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        ";
    }
    
    protected function renderCSS() {
        return "
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
        ";
    }
    
    protected function renderJS() {
        return "
        <script>
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
                        const loginModalInstance = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
                        if (loginModalInstance) {
                            loginModalInstance.hide();
                        }
                        window.location.reload();
                    } else {
                        alert(data.message || 'Login failed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred during login');
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
                        const registerModalInstance = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
                        if (registerModalInstance) {
                            registerModalInstance.hide();
                        }
                        window.location.reload();
                    } else {
                        alert(data.message || 'Registration failed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred during registration');
                });
            });
        }
        </script>
        ";
    }
}
