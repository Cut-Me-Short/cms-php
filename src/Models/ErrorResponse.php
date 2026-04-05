<?php

namespace CutMeShort\SDK\Models;

use ArrayAccess;
use CutMeShort\SDK\Core\ObjectSerializer;
use JsonSerializable;

/**
 * Error Response Model
 *
 * @package CutMeShort\SDK\Models
 */
class ErrorResponse implements ModelInterface, ArrayAccess, JsonSerializable
{
    public const DISCRIMINATOR = null;

    protected static $openAPIModelName = 'ErrorResponse';

    protected static $openAPITypes = [
        'error' => 'string',
        'code' => 'int',
        'message' => 'string'
    ];

    protected static $openAPIFormats = [
        'error' => null,
        'code' => 'int32',
        'message' => null
    ];

    protected static array $openAPINullables = [
        'error' => false,
        'code' => false,
        'message' => false
    ];

    protected array $openAPINullablesSetToNull = [];

    /**
     * @var string
     */
    protected $error;

    /**
     * @var int
     */
    protected $code;

    /**
     * @var string
     */
    protected $message;

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
            'error' => 'error',
            'code' => 'code',
            'message' => 'message'
        ];
    }

    public static function setters()
    {
        return [
            'error' => 'setError',
            'code' => 'setCode',
            'message' => 'setMessage'
        ];
    }

    public static function getters()
    {
        return [
            'error' => 'getError',
            'code' => 'getCode',
            'message' => 'getMessage'
        ];
    }

    public function getModelName()
    {
        return self::$openAPIModelName;
    }

    public function setError(?string $error)
    {
        $this->error = $error;
        return $this;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function setCode(?int $code)
    {
        $this->code = $code;
        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setMessage(?string $message)
    {
        $this->message = $message;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
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
