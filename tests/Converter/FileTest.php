<?php

namespace App\Tests\Converter;

use App\Converter\File;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Webmozart\Assert\InvalidArgumentException;

class FileTest extends KernelTestCase
{
    private File $file;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->file = self::$kernel->getContainer()->get(File::class);
    }

    public function testConvertJsonToXml()
    {
        $data = $this->file->convert(
            '{"name":"test","surname":"test2"}',
            'json',
            'xml'
        );

        $this->assertSame('<?xml version="1.0"?>
<response><name>test</name><surname>test2</surname></response>', trim($data));
    }

    public function testConvertXmlToJson()
    {
        $data = $this->file->convert(
            '<?xml version="1.0"?><response><name>test</name><surname>test2</surname></response>',
            'xml',
            'json'
        );

        $this->assertSame('{"name":"test","surname":"test2"}', $data);
    }

    public function testConvertJsonToJson()
    {
        $data = $this->file->convert(
            '{"name":"test","surname":"test2"}',
            'json',
            'json'
        );

        $this->assertSame('{"name":"test","surname":"test2"}', $data);
    }

    public function testConvertInvalidFromType()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('From type "test" is not valid.');

        $this->file->convert('', 'test', 'json');
    }

    public function testConvertInvalidToType()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('To type "test" is not valid.');

        $this->file->convert('', 'json', 'test');
    }
}
