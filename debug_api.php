<?php

require_once __DIR__ . '/vendor/autoload.php';

use CutMeShort\SDK\Client;
use CutMeShort\SDK\Models\LeadPayload;

// Initialize client
$client = new Client();
$client->setAccessToken('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VySWQiOiI2OTg3NTZiZGU3NTExNmU3YWMzZjVlNGQiLCJlbWFpbCI6InZpZ25lc2hyZWRkeTc5M0BnbWFpbC5jb20iLCJpYXQiOjE3NzMyMzI5ODUsImV4cCI6MTc4MTAwODk4NX0.22naMhoaQ19TkcB61kmvsXYj1kXEUrnCWoJvt-e55Pc')
    ->setHost('http://localhost:5000');

$trackingApi = $client->getTrackingApi();

echo "🔍 Debugging API Response Structure\n";
echo "═════════════════════════════════════\n\n";

// Create lead payload
$payload = new LeadPayload();
$payload->setClickId('642ea388-fdcc-4d4e-b513-de641744000f')
    ->setEventName('signup')
    ->setCustomerExternalId('user_001')
    ->setCustomerName('John Smith')
    ->setCustomerEmail('john.smith@example.com');

try {
    $response = $trackingApi->trackLead($payload);
    
    echo "✅ Response Received\n";
    echo "─────────────────────────────────────\n";
    
    // Display all response properties
    echo "Response Object Type: " . get_class($response) . "\n\n";
    
    echo "📊 Response Data:\n";
    echo "  - Success: " . var_export($response->getSuccess(), true) . "\n";
    echo "  - ClickId: " . var_export($response->getClickId(), true) . "\n";
    echo "  - CustomerExternalId: " . var_export($response->getCustomerExternalId(), true) . "\n";
    
    echo "\n🔧 Raw JSON Representation:\n";
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
    
    echo "\n📋 All Available Properties:\n";
    foreach ((array)$response as $key => $value) {
        echo "  - " . trim($key, "\0*") . ": " . var_export($value, true) . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\nError Details:\n";
    echo json_decode($e->getMessage(), true) ? json_encode(json_decode($e->getMessage(), true), JSON_PRETTY_PRINT) : $e->getMessage();
}
