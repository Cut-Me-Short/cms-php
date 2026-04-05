<?php
/**
 * TrackResponseTest
 *
 * PHP version 8.1
 *
 * @category Class
 * @package  CutMeShort\SDK\Tests\Model
 * @author   SDK Tests
 */

/**
 * TrackResponseTest
 *
 * Tests for TrackResponse model returned from /track/lead and /track/sale endpoints
 *
 * @category    Class
 * @description TrackResponse
 * @package     CutMeShort\SDK\Tests\Model
 * @author      SDK Tests
 */

namespace CutMeShort\SDK\Tests\Model;

use PHPUnit\Framework\TestCase;
use CutMeShort\SDK\Models\TrackResponse;

class TrackResponseTest extends TestCase
{
    /**
     * Test TrackResponse creation with success response
     */
    public function testTrackResponseSuccess()
    {
        $data = [
            'success' => true,
            'message' => 'Event tracked successfully'
        ];

        $response = new TrackResponse($data);
        $this->assertNotNull($response);
    }

    /**
     * Test attribute "success"
     */
    public function testPropertySuccess()
    {
        $data = [
            'success' => true,
            'click_id' => 'click-123',
            'customer_external_id' => 'cust-456'
        ];

        $response = new TrackResponse($data);
        $this->assertTrue($response->getSuccess());
    }

    /**
     * Test attribute "click_id"
     */
    public function testPropertyClickId()
    {
        $clickId = 'click-id-xyz';
        $data = [
            'success' => true,
            'click_id' => $clickId,
            'customer_external_id' => 'cust-123'
        ];

        $response = new TrackResponse($data);
        $this->assertEquals($clickId, $response->getClickId());
    }

    /**
     * Test successful lead tracking response
     */
    public function testLeadTrackingResponse()
    {
        $data = [
            'success' => true,
            'click_id' => 'lead-click-123',
            'customer_external_id' => 'lead-cust-456'
        ];

        $response = new TrackResponse($data);
        $this->assertTrue($response->getSuccess());
        $this->assertEquals('lead-click-123', $response->getClickId());
    }

    /**
     * Test successful sale tracking response
     */
    public function testSaleTrackingResponse()
    {
        $data = [
            'success' => true,
            'click_id' => 'sale-click-789',
            'customer_external_id' => 'sale-cust-999'
        ];

        $response = new TrackResponse($data);
        $this->assertTrue($response->getSuccess());
        $this->assertEquals('sale-cust-999', $response->getCustomerExternalId());
    }

    /**
     * Test response creation with different success values
     */
    public function testTrackResponseVariations()
    {
        $clickIds = [
            'click-001',
            'click-002',
            'click-003',
            'click-004'
        ];

        foreach ($clickIds as $clickId) {
            $data = [
                'success' => true,
                'click_id' => $clickId,
                'customer_external_id' => 'cust-' . $clickId
            ];
            $response = new TrackResponse($data);
            $this->assertTrue($response->getSuccess());
            $this->assertEquals($clickId, $response->getClickId());
        }
    }

}
