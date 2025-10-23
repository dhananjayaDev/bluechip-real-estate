<?php

class SearchSection extends Component {
    
    private $targetUrl = '/';
    private $filters = [];
    private $enableAjax = false;
    
    public function __construct($data = []) {
        parent::__construct($data);
        $this->targetUrl = $data['targetUrl'] ?? '/';
        $this->filters = $data['filters'] ?? [];
        $this->enableAjax = $data['enableAjax'] ?? false;
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
                            <form action="' . $this->targetUrl . '" method="GET" id="property-search-form">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <input type="text" class="form-control" name="search" placeholder="Keyword" value="' . htmlspecialchars($this->filters['search'] ?? '') . '">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <select class="form-control" name="city">
                                            <option value="">All Cities</option>
                                            <option value="Colombo"' . (($this->filters['city'] ?? '') === 'Colombo' ? ' selected' : '') . '>Colombo</option>
                                            <option value="Kandy"' . (($this->filters['city'] ?? '') === 'Kandy' ? ' selected' : '') . '>Kandy</option>
                                            <option value="Galle"' . (($this->filters['city'] ?? '') === 'Galle' ? ' selected' : '') . '>Galle</option>
                                            <option value="Negombo"' . (($this->filters['city'] ?? '') === 'Negombo' ? ' selected' : '') . '>Negombo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <select class="form-control" name="property_type">
                                            <option value="">Property Type</option>
                                            <option value="house"' . (($this->filters['property_type'] ?? '') === 'house' ? ' selected' : '') . '>House</option>
                                            <option value="apartment"' . (($this->filters['property_type'] ?? '') === 'apartment' ? ' selected' : '') . '>Apartment</option>
                                            <option value="villa"' . (($this->filters['property_type'] ?? '') === 'villa' ? ' selected' : '') . '>Villa</option>
                                            <option value="land"' . (($this->filters['property_type'] ?? '') === 'land' ? ' selected' : '') . '>Land</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <select class="form-control" name="bedrooms">
                                            <option value="">Bedrooms</option>
                                            <option value="1"' . (($this->filters['bedrooms'] ?? '') === '1' ? ' selected' : '') . '>1</option>
                                            <option value="2"' . (($this->filters['bedrooms'] ?? '') === '2' ? ' selected' : '') . '>2</option>
                                            <option value="3"' . (($this->filters['bedrooms'] ?? '') === '3' ? ' selected' : '') . '>3</option>
                                            <option value="4"' . (($this->filters['bedrooms'] ?? '') === '4' ? ' selected' : '') . '>4</option>
                                            <option value="5"' . (($this->filters['bedrooms'] ?? '') === '5' ? ' selected' : '') . '>5+</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <select class="form-control" name="bathrooms">
                                            <option value="">Bathrooms</option>
                                            <option value="1"' . (($this->filters['bathrooms'] ?? '') === '1' ? ' selected' : '') . '>1</option>
                                            <option value="2"' . (($this->filters['bathrooms'] ?? '') === '2' ? ' selected' : '') . '>2</option>
                                            <option value="3"' . (($this->filters['bathrooms'] ?? '') === '3' ? ' selected' : '') . '>3</option>
                                            <option value="4"' . (($this->filters['bathrooms'] ?? '') === '4' ? ' selected' : '') . '>4</option>
                                            <option value="5"' . (($this->filters['bathrooms'] ?? '') === '5' ? ' selected' : '') . '>5+</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="number" class="form-control" name="min_price" placeholder="Min Price" value="' . htmlspecialchars($this->filters['min_price'] ?? '') . '">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="number" class="form-control" name="max_price" placeholder="Max Price" value="' . htmlspecialchars($this->filters['max_price'] ?? '') . '">
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
    
    public function renderJS() {
        if (!$this->enableAjax) {
            return '';
        }
        
        return '
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchForm = document.getElementById("property-search-form");
            const propertiesGrid = document.querySelector(".properties-grid");
            const resultsInfo = document.querySelector(".search-results-info");
            const sectionTitle = document.querySelector(".section-title");
            const sectionSubtitle = document.querySelector(".section-subtitle");
            
            if (searchForm) {
                // Handle form submission
                searchForm.addEventListener("submit", function(e) {
                    e.preventDefault();
                    performSearch();
                });
                
                // Handle input changes for real-time search
                const inputs = searchForm.querySelectorAll("input, select");
                inputs.forEach(input => {
                    input.addEventListener("change", function() {
                        // Debounce the search
                        clearTimeout(this.searchTimeout);
                        this.searchTimeout = setTimeout(performSearch, 500);
                    });
                });
            }
            
            function performSearch() {
                const formData = new FormData(searchForm);
                const params = new URLSearchParams();
                
                // Add all form data to params
                for (let [key, value] of formData.entries()) {
                    if (value.trim() !== "") {
                        params.append(key, value);
                    }
                }
                
                // Show loading state
                if (propertiesGrid) {
                    propertiesGrid.innerHTML = "<div class=\"text-center\"><div class=\"spinner-border\" role=\"status\"><span class=\"sr-only\">Loading...</span></div></div>";
                }
                
                // Make AJAX request
                fetch("/properties?" + params.toString())
                    .then(response => response.text())
                    .then(html => {
                        // Extract properties from the response
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, "text/html");
                        const newPropertiesGrid = doc.querySelector(".properties-grid");
                        const newResultsInfo = doc.querySelector(".search-results-info");
                        const newSectionTitle = doc.querySelector(".section-title");
                        const newSectionSubtitle = doc.querySelector(".section-subtitle");
                        
                        // Update the page content
                        if (newPropertiesGrid && propertiesGrid) {
                            propertiesGrid.innerHTML = newPropertiesGrid.innerHTML;
                        }
                        
                        // Handle results info - only update if it exists, don\'t create duplicates
                        if (resultsInfo) {
                            if (newResultsInfo) {
                                resultsInfo.innerHTML = newResultsInfo.innerHTML;
                                resultsInfo.style.display = "block";
                            } else {
                                resultsInfo.style.display = "none";
                            }
                        }
                        
                        if (newSectionTitle && sectionTitle) {
                            sectionTitle.textContent = newSectionTitle.textContent;
                        }
                        
                        if (newSectionSubtitle && sectionSubtitle) {
                            sectionSubtitle.textContent = newSectionSubtitle.textContent;
                        }
                        
                        // Update URL without page reload
                        const newUrl = "/properties?" + params.toString();
                        window.history.pushState({}, "", newUrl);
                    })
                    .catch(error => {
                        console.error("Search error:", error);
                        if (propertiesGrid) {
                            propertiesGrid.innerHTML = "<div class=\"text-center text-danger\"><p>Error loading search results. Please try again.</p></div>";
                        }
                    });
            }
        });
        </script>
        ';
    }
}
