<?php

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class StatusType extends AbstractEnumType
{
    public const DRAFT = 'draft';
    public const PENDING = 'pending';
    public const DONE = 'done';

    protected static array $choices = [
        self::DRAFT => self::DRAFT,
        self::PENDING => self::PENDING,
        self::DONE => self::DONE,
    ];
}
