<?php

namespace CutMeShort\SDK\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use CutMeShort\SDK\Config\Configuration;
use CutMeShort\SDK\Core\HeaderSelector;
use CutMeShort\SDK\Core\ObjectSerializer;
use CutMeShort\SDK\Exceptions\SdkException;
use CutMeShort\SDK\Models\LeadPayload;
use CutMeShort\SDK\Models\SalePayload;
use CutMeShort\SDK\Models\TrackResponse;
use CutMeShort\SDK\Models\ErrorResponse;

/**
 * Tracking API for CutMeShort SDK
 * 
 * Handles lead and sale tracking events
 *
 * @package CutMeShort\SDK\Api
 */
class TrackingApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    /**
     * @var int Host index
     */
    protected $hostIndex;

    /**
     * Content types for each endpoint
     */
    public const CONTENT_TYPES = [
        'trackLead' => ['application/json'],
        'trackSale' => ['application/json'],
    ];

    /**
     * Constructor
     *
     * @param ClientInterface $client HTTP client
     * @param Configuration   $config Configuration
     * @param HeaderSelector  $selector Header selector
     * @param int             $hostIndex Host index
     */
    public function __construct(
        ?ClientInterface $client = null,
        ?Configuration $config = null,
        ?HeaderSelector $selector = null,
        int $hostIndex = 0
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: Configuration::getDefaultConfiguration();
        $this->headerSelector = $selector ?: new HeaderSelector();
        $this->hostIndex = $hostIndex;
    }

    /**
     * Set the host index
     *
     * @param int $hostIndex Host index
     */
    public function setHostIndex($hostIndex): void
    {
        $this->hostIndex = $hostIndex;
    }

    /**
     * Get the host index
     *
     * @return int Host index
     */
    public function getHostIndex()
    {
        return $this->hostIndex;
    }

    /**
     * Get the configuration
     *
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Track a lead event
     *
     * @param LeadPayload $leadPayload Lead payload
     * @param string $contentType Content type header value
     *
     * @return TrackResponse|ErrorResponse
     * @throws SdkException
     */
    public function trackLead($leadPayload, string $contentType = 'application/json')
    {
        [$response] = $this->trackLeadWithHttpInfo($leadPayload, $contentType);
        return $response;
    }

    /**
     * Track a lead event with HTTP info
     *
     * @param LeadPayload $leadPayload Lead payload
     * @param string $contentType Content type header value
     *
     * @return array [response, statusCode, headers]
     * @throws SdkException
     */
    public function trackLeadWithHttpInfo($leadPayload, string $contentType = 'application/json')
    {
        $request = $this->trackLeadRequest($leadPayload, $contentType);

        try {
            $response = $this->client->send($request, $this->createHttpClientOption());
            return $this->handleResponse($response, TrackResponse::class);
        } catch (RequestException $e) {
            throw $this->handleException($e);
        } catch (ConnectException $e) {
            throw new SdkException(
                "[{$e->getCode()}] {$e->getMessage()}",
                (int) $e->getCode(),
                null,
                null
            );
        }
    }

    /**
     * Track a sale event
     *
     * @param SalePayload $salePayload Sale payload
     * @param string $contentType Content type header value
     *
     * @return TrackResponse|ErrorResponse
     * @throws SdkException
     */
    public function trackSale($salePayload, string $contentType = 'application/json')
    {
        [$response] = $this->trackSaleWithHttpInfo($salePayload, $contentType);
        return $response;
    }

    /**
     * Track a sale event with HTTP info
     *
     * @param SalePayload $salePayload Sale payload
     * @param string $contentType Content type header value
     *
     * @return array [response, statusCode, headers]
     * @throws SdkException
     */
    public function trackSaleWithHttpInfo($salePayload, string $contentType = 'application/json')
    {
        $request = $this->trackSaleRequest($salePayload, $contentType);

        try {
            $response = $this->client->send($request, $this->createHttpClientOption());
            return $this->handleResponse($response, TrackResponse::class);
        } catch (RequestException $e) {
            throw $this->handleException($e);
        } catch (ConnectException $e) {
            throw new SdkException(
                "[{$e->getCode()}] {$e->getMessage()}",
                (int) $e->getCode(),
                null,
                null
            );
        }
    }

    /**
     * Create request for track lead operation
     *
     * @param LeadPayload $leadPayload Lead payload
     * @param string $contentType Content type header value
     *
     * @return Request
     * @throws \InvalidArgumentException
     */
    protected function trackLeadRequest($leadPayload, string $contentType = 'application/json'): Request
    {
        // Validate required parameter
        if ($leadPayload === null) {
            throw new \InvalidArgumentException('Lead payload is required');
        }

        $resourcePath = '/track/lead';
        $queryParams = [];
        $headerParams = [];

        $headers = $this->headerSelector->selectHeaders(['application/json'], $contentType, false);

        // JSON encode the body
        $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($leadPayload));

        // Add Bearer token if configured
        if (!empty($this->config->getAccessToken())) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        // Add default headers
        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge($defaultHeaders, $headerParams, $headers);

        $query = ObjectSerializer::buildQuery($queryParams);
        $uri = $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : '');

        return new Request('POST', $uri, $headers, $httpBody);
    }

    /**
     * Create request for track sale operation
     *
     * @param SalePayload $salePayload Sale payload
     * @param string $contentType Content type header value
     *
     * @return Request
     * @throws \InvalidArgumentException
     */
    protected function trackSaleRequest($salePayload, string $contentType = 'application/json'): Request
    {
        // Validate required parameter
        if ($salePayload === null) {
            throw new \InvalidArgumentException('Sale payload is required');
        }

        $resourcePath = '/track/sale';
        $queryParams = [];
        $headerParams = [];

        $headers = $this->headerSelector->selectHeaders(['application/json'], $contentType, false);

        // JSON encode the body
        $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($salePayload));

        // Add Bearer token if configured
        if (!empty($this->config->getAccessToken())) {
            $headers['Authorization'] = 'Bearer ' . $this->config->getAccessToken();
        }

        // Add default headers
        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge($defaultHeaders, $headerParams, $headers);

        $query = ObjectSerializer::buildQuery($queryParams);
        $uri = $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : '');

        return new Request('POST', $uri, $headers, $httpBody);
    }

    /**
     * Handle HTTP response
     *
     * @param ResponseInterface $response API response
     * @param string $returnType Expected return type
     *
     * @return array [deserialized response, status code, headers]
     * @throws SdkException
     */
    protected function handleResponse(ResponseInterface $response, string $returnType): array
    {
        $statusCode = $response->getStatusCode();
        $headers = $response->getHeaders();
        $body = (string) $response->getBody();

        try {
            if ($statusCode >= 200 && $statusCode < 300) {
                // Success response
                if ($returnType === 'string') {
                    return [$body, $statusCode, $headers];
                }

                $decodedBody = json_decode($body, true);
                $deserialized = new $returnType($decodedBody);
                return [$deserialized, $statusCode, $headers];
            } else {
                // Error response
                $decodedBody = json_decode($body, true);
                $errorResponse = new ErrorResponse($decodedBody);

                $exception = new SdkException(
                    sprintf('[%d] API Error', $statusCode),
                    $statusCode,
                    $headers,
                    $body
                );
                $exception->setResponseObject($errorResponse);
                throw $exception;
            }
        } catch (SdkException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new SdkException(
                'Error deserializing response: ' . $e->getMessage(),
                $statusCode,
                $headers,
                $body
            );
        }
    }

    /**
     * Handle request exceptions
     *
     * @param RequestException $e Request exception
     *
     * @return SdkException
     */
    protected function handleException(RequestException $e): SdkException
    {
        $response = $e->getResponse();
        $statusCode = $response ? $response->getStatusCode() : 0;
        $headers = $response ? $response->getHeaders() : null;
        $body = $response ? (string) $response->getBody() : null;

        return new SdkException(
            "[{$statusCode}] {$e->getMessage()}",
            $statusCode,
            $headers,
            $body
        );
    }

    /**
     * Create HTTP client options
     *
     * @return array
     */
    protected function createHttpClientOption(): array
    {
        $options = [];

        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        if ($this->config->getCertFile()) {
            $options[RequestOptions::CERT] = $this->config->getCertFile();
        }

        if ($this->config->getKeyFile()) {
            $options[RequestOptions::SSL_KEY] = $this->config->getKeyFile();
        }

        return $options;
    }
}
