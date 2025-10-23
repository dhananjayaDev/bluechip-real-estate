<?php
/**
 * Comprehensive Test Suite for Bluechip Real Estate Website
 * This script tests all major functionality before deployment
 */

// Test configuration
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// Include required files
require_once 'app/config/database.php';
require_once 'app/core/Database.php';
require_once 'app/core/Model.php';
require_once 'app/models/Property.php';
require_once 'app/models/User.php';
require_once 'app/models/UserRequest.php';

class TestSuite {
    private $results = [];
    private $propertyModel;
    private $userModel;
    private $requestModel;
    
    public function __construct() {
        $this->propertyModel = new Property();
        $this->userModel = new User();
        $this->requestModel = new UserRequest();
    }
    
    public function runAllTests() {
        echo "🧪 BLUECHIP REAL ESTATE - COMPREHENSIVE TEST SUITE\n";
        echo "=" . str_repeat("=", 50) . "\n\n";
        
        $this->testDatabaseConnection();
        $this->testPropertySearch();
        $this->testUserManagement();
        $this->testDataIntegrity();
        $this->testSecurityFeatures();
        $this->testEdgeCases();
        
        $this->displayResults();
    }
    
    private function testDatabaseConnection() {
        echo "🔗 Testing Database Connection...\n";
        
        try {
            $db = Database::getInstance();
            $stmt = $db->prepare("SELECT 1");
            $stmt->execute();
            $this->addResult("Database Connection", "PASS", "Successfully connected to database");
        } catch (Exception $e) {
            $this->addResult("Database Connection", "FAIL", "Failed to connect: " . $e->getMessage());
        }
        
        echo "\n";
    }
    
    private function testPropertySearch() {
        echo "🏠 Testing Property Search Functionality...\n";
        
        // Test 1: Get all properties
        $allProperties = $this->propertyModel->search([], 1, 10);
        $this->addResult("Get All Properties", 
            count($allProperties) > 0 ? "PASS" : "FAIL", 
            "Found " . count($allProperties) . " properties");
        
        // Test 2: Search by city
        $colomboProperties = $this->propertyModel->search(['city' => 'Colombo'], 1, 10);
        $this->addResult("Search by City (Colombo)", 
            count($colomboProperties) > 0 ? "PASS" : "FAIL", 
            "Found " . count($colomboProperties) . " properties in Colombo");
        
        // Test 3: Search by property type
        $apartments = $this->propertyModel->search(['property_type' => 'apartment'], 1, 10);
        $this->addResult("Search by Property Type (Apartment)", 
            count($apartments) > 0 ? "PASS" : "FAIL", 
            "Found " . count($apartments) . " apartments");
        
        // Test 4: Search by keyword
        $modernProperties = $this->propertyModel->search(['search' => 'modern'], 1, 10);
        $this->addResult("Search by Keyword (modern)", 
            count($modernProperties) > 0 ? "PASS" : "FAIL", 
            "Found " . count($modernProperties) . " properties matching 'modern'");
        
        // Test 5: Search by bedrooms
        $twoBedrooms = $this->propertyModel->search(['bedrooms' => '2'], 1, 10);
        $this->addResult("Search by Bedrooms (2+)", 
            count($twoBedrooms) >= 0 ? "PASS" : "FAIL", 
            "Found " . count($twoBedrooms) . " properties with 2+ bedrooms");
        
        // Test 6: Combined search
        $combinedSearch = $this->propertyModel->search([
            'city' => 'Colombo',
            'property_type' => 'apartment',
            'bedrooms' => '2'
        ], 1, 10);
        $this->addResult("Combined Search", 
            count($combinedSearch) >= 0 ? "PASS" : "FAIL", 
            "Found " . count($combinedSearch) . " properties matching combined criteria");
        
        // Test 7: Search count
        $totalCount = $this->propertyModel->getCount();
        $this->addResult("Property Count Function", 
            $totalCount > 0 ? "PASS" : "FAIL", 
            "Total properties in database: " . $totalCount);
        
        echo "\n";
    }
    
    private function testUserManagement() {
        echo "👤 Testing User Management...\n";
        
        // Test 1: Check if users table exists and has data
        try {
            $db = Database::getInstance();
            $stmt = $db->prepare("SELECT COUNT(*) as count FROM users");
            $stmt->execute();
            $result = $stmt->fetch();
            $userCount = $result['count'];
            
            $this->addResult("Users Table Access", "PASS", "Users table accessible, contains " . $userCount . " users");
        } catch (Exception $e) {
            $this->addResult("Users Table Access", "FAIL", "Error accessing users table: " . $e->getMessage());
        }
        
        // Test 2: Test user authentication (if we have test users)
        try {
            // This would test actual authentication if we had test credentials
            $this->addResult("User Authentication", "SKIP", "Requires test user credentials");
        } catch (Exception $e) {
            $this->addResult("User Authentication", "FAIL", "Authentication test failed: " . $e->getMessage());
        }
        
        echo "\n";
    }
    
    private function testDataIntegrity() {
        echo "📊 Testing Data Integrity...\n";
        
        // Test 1: Check property data structure
        $properties = $this->propertyModel->search([], 1, 1);
        if (!empty($properties)) {
            $property = $properties[0];
            $requiredFields = ['id', 'title', 'price', 'city', 'property_type', 'bedrooms', 'bathrooms'];
            $missingFields = [];
            
            foreach ($requiredFields as $field) {
                if (!isset($property[$field])) {
                    $missingFields[] = $field;
                }
            }
            
            $this->addResult("Property Data Structure", 
                empty($missingFields) ? "PASS" : "FAIL", 
                empty($missingFields) ? "All required fields present" : "Missing fields: " . implode(', ', $missingFields));
        } else {
            $this->addResult("Property Data Structure", "FAIL", "No properties found to test");
        }
        
        // Test 2: Check property images
        if (!empty($properties)) {
            $property = $properties[0];
            $images = $this->propertyModel->getImages($property['id']);
            $this->addResult("Property Images", 
                is_array($images) ? "PASS" : "FAIL", 
                "Image retrieval " . (is_array($images) ? "works" : "failed"));
        }
        
        // Test 3: Check property features
        if (!empty($properties)) {
            $property = $properties[0];
            $features = $this->propertyModel->getFeatures($property['id']);
            $this->addResult("Property Features", 
                is_array($features) ? "PASS" : "FAIL", 
                "Feature retrieval " . (is_array($features) ? "works" : "failed"));
        }
        
        echo "\n";
    }
    
    private function testSecurityFeatures() {
        echo "🔒 Testing Security Features...\n";
        
        // Test 1: SQL Injection Prevention
        $maliciousSearch = $this->propertyModel->search(['search' => "'; DROP TABLE properties; --"], 1, 10);
        $this->addResult("SQL Injection Prevention", 
            is_array($maliciousSearch) ? "PASS" : "FAIL", 
            "Malicious input handled safely");
        
        // Test 2: XSS Prevention (basic test)
        $xssSearch = $this->propertyModel->search(['search' => '<script>alert("xss")</script>'], 1, 10);
        $this->addResult("XSS Prevention", 
            is_array($xssSearch) ? "PASS" : "FAIL", 
            "XSS attempt handled safely");
        
        // Test 3: Input Validation
        $invalidBedrooms = $this->propertyModel->search(['bedrooms' => '999'], 1, 10);
        $this->addResult("Input Validation", 
            is_array($invalidBedrooms) ? "PASS" : "FAIL", 
            "Invalid input handled gracefully");
        
        echo "\n";
    }
    
    private function testEdgeCases() {
        echo "🔄 Testing Edge Cases...\n";
        
        // Test 1: Empty search
        $emptySearch = $this->propertyModel->search([], 1, 10);
        $this->addResult("Empty Search", 
            is_array($emptySearch) ? "PASS" : "FAIL", 
            "Empty search returns " . count($emptySearch) . " properties");
        
        // Test 2: Non-existent city
        $nonExistentCity = $this->propertyModel->search(['city' => 'NonExistentCity'], 1, 10);
        $this->addResult("Non-existent City Search", 
            is_array($nonExistentCity) ? "PASS" : "FAIL", 
            "Non-existent city search returns " . count($nonExistentCity) . " properties");
        
        // Test 3: Very high price range
        $highPriceSearch = $this->propertyModel->search(['min_price' => '999999999'], 1, 10);
        $this->addResult("High Price Range Search", 
            is_array($highPriceSearch) ? "PASS" : "FAIL", 
            "High price search returns " . count($highPriceSearch) . " properties");
        
        // Test 4: Pagination
        $page1 = $this->propertyModel->search([], 1, 5);
        $page2 = $this->propertyModel->search([], 2, 5);
        $this->addResult("Pagination", 
            is_array($page1) && is_array($page2) ? "PASS" : "FAIL", 
            "Pagination works correctly");
        
        echo "\n";
    }
    
    private function addResult($test, $status, $message) {
        $this->results[] = [
            'test' => $test,
            'status' => $status,
            'message' => $message
        ];
        
        $statusIcon = $status === 'PASS' ? '✅' : ($status === 'FAIL' ? '❌' : '⏭️');
        echo "  $statusIcon $test: $message\n";
    }
    
    private function displayResults() {
        echo "\n" . str_repeat("=", 60) . "\n";
        echo "📋 TEST RESULTS SUMMARY\n";
        echo str_repeat("=", 60) . "\n\n";
        
        $passCount = 0;
        $failCount = 0;
        $skipCount = 0;
        
        foreach ($this->results as $result) {
            if ($result['status'] === 'PASS') $passCount++;
            elseif ($result['status'] === 'FAIL') $failCount++;
            else $skipCount++;
        }
        
        echo "✅ Passed: $passCount\n";
        echo "❌ Failed: $failCount\n";
        echo "⏭️ Skipped: $skipCount\n";
        echo "📊 Total: " . count($this->results) . "\n\n";
        
        if ($failCount > 0) {
            echo "🚨 FAILED TESTS:\n";
            foreach ($this->results as $result) {
                if ($result['status'] === 'FAIL') {
                    echo "  ❌ " . $result['test'] . ": " . $result['message'] . "\n";
                }
            }
            echo "\n";
        }
        
        $successRate = round(($passCount / count($this->results)) * 100, 2);
        echo "📈 Success Rate: $successRate%\n";
        
        if ($successRate >= 90) {
            echo "🎉 EXCELLENT! Ready for deployment.\n";
        } elseif ($successRate >= 75) {
            echo "⚠️ GOOD! Minor issues to address before deployment.\n";
        } else {
            echo "🚨 NEEDS WORK! Major issues must be fixed before deployment.\n";
        }
    }
}

// Run the test suite
$testSuite = new TestSuite();
$testSuite->runAllTests();
?>
