<?php

namespace CutMeShort\SDK\Models;

use ArrayAccess;
use CutMeShort\SDK\Core\ObjectSerializer;
use JsonSerializable;

/**
 * Lead Payload Model
 *
 * @package CutMeShort\SDK\Models
 */
class LeadPayload implements ModelInterface, ArrayAccess, JsonSerializable
{
    public const DISCRIMINATOR = null;

    protected static $openAPIModelName = 'LeadPayload';

    protected static $openAPITypes = [
        'click_id' => 'string',
        'event_name' => 'string',
        'customer_external_id' => 'string',
        'timestamp' => '\DateTime',
        'customer_name' => 'string',
        'customer_email' => 'string',
        'customer_avatar' => 'string',
        'mode' => 'string'
    ];

    protected static $openAPIFormats = [
        'click_id' => null,
        'event_name' => null,
        'customer_external_id' => null,
        'timestamp' => 'date-time',
        'customer_name' => null,
        'customer_email' => 'email',
        'customer_avatar' => 'uri',
        'mode' => null
    ];

    protected static array $openAPINullables = [
        'click_id' => false,
        'event_name' => false,
        'customer_external_id' => false,
        'timestamp' => false,
        'customer_name' => false,
        'customer_email' => false,
        'customer_avatar' => false,
        'mode' => false
    ];

    protected array $openAPINullablesSetToNull = [];

    /**
     * @var string
     */
    protected $click_id;

    /**
     * @var string
     */
    protected $event_name;

    /**
     * @var string
     */
    protected $customer_external_id;

    /**
     * @var \DateTime
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $customer_name;

    /**
     * @var string
     */
    protected $customer_email;

    /**
     * @var string
     */
    protected $customer_avatar;

    /**
     * @var string
     */
    protected $mode;

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
            'click_id' => 'clickId',
            'event_name' => 'eventName',
            'customer_external_id' => 'customerExternalId',
            'timestamp' => 'timestamp',
            'customer_name' => 'customerName',
            'customer_email' => 'customerEmail',
            'customer_avatar' => 'customerAvatar',
            'mode' => 'mode'
        ];
    }

    public static function setters()
    {
        return [
            'click_id' => 'setClickId',
            'event_name' => 'setEventName',
            'customer_external_id' => 'setCustomerExternalId',
            'timestamp' => 'setTimestamp',
            'customer_name' => 'setCustomerName',
            'customer_email' => 'setCustomerEmail',
            'customer_avatar' => 'setCustomerAvatar',
            'mode' => 'setMode'
        ];
    }

    public static function getters()
    {
        return [
            'click_id' => 'getClickId',
            'event_name' => 'getEventName',
            'customer_external_id' => 'getCustomerExternalId',
            'timestamp' => 'getTimestamp',
            'customer_name' => 'getCustomerName',
            'customer_email' => 'getCustomerEmail',
            'customer_avatar' => 'getCustomerAvatar',
            'mode' => 'getMode'
        ];
    }

    public function getModelName()
    {
        return self::$openAPIModelName;
    }

    public function setClickId(?string $click_id)
    {
        $this->click_id = $click_id;
        return $this;
    }

    public function getClickId(): ?string
    {
        return $this->click_id;
    }

    public function setEventName(?string $event_name)
    {
        $this->event_name = $event_name;
        return $this;
    }

    public function getEventName(): ?string
    {
        return $this->event_name;
    }

    public function setCustomerExternalId(?string $customer_external_id)
    {
        $this->customer_external_id = $customer_external_id;
        return $this;
    }

    public function getCustomerExternalId(): ?string
    {
        return $this->customer_external_id;
    }

    public function setTimestamp(?\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function getTimestamp(): ?\DateTime
    {
        return $this->timestamp;
    }

    public function setCustomerName(?string $customer_name)
    {
        $this->customer_name = $customer_name;
        return $this;
    }

    public function getCustomerName(): ?string
    {
        return $this->customer_name;
    }

    public function setCustomerEmail(?string $customer_email)
    {
        $this->customer_email = $customer_email;
        return $this;
    }

    public function getCustomerEmail(): ?string
    {
        return $this->customer_email;
    }

    public function setCustomerAvatar(?string $customer_avatar)
    {
        $this->customer_avatar = $customer_avatar;
        return $this;
    }

    public function getCustomerAvatar(): ?string
    {
        return $this->customer_avatar;
    }

    public function setMode(?string $mode)
    {
        $this->mode = $mode;
        return $this;
    }

    public function getMode(): ?string
    {
        return $this->mode;
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
