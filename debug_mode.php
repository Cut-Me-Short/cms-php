<?php

require_once __DIR__ . '/vendor/autoload.php';

use CutMeShort\SDK\Models\LeadPayload;
use CutMeShort\SDK\Core\ObjectSerializer;

// Create payload with deferred mode
$payload = new LeadPayload();
$payload->setClickId('642ea388-fdcc-4d4e-b513-de641744000f')
    ->setMode('deferred')
    ->setEventName('signup')
    ->setCustomerExternalId('user_001')
    ->setCustomerName('John Smith')
    ->setCustomerEmail('john.smith@example.com');

echo "🔍 LeadPayload Object:\n";
echo "  Mode value: " . ($payload->getMode() ?? 'NULL') . "\n";

echo "\n📋 Serialized for API:\n";
$serialized = ObjectSerializer::sanitizeForSerialization($payload);
echo json_encode($serialized, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";

echo "\n🔑 Checking attributeMap:\n";
$map = LeadPayload::attributeMap();
echo "  mode maps to: " . $map['mode'] . "\n";

echo "\n📤 Sending to API...\n";
$client = new \GuzzleHttp\Client();
$response = $client->post('http://localhost:5000/track/lead', [
    'headers' => [
        'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VySWQiOiI2OTg3NTZiZGU3NTExNmU3YWMzZjVlNGQiLCJlbWFpbCI6InZpZ25lc2hyZWRkeTc5M0BnbWFpbC5jb20iLCJpYXQiOjE3NzMyMzI5ODUsImV4cCI6MTc4MTAwODk4NX0.22naMhoaQ19TkcB61kmvsXYj1kXEUrnCWoJvt-e55Pc',
        'Content-Type' => 'application/json'
    ],
    'body' => json_encode($serialized)
]);

echo "Status: " . $response->getStatusCode() . "\n";
$body = json_decode($response->getBody(), true);
echo "Response: " . json_encode($body, JSON_PRETTY_PRINT) . "\n";
