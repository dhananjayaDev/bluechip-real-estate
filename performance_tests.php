<?php
/**
 * Performance Test Script
 * Tests application performance and optimization
 */

// Test configuration
define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');

require_once 'app/config/database.php';
require_once 'app/core/Database.php';
require_once 'app/core/Model.php';
require_once 'app/models/Property.php';
require_once 'app/models/User.php';

echo "⚡ PERFORMANCE TEST SUITE\n";
echo "=" . str_repeat("=", 35) . "\n\n";

class PerformanceTester {
    private $propertyModel;
    private $userModel;
    private $results = [];
    
    public function __construct() {
        $this->propertyModel = new Property();
        $this->userModel = new User();
    }
    
    public function runPerformanceTests() {
        $this->testDatabasePerformance();
        $this->testSearchPerformance();
        $this->testFileSystemPerformance();
        $this->testMemoryUsage();
        $this->displayResults();
    }
    
    private function testDatabasePerformance() {
        echo "🗄️ Testing Database Performance...\n";
        
        // Test 1: Simple query performance
        $start = microtime(true);
        $properties = $this->propertyModel->search([], 1, 10);
        $end = microtime(true);
        $queryTime = ($end - $start) * 1000; // Convert to milliseconds
        
        $this->addResult("Simple Query", $queryTime < 100 ? "PASS" : "SLOW", 
            sprintf("%.2f ms", $queryTime));
        
        // Test 2: Complex search performance
        $start = microtime(true);
        $complexSearch = $this->propertyModel->search([
            'city' => 'Colombo',
            'property_type' => 'apartment',
            'bedrooms' => '2',
            'min_price' => '1000000',
            'max_price' => '5000000'
        ], 1, 10);
        $end = microtime(true);
        $complexTime = ($end - $start) * 1000;
        
        $this->addResult("Complex Search", $complexTime < 200 ? "PASS" : "SLOW", 
            sprintf("%.2f ms", $complexTime));
        
        // Test 3: Count query performance
        $start = microtime(true);
        $count = $this->propertyModel->getCount();
        $end = microtime(true);
        $countTime = ($end - $start) * 1000;
        
        $this->addResult("Count Query", $countTime < 50 ? "PASS" : "SLOW", 
            sprintf("%.2f ms", $countTime));
        
        echo "\n";
    }
    
    private function testSearchPerformance() {
        echo "🔍 Testing Search Performance...\n";
        
        $searchTerms = ['modern', 'luxury', 'apartment', 'house', 'Colombo', 'Kandy'];
        $totalTime = 0;
        $searchCount = 0;
        
        foreach ($searchTerms as $term) {
            $start = microtime(true);
            $results = $this->propertyModel->search(['search' => $term], 1, 10);
            $end = microtime(true);
            
            $searchTime = ($end - $start) * 1000;
            $totalTime += $searchTime;
            $searchCount++;
            
            echo "  📊 Search '$term': " . sprintf("%.2f ms", $searchTime) . 
                 " (" . count($results) . " results)\n";
        }
        
        $avgTime = $totalTime / $searchCount;
        $this->addResult("Average Search Time", $avgTime < 100 ? "PASS" : "SLOW", 
            sprintf("%.2f ms", $avgTime));
        
        echo "\n";
    }
    
    private function testFileSystemPerformance() {
        echo "📁 Testing File System Performance...\n";
        
        // Test 1: File read performance
        $cssFile = 'public/css/style.css';
        if (file_exists($cssFile)) {
            $start = microtime(true);
            $content = file_get_contents($cssFile);
            $end = microtime(true);
            
            $readTime = ($end - $start) * 1000;
            $fileSize = strlen($content);
            
            $this->addResult("File Read Performance", $readTime < 10 ? "PASS" : "SLOW", 
                sprintf("%.2f ms (%d bytes)", $readTime, $fileSize));
        }
        
        // Test 2: Directory listing performance
        $start = microtime(true);
        $files = glob('app/**/*.php');
        $end = microtime(true);
        
        $listTime = ($end - $start) * 1000;
        $this->addResult("Directory Listing", $listTime < 50 ? "PASS" : "SLOW", 
            sprintf("%.2f ms (%d files)", $listTime, count($files)));
        
        // Test 3: File existence check performance
        $testFiles = [
            'index.php',
            'app/config/database.php',
            'app/core/Database.php',
            'public/css/style.css',
            'public/js/main.js'
        ];
        
        $start = microtime(true);
        foreach ($testFiles as $file) {
            file_exists($file);
        }
        $end = microtime(true);
        
        $existsTime = ($end - $start) * 1000;
        $this->addResult("File Existence Checks", $existsTime < 5 ? "PASS" : "SLOW", 
            sprintf("%.2f ms (%d files)", $existsTime, count($testFiles)));
        
        echo "\n";
    }
    
    private function testMemoryUsage() {
        echo "🧠 Testing Memory Usage...\n";
        
        $initialMemory = memory_get_usage(true);
        
        // Test 1: Load all properties
        $properties = $this->propertyModel->search([], 1, 100);
        $propertiesMemory = memory_get_usage(true) - $initialMemory;
        
        $this->addResult("Properties Memory Usage", $propertiesMemory < 1024*1024 ? "PASS" : "HIGH", 
            sprintf("%.2f KB", $propertiesMemory / 1024));
        
        // Test 2: Load with images
        $initialMemory = memory_get_usage(true);
        foreach (array_slice($properties, 0, 5) as $property) {
            $images = $this->propertyModel->getImages($property['id']);
            $features = $this->propertyModel->getFeatures($property['id']);
        }
        $imagesMemory = memory_get_usage(true) - $initialMemory;
        
        $this->addResult("Images & Features Memory", $imagesMemory < 512*1024 ? "PASS" : "HIGH", 
            sprintf("%.2f KB", $imagesMemory / 1024));
        
        // Test 3: Peak memory usage
        $peakMemory = memory_get_peak_usage(true);
        $this->addResult("Peak Memory Usage", $peakMemory < 8*1024*1024 ? "PASS" : "HIGH", 
            sprintf("%.2f MB", $peakMemory / (1024*1024)));
        
        echo "\n";
    }
    
    private function addResult($test, $status, $message) {
        $this->results[] = [
            'test' => $test,
            'status' => $status,
            'message' => $message
        ];
        
        $statusIcon = $status === 'PASS' ? '✅' : ($status === 'SLOW' ? '⚠️' : '❌');
        echo "  $statusIcon $test: $message\n";
    }
    
    private function displayResults() {
        echo "\n" . str_repeat("=", 50) . "\n";
        echo "📊 PERFORMANCE TEST SUMMARY\n";
        echo str_repeat("=", 50) . "\n\n";
        
        $passCount = 0;
        $slowCount = 0;
        $failCount = 0;
        
        foreach ($this->results as $result) {
            if ($result['status'] === 'PASS') $passCount++;
            elseif ($result['status'] === 'SLOW') $slowCount++;
            else $failCount++;
        }
        
        echo "✅ Passed: $passCount\n";
        echo "⚠️ Slow: $slowCount\n";
        echo "❌ Failed: $failCount\n";
        echo "📊 Total: " . count($this->results) . "\n\n";
        
        if ($slowCount > 0) {
            echo "⚠️ PERFORMANCE ISSUES:\n";
            foreach ($this->results as $result) {
                if ($result['status'] === 'SLOW') {
                    echo "  ⚠️ " . $result['test'] . ": " . $result['message'] . "\n";
                }
            }
            echo "\n";
        }
        
        $successRate = round(($passCount / count($this->results)) * 100, 2);
        echo "📈 Performance Score: $successRate%\n";
        
        if ($successRate >= 90) {
            echo "🎉 EXCELLENT! Application is well optimized.\n";
        } elseif ($successRate >= 75) {
            echo "⚠️ GOOD! Minor optimizations recommended.\n";
        } else {
            echo "🚨 NEEDS OPTIMIZATION! Performance improvements required.\n";
        }
        
        // Memory usage summary
        $currentMemory = memory_get_usage(true);
        $peakMemory = memory_get_peak_usage(true);
        echo "\n🧠 Memory Usage:\n";
        echo "  Current: " . sprintf("%.2f MB", $currentMemory / (1024*1024)) . "\n";
        echo "  Peak: " . sprintf("%.2f MB", $peakMemory / (1024*1024)) . "\n";
    }
}

// Run performance tests
$performanceTester = new PerformanceTester();
$performanceTester->runPerformanceTests();
?>
