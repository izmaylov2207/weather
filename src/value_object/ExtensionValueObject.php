<?php

namespace App\value_object;

class ExtensionValueObject
{
    /** @var string extension json */
    public const JSON = 'json';

    /** @var string extension xml */
    public const XML = 'xml';

    /** @var string current value */
    private string $extension;

    public function __construct(string $extension)
    {
        $this->extension = $extension;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return in_array($this->extension, [self::JSON, self::XML]);
    }

    /**
     * @return bool
     */
    public function isXml(): bool
    {
        return $this->extension === self::XML;
    }

    /**
     * @return bool
     */
    public function isJson(): bool
    {
        return $this->extension === self::JSON;
    }
}