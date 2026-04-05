<?php

namespace CutMeShort\SDK\Tests\Api;

use PHPUnit\Framework\TestCase;
use CutMeShort\SDK\Api\TrackingApi;
use CutMeShort\SDK\Config\Configuration;
use CutMeShort\SDK\Models\LeadPayload;
use CutMeShort\SDK\Models\SalePayload;
use CutMeShort\SDK\Models\TrackResponse;

/**
 * TrackingApi Tests
 *
 * Tests for lead (/track/lead) and sale (/track/sale) tracking endpoints
 *
 * @package CutMeShort\SDK\Tests\Api
 */
class TrackingApiTest extends TestCase
{
    /**
     * @var TrackingApi
     */
    private $api;

    protected function setUp(): void
    {
        $config = new Configuration();
        $config->setAccessToken('test-token');
        $this->api = new TrackingApi(null, $config);
    }

    /**
     * Test lead payload creation and validation
     */
    public function testLeadPayloadCreation()
    {
        $payload = new LeadPayload();
        $payload->setClickId('test-click-123')
            ->setEventName('test_event')
            ->setCustomerExternalId('test-customer-456');

        $this->assertNotNull($payload);
        $this->assertEquals('test-click-123', $payload->getClickId());
        $this->assertEquals('test_event', $payload->getEventName());
        $this->assertEquals('test-customer-456', $payload->getCustomerExternalId());
    }

    /**
     * Test sale payload creation and validation
     */
    public function testSalePayloadCreation()
    {
        $payload = new SalePayload();
        $payload->setClickId('test-click-123')
            ->setEventName('test_sale')
            ->setAmount(99.99)
            ->setCurrency('USD')
            ->setInvoiceId('inv-001');

        $this->assertNotNull($payload);
        $this->assertEquals('test-click-123', $payload->getClickId());
        $this->assertEquals('test_sale', $payload->getEventName());
        $this->assertEquals(99.99, $payload->getAmount());
        $this->assertEquals('USD', $payload->getCurrency());
        $this->assertEquals('inv-001', $payload->getInvoiceId());
    }

    /**
     * Test lead payload with optional fields
     */
    public function testLeadPayloadWithOptionalFields()
    {
        $payload = new LeadPayload();
        $payload->setClickId('test-click-123')
            ->setEventName('signup')
            ->setCustomerEmail('test@example.com')
            ->setCustomerName('John Doe')
            ->setCustomerExternalId('cust-001');

        $this->assertEquals('test@example.com', $payload->getCustomerEmail());
        $this->assertEquals('John Doe', $payload->getCustomerName());
    }

    /**
     * Test sale payload validation
     */
    public function testSalePayloadWithMinimumFields()
    {
        $payload = new SalePayload();
        $payload->setClickId('test-click-123')
            ->setEventName('purchase')
            ->setAmount(50.00)
            ->setCurrency('USD');

        $this->assertTrue($payload->valid());
        $this->assertEquals(50.00, $payload->getAmount());
    }

    /**
     * Test API configuration
     */
    public function testApiConfiguration()
    {
        $config = $this->api->getConfig();
        $this->assertNotNull($config);
        $this->assertEquals('https://www.cutmeshort.com', $config->getHost());
    }

    /**
     * Test API has correct endpoint paths
     */
    public function testApiEndpointPaths()
    {
        // Test that API can be instantiated
        $this->assertNotNull($this->api);
        // Endpoints are: /track/lead and /track/sale
        // These are tested in integration tests
    }
}
