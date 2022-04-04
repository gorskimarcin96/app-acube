<?php

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class FileType extends AbstractEnumType
{
    public const JSON = 'json';
    public const XML = 'xml';

    protected static array $choices = [
        self::JSON => self::JSON,
        self::XML => self::XML,
    ];
}
