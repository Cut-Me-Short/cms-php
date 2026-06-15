# CutMeShort PHP SDK

Official PHP SDK for the CutMeShort CMS platform.

A SDK for tracking leads and sales events, including support for deferred lead attribution.

## Features

- 🚀 **Easy to use** - Simple, intuitive API
- ✅ **Type-safe** - Leverages PHP 8.1+ features with proper typing
- 📊 **Lead & Sales Tracking** - Built-in support for both event types
- 🔄 **Deferred Attribution** - Support for first-click to customer association
- 🔐 **Bearer Token Authentication** - Secure API authentication
- ⚙️ **Configurable** - Flexible configuration options for different environments
- 📝 **Well-documented** - Comprehensive examples and documentation

## Requirements

- PHP 8.1 or higher
- Composer (for dependency management)
- GuzzleHTTP 7.3+ (automatically installed via Composer)

## Installation

### Using Composer

```bash
composer require cutmeshort/sdk
```

Or add to your `composer.json`:

```json
{
  "require": {
    "cutmeshort/sdk": "^1.0"
  }
}
```

Then run:
```bash
composer install
```

## Quick Start

### Basic Usage

```php
<?php
require_once 'vendor/autoload.php';

use CutMeShort\SDK\Client;
use CutMeShort\SDK\Models\LeadPayload;

// Initialize the SDK
$client = new Client(
    accessToken: 'your-api-token',
    host: 'https://www.cutmeshort.com'
);

// Track a lead
$leadPayload = new LeadPayload();
$leadPayload->setClickId('click_123456')
    ->setEventName('form_submission')
    ->setCustomerExternalId('customer_789')
    ->setCustomerName('John Doe')
    ->setCustomerEmail('john@example.com')
    ->setTimestamp(new DateTime());

$response = $client->getTrackingApi()->trackLead($leadPayload);

echo "Lead tracked: " . ($response->getSuccess() ? 'Success' : 'Failed') . "\n";
```

### Track a Sale

```php
use CutMeShort\SDK\Models\SalePayload;

$salePayload = new SalePayload();
$salePayload->setClickId('click_123456')
    ->setEventName('purchase')
    ->setCustomerExternalId('customer_789')
    ->setInvoiceId('inv_001')
    ->setAmount(99.99)
    ->setCurrency('USD')
    ->setTimestamp(new DateTime());

$response = $client->getTrackingApi()->trackSale($salePayload);
```

## Configuration

### Basic Configuration

```php
$client = new Client();
$client->setAccessToken('your-bearer-token')
    ->setHost('https://api.cutmeshort.com');
```

### Advanced Configuration

```php
$config = $client->getConfig();

// Set custom headers
$config->setUserAgent('MyApp/1.0.0');

// API key authentication (if needed)
$config->setApiKey('X-API-Key', 'your-api-key');

// Enable debug mode
$client->setDebug(true);

// Custom certificate for mTLS
$config->setCertFile('/path/to/cert.pem');
$config->setKeyFile('/path/to/key.pem');
```

## Models

### LeadPayload

Track lead generation events:

```php
$payload = new LeadPayload();
$payload->setClickId('click_id')              // Required: Click identifier
    ->setEventName('signup')                   // Required: Event name
    ->setCustomerExternalId('customer_id')     // Customer ID from your system
    ->setCustomerName('John Doe')              // Customer name
    ->setCustomerEmail('john@example.com')     // Customer email
    ->setCustomerAvatar('https://...')         // Avatar URL
    ->setTimestamp(new DateTime())             // Event timestamp
    ->setMode('deferred');                     // Optional: 'deferred' for first attribution
```

### SalePayload

Track purchase/sale events:

```php
$payload = new SalePayload();
$payload->setClickId('click_id')              // Required
    ->setEventName('purchase')                 // Required
    ->setCustomerExternalId('customer_id')
    ->setCustomerName('John Doe')
    ->setCustomerEmail('john@example.com')
    ->setCustomerAvatar('https://...')
    ->setInvoiceId('inv_001')                  // Invoice identifier
    ->setAmount(99.99)                         // Sale amount
    ->setCurrency('USD')                       // Currency code
    ->setTimestamp(new DateTime());
```

## Error Handling

The SDK throws `SdkException` for API errors:

```php
use CutMeShort\SDK\Exceptions\SdkException;

try {
    $response = $client->getTrackingApi()->trackLead($payload);
} catch (SdkException $e) {
    echo "API Error: " . $e->getMessage() . "\n";
    echo "Status Code: " . $e->getCode() . "\n";
    
    if ($e->getResponseObject()) {
        // Access error response object
        $errorResponse = $e->getResponseObject();
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
```

## Deferred Lead Attribution

For tracking first clicks and associating them with customers later:

```php
// Step 1: Track initial lead with deferred mode
$leadPayload = new LeadPayload();
$leadPayload->setClickId('click_deferred_123')
    ->setCustomerExternalId('customer_789')
    ->setEventName('initial_lead')
    ->setMode('deferred');

$client->getTrackingApi()->trackLead($leadPayload);

// Step 2: Send subsequent lead events (backend will resolve association)
$followupPayload = new LeadPayload();
$followupPayload->setClickId('click_deferred_123')
    ->setCustomerExternalId('customer_789')
    ->setEventName('conversion');

$client->getTrackingApi()->trackLead($followupPayload);
```

## Examples

See the `examples/` directory for complete usage examples:

- `advanced_config.php` - Advanced configuration options

## Development

### Code Standards

The SDK follows PSR-12 code standards. Format code with:
