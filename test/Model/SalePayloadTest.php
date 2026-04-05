<?php
/**
 * SalePayloadTest
 *
 * PHP version 8.1
 *
 * @category Class
 * @package  CutMeShort\SDK\Tests\Model
 * @author   SDK Tests
 */

/**
 * SalePayloadTest
 *
 * Tests for SalePayload model used in /track/sale endpoint
 *
 * @category    Class
 * @description SalePayload
 * @package     CutMeShort\SDK\Tests\Model
 * @author      SDK Tests
 */

namespace CutMeShort\SDK\Tests\Model;

use PHPUnit\Framework\TestCase;
use CutMeShort\SDK\Models\SalePayload;

class SalePayloadTest extends TestCase
{
    /**
     * Test SalePayload creation with required fields
     */
    public function testSalePayloadWithRequiredFields()
    {
        $payload = new SalePayload();
        $payload->setClickId('sale-click-123')
            ->setEventName('purchase')
            ->setAmount(99.99)
            ->setCurrency('USD');

        $this->assertEquals('sale-click-123', $payload->getClickId());
        $this->assertEquals('purchase', $payload->getEventName());
        $this->assertEquals(99.99, $payload->getAmount());
        $this->assertEquals('USD', $payload->getCurrency());
    }

    /**
     * Test attribute "click_id"
     */
    public function testPropertyClickId()
    {
        $payload = new SalePayload();
        $clickId = 'click-id-99999';
        $payload->setClickId($clickId);

        $this->assertEquals($clickId, $payload->getClickId());
    }

    /**
     * Test attribute "event_name"
     */
    public function testPropertyEventName()
    {
        $payload = new SalePayload();
        $eventName = 'purchase';
        $payload->setEventName($eventName);

        $this->assertEquals($eventName, $payload->getEventName());
    }

    /**
     * Test sale payload with amount and currency
     */
    public function testSalePayloadAmount()
    {
        $payload = new SalePayload();
        $amount = 149.99;
        $payload->setAmount($amount);

        $this->assertEquals($amount, $payload->getAmount());
    }

    /**
     * Test sale payload with all optional fields
     */
    public function testSalePayloadWithAllFields()
    {
        $payload = new SalePayload();
        $payload->setClickId('sale-click-123')
            ->setEventName('purchase')
            ->setAmount(199.99)
            ->setCurrency('EUR')
            ->setInvoiceId('INV-2024-001')
            ->setCustomerEmail('buyer@example.com')
            ->setCustomerExternalId('cust-buyer-001');

        $this->assertEquals('sale-click-123', $payload->getClickId());
        $this->assertEquals('purchase', $payload->getEventName());
        $this->assertEquals(199.99, $payload->getAmount());
        $this->assertEquals('EUR', $payload->getCurrency());
        $this->assertEquals('INV-2024-001', $payload->getInvoiceId());
        $this->assertEquals('buyer@example.com', $payload->getCustomerEmail());
        $this->assertEquals('cust-buyer-001', $payload->getCustomerExternalId());
    }

    /**
     * Test sale payload fluent interface
     */
    public function testSalePayloadFluentInterface()
    {
        $payload = (new SalePayload())
            ->setClickId('sale-123')
            ->setEventName('conversion')
            ->setAmount(75.50)
            ->setCurrency('USD')
            ->setInvoiceId('INV-2024-999');

        $this->assertEquals('sale-123', $payload->getClickId());
        $this->assertEquals('conversion', $payload->getEventName());
        $this->assertEquals(75.50, $payload->getAmount());
        $this->assertEquals('USD', $payload->getCurrency());
        $this->assertEquals('INV-2024-999', $payload->getInvoiceId());
    }

    /**
     * Test
     * Test attribute "timestamp"
     */
    public function testPropertyTimestamp()
    {
        // TODO: implement
        self::markTestIncomplete('Not implemented');
    }

    /**
     * Test attribute "customer_external_id"
     */
    public function testPropertyCustomerExternalId()
    {
        // TODO: implement
        self::markTestIncomplete('Not implemented');
    }

    /**
     * Test attribute "customer_name"
     */
    public function testPropertyCustomerName()
    {
        // TODO: implement
        self::markTestIncomplete('Not implemented');
    }

    /**
     * Test attribute "customer_email"
     */
    public function testPropertyCustomerEmail()
    {
        // TODO: implement
        self::markTestIncomplete('Not implemented');
    }

    /**
     * Test attribute "customer_avatar"
     */
    public function testPropertyCustomerAvatar()
    {
        // TODO: implement
        self::markTestIncomplete('Not implemented');
    }

    /**
     * Test attribute "invoice_id"
     */
    public function testPropertyInvoiceId()
    {
        // TODO: implement
        self::markTestIncomplete('Not implemented');
    }

    /**
     * Test attribute "amount"
     */
    public function testPropertyAmount()
    {
        // TODO: implement
        self::markTestIncomplete('Not implemented');
    }

    /**
     * Test attribute "currency"
     */
    public function testPropertyCurrency()
    {
        // TODO: implement
        self::markTestIncomplete('Not implemented');
    }
}
