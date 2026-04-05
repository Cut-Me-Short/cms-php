<?php

namespace CutMeShort\SDK;

use CutMeShort\SDK\Api\TrackingApi;
use CutMeShort\SDK\Config\Configuration;

/**
 * CutMeShort SDK Client
 * 
 * Main entry point for using the CutMeShort SDK
 *
 * @package CutMeShort\SDK
 */
class Client
{
    /**
     * SDK version
     */
    public const VERSION = '1.0.0';

    /**
     * @var Configuration
     */
    private $config;

    /**
     * @var TrackingApi
     */
    private $trackingApi;

    /**
     * Constructor
     *
     * @param string|null $accessToken API access token (Bearer token)
     * @param string|null $host API host URL
     */
    public function __construct(?string $accessToken = null, ?string $host = null)
    {
        $this->config = new Configuration();

        if ($host !== null) {
            $this->config->setHost($host);
        }

        if ($accessToken !== null) {
            $this->config->setAccessToken($accessToken);
        }

        $this->trackingApi = new TrackingApi(null, $this->config);
    }

    /**
     * Get the configuration
     *
     * @return Configuration
     */
    public function getConfig(): Configuration
    {
        return $this->config;
    }

    /**
     * Get the tracking API
     *
     * @return TrackingApi
     */
    public function getTrackingApi(): TrackingApi
    {
        return $this->trackingApi;
    }

    /**
     * Set the API access token
     *
     * @param string $token Bearer token
     *
     * @return $this
     */
    public function setAccessToken(string $token): self
    {
        $this->config->setAccessToken($token);
        return $this;
    }

    /**
     * Set the API host
     *
     * @param string $host API host URL
     *
     * @return $this
     */
    public function setHost(string $host): self
    {
        $this->config->setHost($host);
        return $this;
    }

    /**
     * Enable debug mode
     *
     * @param bool $debug Enable or disable debug
     *
     * @return $this
     */
    public function setDebug(bool $debug = true): self
    {
        $this->config->setDebug($debug);
        return $this;
    }

    /**
     * Get SDK version
     *
     * @return string
     */
    public static function getVersion(): string
    {
        return self::VERSION;
    }
}
