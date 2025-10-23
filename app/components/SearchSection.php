<?php

class SearchSection extends Component {
    
    private $targetUrl = '/';
    
    public function __construct($data = []) {
        parent::__construct($data);
        $this->targetUrl = $data['targetUrl'] ?? '/';
    }
    
    public function render() {
        return '
        <!-- Search Section -->
        <section class="search-section" id="search">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="search-form">
                            <h3>Search Properties</h3>
                            <form action="' . $this->targetUrl . '" method="GET">
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
                                            <option value="">Property Type</option>
                                            <option value="house">House</option>
                                            <option value="apartment">Apartment</option>
                                            <option value="villa">Villa</option>
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
        ';
    }
    
    public function renderCSS() {
        return '
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
            box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
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
        ';
    }
}
