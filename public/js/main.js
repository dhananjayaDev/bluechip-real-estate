// Main JavaScript for Real Estate Website

document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
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

    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Auto-hide alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Search functionality
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(this.value);
            }, 300);
        });
    }

    // Filter functionality
    const filterForm = document.getElementById('filter-form');
    if (filterForm) {
        filterForm.addEventListener('change', function() {
            this.submit();
        });
    }

    // Price range slider
    const priceRange = document.getElementById('price-range');
    if (priceRange) {
        const minPrice = document.getElementById('min-price');
        const maxPrice = document.getElementById('max-price');
        
        priceRange.addEventListener('input', function() {
            const values = this.value.split(',');
            minPrice.value = values[0];
            maxPrice.value = values[1];
        });
    }

    // Property comparison
    const compareButtons = document.querySelectorAll('.compare-btn');
    compareButtons.forEach(button => {
        button.addEventListener('click', function() {
            const propertyId = this.dataset.propertyId;
            togglePropertyComparison(propertyId);
        });
    });

    // Initialize property comparison
    initPropertyComparison();
});

// Search function
function performSearch(query) {
    if (query.length < 2) return;
    
    fetch(`/api/search?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            displaySearchResults(data);
        })
        .catch(error => {
            console.error('Search error:', error);
        });
}

// Display search results
function displaySearchResults(results) {
    const resultsContainer = document.getElementById('search-results');
    if (!resultsContainer) return;

    if (results.length === 0) {
        resultsContainer.innerHTML = '<p class="text-muted">No properties found</p>';
        return;
    }

    const html = results.map(property => `
        <div class="search-result-item">
            <a href="/property/${property.id}" class="text-decoration-none">
                <div class="d-flex">
                    <img src="${property.thumbnail}" alt="${property.title}" class="search-thumbnail">
                    <div class="search-content">
                        <h6>${property.title}</h6>
                        <p class="text-muted small">${property.location}</p>
                        <span class="text-primary fw-bold">${formatCurrency(property.price)}</span>
                    </div>
                </div>
            </a>
        </div>
    `).join('');

    resultsContainer.innerHTML = html;
}

// Property comparison functions
let comparedProperties = JSON.parse(localStorage.getItem('comparedProperties') || '[]');

function togglePropertyComparison(propertyId) {
    const index = comparedProperties.indexOf(propertyId);
    
    if (index > -1) {
        comparedProperties.splice(index, 1);
    } else {
        if (comparedProperties.length >= 3) {
            alert('You can compare maximum 3 properties at a time');
            return;
        }
        comparedProperties.push(propertyId);
    }
    
    localStorage.setItem('comparedProperties', JSON.stringify(comparedProperties));
    updateComparisonUI();
}

function updateComparisonUI() {
    const compareButtons = document.querySelectorAll('.compare-btn');
    compareButtons.forEach(button => {
        const propertyId = button.dataset.propertyId;
        const isCompared = comparedProperties.includes(propertyId);
        
        if (isCompared) {
            button.classList.add('btn-danger');
            button.classList.remove('btn-outline-primary');
            button.innerHTML = '<i class="fas fa-times me-1"></i>Remove';
        } else {
            button.classList.remove('btn-danger');
            button.classList.add('btn-outline-primary');
            button.innerHTML = '<i class="fas fa-balance-scale me-1"></i>Compare';
        }
    });
    
    // Update comparison counter
    const compareCounter = document.getElementById('compare-counter');
    if (compareCounter) {
        compareCounter.textContent = comparedProperties.length;
        compareCounter.style.display = comparedProperties.length > 0 ? 'inline' : 'none';
    }
}

function initPropertyComparison() {
    updateComparisonUI();
}

// Utility functions
function formatCurrency(amount, currency = 'LKR') {
    if (currency === 'LKR') {
        return 'Rs. ' + amount.toLocaleString();
    }
    return currency + ' ' + amount.toLocaleString();
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function truncateText(text, length = 100) {
    if (text.length <= length) return text;
    return text.substring(0, length) + '...';
}

// AJAX helper function
function ajaxRequest(url, options = {}) {
    const defaultOptions = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    };
    
    const mergedOptions = { ...defaultOptions, ...options };
    
    return fetch(url, mergedOptions)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        });
}

// Show loading spinner
function showLoading(element) {
    element.classList.add('loading');
    element.innerHTML = '<span class="spinner"></span> Loading...';
}

// Hide loading spinner
function hideLoading(element, originalContent) {
    element.classList.remove('loading');
    element.innerHTML = originalContent;
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        const bsAlert = new bootstrap.Alert(notification);
        bsAlert.close();
    }, 5000);
}

// Handle form submissions with AJAX
function handleAjaxForm(formSelector, successCallback) {
    const form = document.querySelector(formSelector);
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitButton = this.querySelector('button[type="submit"]');
        const originalContent = submitButton.innerHTML;
        
        showLoading(submitButton);
        
        fetch(this.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            hideLoading(submitButton, originalContent);
            
            if (data.success) {
                showNotification(data.message, 'success');
                if (successCallback) successCallback(data);
            } else {
                showNotification(data.message, 'danger');
            }
        })
        .catch(error => {
            hideLoading(submitButton, originalContent);
            showNotification('An error occurred. Please try again.', 'danger');
            console.error('Error:', error);
        });
    });
}

// Initialize AJAX forms
document.addEventListener('DOMContentLoaded', function() {
    // Handle login form
    handleAjaxForm('#login-form', function(data) {
        if (data.redirect) {
            window.location.href = data.redirect;
        }
    });
    
    // Handle registration form
    handleAjaxForm('#register-form', function(data) {
        if (data.redirect) {
            window.location.href = data.redirect;
        }
    });
    
    // Handle request form
    handleAjaxForm('#request-form', function(data) {
        document.getElementById('request-form').reset();
    });
});

// Export functions for global use
window.RealEstateApp = {
    formatCurrency,
    formatDate,
    truncateText,
    showNotification,
    togglePropertyComparison,
    comparedProperties: () => comparedProperties
};
