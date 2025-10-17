<?php

require_once 'Component.php';

class Header extends Component {
    
    public function render() {
        $email = $this->getData('email', 'hello@bluechiplands.asia');
        $phone = $this->getData('phone', '(+94) 71 609 2918');
        
        return "
        <!-- Top Header -->
        <div class=\"top-header\">
            <div class=\"container\">
                <div class=\"row align-items-center\">
                    <div class=\"col-md-6 col-12\">
                        <span><i class=\"fas fa-envelope me-2\"></i>{$email}</span>
                    </div>
                    <div class=\"col-md-6 col-12 text-md-end text-center\">
                        <span><i class=\"fas fa-phone me-2\"></i>{$phone}</span>
                    </div>
                </div>
            </div>
        </div>
        ";
    }
    
    protected function renderCSS() {
        return "
        /* Header Styles */
        .top-header {
            background-color: #1e3a8a;
            color: var(--white);
            padding: 10px 0;
            font-size: 14px;
        }
        
        .top-header span {
            color: white;
            font-weight: 600;
        }
        
        .top-header i {
            color: white;
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
        }
        
        @media (max-width: 576px) {
            .top-header {
                padding: 4px 0;
                font-size: 11px;
            }
        }
        ";
    }
}
