<?php

namespace App\Tests\MessageHandler;

use App\DBAL\Types\StatusType;
use App\Message\ConvertFile;
use App\MessageHandler\ConvertFileHandler;
use App\Repository\ConvertFileRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ConvertFileHandlerTest extends KernelTestCase
{
    private ConvertFileHandler $convertFileHandler;
    private ConvertFileRepository $convertFileRepository;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->convertFileHandler = self::$kernel->getContainer()->get(ConvertFileHandler::class);
        $this->convertFileRepository = self::$kernel->getContainer()->get(ConvertFileRepository::class);
    }

    public function testInvoke()
    {
        $convertFile = $this->convertFileRepository->create('{"test": "test"}', 'json', 'xml');
        $convertFileHandler = $this->convertFileHandler;
        $convertFileHandler(new ConvertFile($convertFile->getId()), false);

        $this->assertSame(StatusType::DONE, $convertFile->getStatus());
        $this->assertNotEmpty($convertFile->getContentTo());
    }
}
