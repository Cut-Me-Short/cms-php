<?php

namespace CutMeShort\SDK\Core;

use GuzzleHttp\Psr7\Utils;
use CutMeShort\SDK\Models\ModelInterface;

/**
 * Object serialization/deserialization utility class
 *
 * @package CutMeShort\SDK\Core
 */
class ObjectSerializer
{
    /**
     * @var string
     */
    private static $dateTimeFormat = \DateTime::ATOM;

    /**
     * Change the date format
     *
     * @param string $format the new date format to use
     */
    public static function setDateTimeFormat($format)
    {
        self::$dateTimeFormat = $format;
    }

    /**
     * Serialize data
     *
     * @param mixed  $data   the data to serialize
     * @param string|null $type   the type of the data
     * @param string|null $format the format of the type of the data
     *
     * @return scalar|object|array|null serialized form of $data
     */
    public static function sanitizeForSerialization($data, $type = null, $format = null)
    {
        if (is_scalar($data) || null === $data) {
            return $data;
        }

        if ($data instanceof \DateTime) {
            return ($format === 'date') ? $data->format('Y-m-d') : $data->format(self::$dateTimeFormat);
        }

        if (is_array($data)) {
            foreach ($data as $property => $value) {
                $data[$property] = self::sanitizeForSerialization($value);
            }
            return $data;
        }

        if (is_object($data)) {
            $values = [];
            if ($data instanceof ModelInterface) {
                $formats = $data::openAPIFormats();
                foreach ($data::openAPITypes() as $property => $openAPIType) {
                    $getter = $data::getters()[$property];
                    $value = $data->$getter();
                    if ($value !== null && !in_array($openAPIType, ['\DateTime', '\SplFileObject', 'array', 'bool', 'boolean', 'byte', 'float', 'int', 'integer', 'mixed', 'number', 'object', 'string', 'void'], true)) {
                        $callable = [$openAPIType, 'getAllowableEnumValues'];
                        if (is_callable($callable)) {
                            $allowedEnumTypes = $callable();
                            if (!in_array($value, $allowedEnumTypes, true)) {
                                $imploded = implode("', '", $allowedEnumTypes);
                                throw new \InvalidArgumentException("Invalid value for enum '$openAPIType', must be one of: '$imploded'");
                            }
                        }
                    }
                    if ($value !== null) {
                        $values[$data::attributeMap()[$property]] = self::sanitizeForSerialization($value, $openAPIType, $formats[$property]);
                    }
                }
            } else {
                foreach ($data as $property => $value) {
                    $values[$property] = self::sanitizeForSerialization($value);
                }
            }
            return (object)$values;
        }

        return '';
    }

    /**
     * Sanitize filename by removing path.
     * e.g. ../../sun.gif becomes sun.gif
     *
     * @param string $filename Filename from Content-Disposition header
     *
     * @return string Sanitized filename
     */
    public static function sanitizeFilename($filename)
    {
        if (preg_match("/filename=['\"]?([^'\"\\r\\n]+)['\"]?$/", $filename, $match)) {
            $filename = trim($match[1]);
        }
        return str_replace('..', '', $filename);
    }

    /**
     * Builds a query string
     *
     * @param array  $params Parameters to send
     * @param string $format Allowed value: csv, ssv, tsv, pipes
     *
     * @return string HTTP build query
     */
    public static function buildQuery($params, $format = null)
    {
        if (is_null($format)) {
            return http_build_query($params);
        }
        $separator = ',';
        switch ($format) {
            case 'ssv':
                $separator = ' ';
                break;
            case 'tsv':
                $separator = "\t";
                break;
            case 'pipes':
                $separator = '|';
                break;
        }
        $encoded_params = [];
        foreach ($params as $k => $v) {
            if ($v instanceof \DateTime) {
                $encoded_params[$k] = $v->format(\DateTime::RFC3339);
            } elseif (is_array($v)) {
                foreach ($v as $value) {
                    $value instanceof \DateTime
                        ? $encoded_params[] = urlencode($k) . '=' . urlencode($value->format(\DateTime::RFC3339))
                        : $encoded_params[] = urlencode($k) . '=' . urlencode($value);
                }
                continue;
            }

            $encoded_params[$k] = urlencode($k) . '=' . urlencode($v);
        }

        return implode('&', $encoded_params);
    }

    /**
     * Deserialize data from a JSON response
     *
     * @param mixed   $data                 Data from the response
     * @param string  $class                Class name is passed as a string
     * @param array   $httpHeaders          HTTP headers
     *
     * @return mixed Deserialized data
     */
    public static function deserialize($data, $class, $httpHeaders = null)
    {
        if ($data === null) {
            return null;
        }

        if (substr($class, 0, 4) === 'map[') {
            preg_match('/map\[([^\]]+)\]/', $class, $matches);
            $innerClass = $matches[1];
            $data = json_decode($data);
            if ($data === null) {
                return null;
            }
            $deserialized = [];
            if (is_object($data)) {
                foreach ($data as $property => $value) {
                    $deserialized[$property] = self::deserialize($value, $innerClass);
                }
            }
            return $deserialized;
        }

        if (strpos($class, 'array<') === 0) {
            preg_match('/array<(.*)>/', $class, $matches);
            foreach (json_decode($data) as $item) {
                $sub_class = $matches[1];
                $deserialized[] = self::deserialize($item, $sub_class);
            }
            return $deserialized;
        }

        if ($class === 'object') {
            $data = json_decode($data);
            if ($data === null) {
                return null;
            }
            return (object)$data;
        }

        if (strpos($class, 'int') === 0 || $class === 'boolean') {
            settype($data, $class);
            return $data;
        }

        if ($class === '\DateTime') {
            return new \DateTime($data);
        } else if ($class === '\SplFileObject') {
            return $data;
        } else if (in_array($class, ['string', 'int', '',  'float', 'bool', 'object'], true)) {
            settype($data, $class);
            return $data;
        } else if (preg_match('/^\\\\?[a-zA-Z0-9_]+\\\\[a-zA-Z0-9_]+/', $class)) {
            $data = json_decode($data);
            if ($httpHeaders) {
                $headers = array_combine(array_map('strtolower', array_keys($httpHeaders)), array_values($httpHeaders));
            } else {
                $headers = null;
            }
            return self::$class($data, $httpHeaders);
        } else {
            return json_decode($data);
        }
    }

    /**
     * From a PHP \DateTime, convert the value to a string suitable for inclusion in
     * RFC3339 Date and Time
     *
     * @param \DateTime $date the datetime value
     * @param bool      $childJsonSerializationFormat
     *
     * @return string the formatted date and time value as string
     */
    public static function toDateTime($date, $childJsonSerializationFormat = false)
    {
        if ($date instanceof \DateTime) {
            return $date->format(\DateTime::RFC3339);
        } else if (is_int($date)) {
            return gmdate('Y-m-d\TH:i:s\Z', $date);
        } else if (preg_match('/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})(|Z|([+-]\d{2}:\d{2}))$/', $date)) {
            return $date;
        } else if (strtotime($date) !== false) {
            return gmdate('Y-m-d\TH:i:s\Z', intval(strtotime($date)));
        }
        return null;
    }

    /**
     * From a string to boolean type
     *
     * @param mixed $data the value of the string
     *
     * @return bool the boolean value of the string
     */
    public static function toBoolean($data)
    {
        if ($data === 'true' || $data === '1' || $data === 1 || $data === true) {
            return true;
        } elseif ($data === 'false' || $data === '0' || $data === 0 || $data === false) {
            return false;
        } else {
            return null; // let the default value be used
        }
    }
}
