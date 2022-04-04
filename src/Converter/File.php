<?php

namespace App\Converter;

use App\Converter\Exception\ConvertTypeNotImplementedException;
use App\DBAL\Types\FileType;
use Symfony\Component\Serializer\SerializerInterface;
use Webmozart\Assert\Assert;

class File
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function convert(string $content, string $from, string $to): string
    {
        Assert::inArray($from, FileType::getValues(), sprintf('From type "%s" is not valid.', $from));
        Assert::inArray($to, FileType::getValues(), sprintf('To type "%s" is not valid.', $to));

        $content = match ($from) {
            'json' => json_decode($content, true),
            'xml' => json_decode(json_encode(simplexml_load_string($content)), true),
            default => throw new ConvertTypeNotImplementedException($from),
        };

        return $this->serializer->serialize($content, $to);
    }
}