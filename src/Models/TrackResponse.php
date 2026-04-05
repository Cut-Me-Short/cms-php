<?php

namespace CutMeShort\SDK\Models;

use ArrayAccess;
use CutMeShort\SDK\Core\ObjectSerializer;
use JsonSerializable;

/**
 * Track Response Model
 *
 * @package CutMeShort\SDK\Models
 */
class TrackResponse implements ModelInterface, ArrayAccess, JsonSerializable
{
    public const DISCRIMINATOR = null;

    protected static $openAPIModelName = 'TrackResponse';

    protected static $openAPITypes = [
        'status' => 'bool',
        'data' => 'string'
    ];

    protected static $openAPIFormats = [
        'status' => null,
        'data' => null
    ];

    protected static array $openAPINullables = [
        'status' => false,
        'data' => false
    ];

    protected array $openAPINullablesSetToNull = [];

    /**
     * @var bool
     */
    protected $status;

    /**
     * @var string
     */
    protected $data;

    public function __construct($data = null)
    {
        if (is_array($data)) {
            $this->unserialize($data);
        }
    }

    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    protected static function openAPINullables(): array
    {
        return self::$openAPINullables;
    }

    private function getOpenAPINullablesSetToNull(): array
    {
        return $this->openAPINullablesSetToNull;
    }

    public static function attributeMap()
    {
        return [
            'status' => 'status',
            'data' => 'data'
        ];
    }

    public static function setters()
    {
        return [
            'status' => 'setStatus',
            'data' => 'setData'
        ];
    }

    public static function getters()
    {
        return [
            'status' => 'getStatus',
            'data' => 'getData'
        ];
    }

    public function getModelName()
    {
        return self::$openAPIModelName;
    }

    public function setStatus(?bool $status)
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setData(?string $data)
    {
        $this->data = $data;
        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->{$offset});
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->{$offset};
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->{$offset} = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->{$offset});
    }

    public function jsonSerialize(): mixed
    {
        return ObjectSerializer::sanitizeForSerialization($this);
    }

    public function listInvalidProperties()
    {
        $invalidProperties = [];
        return $invalidProperties;
    }

    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }

    public static function isNullable(string $property): bool
    {
        return self::openAPINullables()[$property] ?? false;
    }

    public function isPropertyMapped(string $property): bool
    {
        return isset($this->{$property});
    }

    public function unserialize(array $data): void
    {
        foreach ($data as $property => $value) {
            if (isset(static::setters()[$property])) {
                $method = static::setters()[$property];
                $this->$method($value);
            }
        }
    }
}

