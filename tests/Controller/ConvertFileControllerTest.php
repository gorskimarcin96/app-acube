<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ConvertFileControllerTest extends WebTestCase
{
    public function testCreate()
    {
        $client = static::createClient();

        $uploadedFile = new UploadedFile(__dir__ . '/test.json', 'test.json', null, null, true);
        $client->request('POST', '/api/convert/file/create/json/xml', [], ['file' => $uploadedFile]);
        $this->assertResponseStatusCodeSame(201);
    }

    public function testCreateFileNotFound()
    {
        $client = static::createClient();

        $uploadedFile = new UploadedFile(__dir__ . '/test.json', 'test.json', null, null, true);
        $client->request('POST', '/api/convert/file/create/json/test', [], ['file' => $uploadedFile]);
        $this->assertResponseStatusCodeSame(400);
    }

    public function testCreateInvalidArgumentException()
    {
        $client = static::createClient();

        $uploadedFile = new UploadedFile(__dir__ . '/test.json', 'test.json', null, null, true);
        $client->request('POST', '/api/convert/file/create/json/test', [], ['file' => $uploadedFile]);
        $this->assertResponseStatusCodeSame(400);
    }

    public function testFind()
    {
        $client = static::createClient();

        $client->request('GET', '/api/convert/file/get/1');
        $this->assertResponseStatusCodeSame(200);
    }
}
