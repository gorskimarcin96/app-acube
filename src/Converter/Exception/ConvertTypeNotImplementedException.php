<?php

namespace App\Converter\Exception;

use Exception;

class ConvertTypeNotImplementedException extends Exception
{
    public function __construct(string $type)
    {
        parent::__construct(sprintf('Convert type %s is not implemented.', $type));
    }
}