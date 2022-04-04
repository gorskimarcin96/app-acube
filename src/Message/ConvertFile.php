<?php

namespace App\Message;

final class ConvertFile
{
    public function __construct(private int $id)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
