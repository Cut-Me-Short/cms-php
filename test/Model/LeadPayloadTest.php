<?php
/**
 * LeadPayloadTest
 *
 * PHP version 8.1
 *
 * @category Class
 * @package  CutMeShort\SDK\Tests\Model
 * @author   SDK Tests
 */

/**
 * LeadPayloadTest
 *
 * Tests for LeadPayload model used in /track/lead endpoint
 *
 * @category    Class
 * @description LeadPayload
 * @package     CutMeShort\SDK\Tests\Model
 * @author      SDK Tests
 */

namespace CutMeShort\SDK\Tests\Model;

use PHPUnit\Framework\TestCase;
use CutMeShort\SDK\Models\LeadPayload;

class LeadPayloadTest extends TestCase
{
    /**
     * Test LeadPayload creation with required fields
     */
    public function testLeadPayloadWithRequiredFields()
    {
        $payload = new LeadPayload();
        $payload->setClickId('test-click-123')
            ->setEventName('signup');

        $this->assertEquals('test-click-123', $payload->getClickId());
        $this->assertEquals('signup', $payload->getEventName());
    }

    /**
     * Test attribute "click_id"
     */
    public function testPropertyClickId()
    {
        $payload = new LeadPayload();
        $clickId = 'click-id-12345';
        $payload->setClickId($clickId);

        $this->assertEquals($clickId, $payload->getClickId());
    }

    /**
     * Test attribute "event_name"
     */
    public function testPropertyEventName()
    {
        $payload = new LeadPayload();
        $eventName = 'signup';
        $payload->setEventName($eventName);

        $this->assertEquals($eventName, $payload->getEventName());
    }

    /**
     * Test lead payload with all optional fields
     */
    public function testLeadPayloadWithAllFields()
    {
        $payload = new LeadPayload();
        $payload->setClickId('test-click-123')
            ->setEventName('signup')
            ->setCustomerEmail('test@example.com')
            ->setCustomerAvatar('https://example.com/avatar.jpg')
            ->setCustomerExternalId('cust-001')
            ->setCustomerName('John Doe');

        $this->assertEquals('test@example.com', $payload->getCustomerEmail());
        $this->assertEquals('https://example.com/avatar.jpg', $payload->getCustomerAvatar());
        $this->assertEquals('cust-001', $payload->getCustomerExternalId());
        $this->assertEquals('John Doe', $payload->getCustomerName());
    }

    /**
     * Test lead payload fluent interface
     */
    public function testLeadPayloadFluentInterface()
    {
        $payload = (new LeadPayload())
            ->setClickId('test-123')
            ->setEventName('purchase')
            ->setCustomerEmail('user@example.com');

        $this->assertEquals('test-123', $payload->getClickId());
        $this->assertEquals('purchase', $payload->getEventName());
        $this->assertEquals('user@example.com', $payload->getCustomerEmail());
    }

    /**
     * Test
     * Test attribute "customer_external_id"
     */
    public function testPropertyCustomerExternalId()
    {
        // TODO: implement
        self::markTestIncomplete('Not implemented');
    }

    /**
     * Test attribute "timestamp"
     */
    public function testPropertyTimestamp()
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
     * Test attribute "mode"
     */
    public function testPropertyMode()
    {
        // TODO: implement
        self::markTestIncomplete('Not implemented');
    }
}
