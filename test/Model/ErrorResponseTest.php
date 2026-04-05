<?php
/**
 * ErrorResponseTest
 *
 * PHP version 8.1
 *
 * @category Class
 * @package  CutMeShort\SDK\Tests\Model
 * @author   SDK Tests
 */

/**
 * ErrorResponseTest
 *
 * Tests for ErrorResponse model used in error handling
 *
 * @category    Class
 * @description ErrorResponse
 * @package     CutMeShort\SDK\Tests\Model
 * @author      SDK Tests
 */

namespace CutMeShort\SDK\Tests\Model;

use PHPUnit\Framework\TestCase;
use CutMeShort\SDK\Models\ErrorResponse;

class ErrorResponseTest extends TestCase
{
    /**
     * Test ErrorResponse object creation
     */
    public function testErrorResponseCreation()
    {
        $data = [
            'success' => false,
            'error' => 'Invalid request'
        ];

        $errorResponse = new ErrorResponse($data);
        $this->assertNotNull($errorResponse);
    }

    /**
     * Test "error" property
     */
    public function testPropertyError()
    {
        $errorMessage = 'Invalid click ID';
        $data = [
            'error' => $errorMessage,
            'code' => 400,
            'message' => 'Bad request'
        ];

        $errorResponse = new ErrorResponse($data);
        $this->assertEquals($errorMessage, $errorResponse->getError());
        $this->assertEquals(400, $errorResponse->getCode());
    }

    /**
     * Test error response message property
     */
    public function testPropertyMessage()
    {
        $message = 'Request validation failed';
        $data = [
            'error' => 'validation_error',
            'code' => 422,
            'message' => $message
        ];

        $errorResponse = new ErrorResponse($data);
        $this->assertEquals($message, $errorResponse->getMessage());
    }

    /**
     * Test error response with various error messages
     */
    public function testErrorResponseVariations()
    {
        $errors = [
            'Invalid request',
            'Missing required field',
            'Unauthorized access',
            'Rate limit exceeded'
        ];

        foreach ($errors as $error) {
            $data = [
                'success' => false,
                'error' => $error
            ];
            $errorResponse = new ErrorResponse($data);
            $this->assertNotNull($errorResponse);
        }
    }

    /**
     * Test
     * Test attribute "type"
     */
    public function testPropertyType()
    {
        // TODO: implement
        self::markTestIncomplete('Not implemented');
    }

    /**
     * Test attribute "status_code"
     */
    public function testPropertyStatusCode()
    {
        // TODO: implement
        self::markTestIncomplete('Not implemented');
    }

    /**
     * Test attribute "details"
     */
    public function testPropertyDetails()
    {
        // TODO: implement
        self::markTestIncomplete('Not implemented');
    }
}
