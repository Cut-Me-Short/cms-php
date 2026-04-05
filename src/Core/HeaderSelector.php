<?php

namespace CutMeShort\SDK\Core;

/**
 * HTTP header selector utility
 *
 * @package CutMeShort\SDK\Core
 */
class HeaderSelector
{
    /**
     * Select headers for HTTP request
     *
     * @param string[] $accept
     * @param string   $contentType
     * @param bool     $isMultipart
     * @return string[]
     */
    public function selectHeaders(array $accept, string $contentType, bool $isMultipart): array
    {
        $headers = [];

        $accept = $this->selectAcceptHeader($accept);
        if ($accept !== null) {
            $headers['Accept'] = $accept;
        }

        if (!$isMultipart) {
            if ($contentType === '') {
                $contentType = 'application/json';
            }

            $headers['Content-Type'] = $contentType;
        }

        return $headers;
    }

    /**
     * Return the header 'Accept' based on an array of Accept provided.
     *
     * @param string[] $accept Array of header
     *
     * @return null|string Accept (e.g. application/json)
     */
    private function selectAcceptHeader(array $accept): ?string
    {
        $accept = array_filter($accept);

        if (count($accept) === 0) {
            return null;
        }

        if (count($accept) === 1) {
            return reset($accept);
        }

        $headersWithJson = $this->selectJsonMimeList($accept);
        if (count($headersWithJson) === 0) {
            return implode(',', $accept);
        }

        return $this->getAcceptHeaderWithAdjustedWeight($accept, $headersWithJson);
    }

    /**
     * Detects whether a string contains a valid JSON mime type
     *
     * @param string[] $mimeTypes
     *
     * @return string[]
     */
    private function selectJsonMimeList(array $mimeTypes): array
    {
        $jsonMimes = [
            'application/json',
            'application/hal+json',
            'application/ld+json',
            'application/vnd.api+json',
            'application/problem+json',
        ];

        return array_values(array_intersect($mimeTypes, $jsonMimes));
    }

    /**
     * Add weight to Accept header for proper preference order
     *
     * @param string[] $accept array of mime types
     * @param string[] $jsonHeaders array of json preferred mime types
     *
     * @return string
     */
    private function getAcceptHeaderWithAdjustedWeight(array $accept, array $jsonHeaders): string
    {
        $weight = 1.0;
        $output = [];

        foreach ($accept as $mime) {
            if (in_array($mime, $jsonHeaders, true)) {
                $output[] = $mime;
            } else {
                $output[] = $mime . ';q=' . number_format($weight, 2);
                $weight -= 0.01;
            }
        }

        return implode(',', $output);
    }
}
