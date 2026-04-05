<?php

namespace CutMeShort\SDK\Core;

use ArrayAccess;
use DateTime;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\StreamInterface;
use SplFileObject;
use CutMeShort\SDK\Models\ModelInterface;

/**
 * Form data processor for multipart uploads and form submissions
 *
 * @package CutMeShort\SDK\Core
 */
class FormDataProcessor
{
    /**
     * Tags whether payload contains SplFileObject or stream values
     */
    public bool $has_file = false;

    /**
     * Prepare form data for submission
     *
     * @param array<string|bool|array|DateTime|ArrayAccess|SplFileObject> $values the value of the form parameter
     *
     * @return array [key => value] of formdata
     */
    public function prepare(array $values): array
    {
        $this->has_file = false;
        $result = [];

        foreach ($values as $k => $v) {
            if ($v === null) {
                continue;
            }

            $result[$k] = $this->makeFormSafe($v);
        }

        return $result;
    }

    /**
     * Flattens a multi-level array of data for formdata submission
     */
    public static function flatten(array $source, string $start = ''): array
    {
        $opt = [
            'prefix'          => '[',
            'suffix'          => ']',
            'suffix-end'      => true,
            'prefix-list'     => '[',
            'suffix-list'     => ']',
            'suffix-list-end' => true,
        ];

        if ($start === '') {
            $currentPrefix    = '';
            $currentSuffix    = '';
            $currentSuffixEnd = false;
        } elseif (array_is_list($source)) {
            $currentPrefix    = $start . $opt['prefix-list'];
            $currentSuffix    = $opt['suffix-list'];
            $currentSuffixEnd = $opt['suffix-list-end'];
        } else {
            $currentPrefix    = $start . $opt['prefix'];
            $currentSuffix    = $opt['suffix'];
            $currentSuffixEnd = $opt['suffix-end'];
        }

        $output = [];

        foreach ($source as $key => $value) {
            if ($currentSuffixEnd) {
                $newKey = $currentPrefix . $key . $currentSuffix;
            } else {
                $newKey = $currentPrefix . $key;
            }

            if (is_array($value)) {
                $flatten = self::flatten($value, $newKey);
                $output   = array_merge($output, $flatten);
                continue;
            }
            $output[$newKey] = $value;
        }

        return $output;
    }

    /**
     * Make value form safe
     */
    private function makeFormSafe($value): mixed
    {
        if ($value instanceof DateTime) {
            return $value->format('Y-m-d\TH:i:sP');
        }

        if ($value instanceof ArrayAccess) {
            return $this->makeFormSafe($value->getArrayCopy());
        }

        if ($value instanceof ModelInterface) {
            return ObjectSerializer::sanitizeForSerialization($value);
        }

        if (is_array($value)) {
            $safeSubs = [];
            foreach ($value as $k => $v) {
                $safeSubs[$k] = $this->makeFormSafe($v);
            }
            return $safeSubs;
        }

        if ($value instanceof SplFileObject || is_resource($value)) {
            $this->has_file = true;
            return Utils::tryFopen($value, 'r');
        }

        return $value;
    }
}
