<?php

require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client as GuzzleClient;

echo "🔍 Capturing Raw API Response\n";
echo "═════════════════════════════════════\n\n";

// Use raw Guzzle to see actual response
$guzzleClient = new GuzzleClient();

$payload = json_encode([
    'clickId' => '642ea388-fdcc-4d4e-b513-de641744000f',
    'eventName' => 'signup',
    'customerExternalId' => 'user_001',
    'customerName' => 'John Smith',
    'customerEmail' => 'john.smith@example.com'
]);

echo "📤 Request Payload:\n";
echo $payload . "\n\n";

try {
    $response = $guzzleClient->post('http://localhost:5000/track/lead', [
        'headers' => [
            'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VySWQiOiI2OTg3NTZiZGU3NTExNmU3YWMzZjVlNGQiLCJlbWFpbCI6InZpZ25lc2hyZWRkeTc5M0BnbWFpbC5jb20iLCJpYXQiOjE3NzMyMzI5ODUsImV4cCI6MTc4MTAwODk4NX0.22naMhoaQ19TkcB61kmvsXYj1kXEUrnCWoJvt-e55Pc',
            'Content-Type' => 'application/json'
        ],
        'body' => $payload
    ]);
    
    $rawBody = (string)$response->getBody();
    
    echo "📥 Raw Response Body:\n";
    echo $rawBody . "\n\n";
    
    echo "📊 Parsed Response:\n";
    $parsed = json_decode($rawBody, true);
    echo json_encode($parsed, JSON_PRETTY_PRINT) . "\n\n";
    
    echo "🔑 Response Keys:\n";
    if (is_array($parsed)) {
        foreach (array_keys($parsed) as $key) {
            echo "  - " . $key . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
