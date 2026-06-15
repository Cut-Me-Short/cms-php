<?php

require_once __DIR__ . '/../vendor/autoload.php';

use CutMeShort\SDK\Client;
use CutMeShort\SDK\Models\LeadPayload;
use CutMeShort\SDK\Models\SalePayload;

// Initialize client with configuration
$client = new Client();
$client->setAccessToken(your_api_token_here)
    ->setDebug(true); // Enable debug mode for detailed logging

$trackingApi = $client->getTrackingApi();
$config = $client->getConfig();

// Create and track a lead
$payload = new LeadPayload();
$payload->setClickId('8ea29346-1ef3-4dca-b472-1a1086998738')
    ->setMode('deferred') // Set mode to deferred for testing
    ->setEventName('signup')
    ->setCustomerExternalId('user_123')
    ->setCustomerName('Rohit Sharma')
    ->setCustomerEmail('rohit.sharma@mi.com');

try {
    $response = $trackingApi->trackLead($payload);
    
    if ($response->getStatus()) {
        echo "Lead Tracking successful!\n";
        echo "Message: " . $response->getData() . "\n";
    } else {
        echo "Lead Tracking failed\n";
        echo "Error: " . $response->getData() . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n---\n\n";

$leadPayload = new LeadPayload();
$leadPayload->setClickId('8ea29346-1ef3-4dca-b472-1a1086998738')
    ->setCustomerExternalId('user_123')
    ->setEventName('signup');

try {
    $response = $trackingApi->trackLead($leadPayload);
    if ($response->getStatus()) {
        echo "Lead Tracking successful with minimal payload!\n";
        echo "Message: " . $response->getData() . "\n";
    } else {
        echo "Lead Tracking failed with minimal payload\n";
        echo "Error: " . $response->getData() . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Create and track a sale
$salePayload = new SalePayload();
$salePayload->setClickId('8ea29346-1ef3-4dca-b472-1a1086998738')
    ->setMode('deferred') // Set mode to deferred for testing
    ->setEventName('purchase')
    ->setCustomerExternalId('user_123')
    ->setCustomerName('Rohit Sharma')
    ->setCustomerEmail('rohit.sharma@mi.com')
    ->setInvoiceId('INV-2024-001')
    ->setAmount(1299.99)
    ->setCurrency('INR');

try {
    $response = $trackingApi->trackSale($salePayload);
    
    if ($response->getStatus()) {
        echo "Sale Tracking successful!\n";
        echo "Message: " . $response->getData() . "\n";
    } else {
        echo "Sale Tracking failed\n";
        echo "Error: " . $response->getData() . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
