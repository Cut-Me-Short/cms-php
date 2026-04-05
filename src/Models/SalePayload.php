<?php

namespace CutMeShort\SDK\Models;

use ArrayAccess;
use CutMeShort\SDK\Core\ObjectSerializer;
use JsonSerializable;

/**
 * Sale Payload Model
 *
 * @package CutMeShort\SDK\Models
 */
class SalePayload implements ModelInterface, ArrayAccess, JsonSerializable
{
    public const DISCRIMINATOR = null;

    protected static $openAPIModelName = 'SalePayload';

    protected static $openAPITypes = [
        'click_id' => 'string',
        'event_name' => 'string',
        'timestamp' => '\DateTime',
        'customer_external_id' => 'string',
        'customer_name' => 'string',
        'customer_email' => 'string',
        'customer_avatar' => 'string',
        'invoice_id' => 'string',
        'amount' => 'float',
        'currency' => 'string',
        'mode' => 'string'
    ];

    protected static $openAPIFormats = [
        'click_id' => null,
        'event_name' => null,
        'timestamp' => 'date-time',
        'customer_external_id' => null,
        'customer_name' => null,
        'customer_email' => 'email',
        'customer_avatar' => 'uri',
        'invoice_id' => null,
        'amount' => 'double',
        'currency' => null,
        'mode' => null
    ];

    protected static array $openAPINullables = [
        'click_id' => false,
        'event_name' => false,
        'timestamp' => false,
        'customer_external_id' => false,
        'customer_name' => false,
        'customer_email' => false,
        'customer_avatar' => false,
        'invoice_id' => false,
        'amount' => false,
        'currency' => false,
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
     * @var \DateTime
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $customer_external_id;

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
    protected $invoice_id;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @var string
     */
    protected $currency;

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
            'timestamp' => 'timestamp',
            'customer_external_id' => 'customerExternalId',
            'customer_name' => 'customerName',
            'customer_email' => 'customerEmail',
            'customer_avatar' => 'customerAvatar',
            'invoice_id' => 'invoiceId',
            'amount' => 'amount',
            'currency' => 'currency',
            'mode' => 'mode'
        ];
    }

    public static function setters()
    {
        return [
            'click_id' => 'setClickId',
            'event_name' => 'setEventName',
            'timestamp' => 'setTimestamp',
            'customer_external_id' => 'setCustomerExternalId',
            'customer_name' => 'setCustomerName',
            'customer_email' => 'setCustomerEmail',
            'customer_avatar' => 'setCustomerAvatar',
            'invoice_id' => 'setInvoiceId',
            'amount' => 'setAmount',
            'currency' => 'setCurrency',
            'mode' => 'setMode'
        ];
    }

    public static function getters()
    {
        return [
            'click_id' => 'getClickId',
            'event_name' => 'getEventName',
            'timestamp' => 'getTimestamp',
            'customer_external_id' => 'getCustomerExternalId',
            'customer_name' => 'getCustomerName',
            'customer_email' => 'getCustomerEmail',
            'customer_avatar' => 'getCustomerAvatar',
            'invoice_id' => 'getInvoiceId',
            'amount' => 'getAmount',
            'currency' => 'getCurrency',
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

    public function setTimestamp(?\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function getTimestamp(): ?\DateTime
    {
        return $this->timestamp;
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

    public function setInvoiceId(?string $invoice_id)
    {
        $this->invoice_id = $invoice_id;
        return $this;
    }

    public function getInvoiceId(): ?string
    {
        return $this->invoice_id;
    }

    public function setAmount(?float $amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setCurrency(?string $currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
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
