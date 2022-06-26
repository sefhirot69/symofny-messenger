<?php

namespace App\Tests\Controller;

use App\Controller\ImagePostController;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Messenger\Transport\InMemoryTransport;

class ImagePostControllerTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }


    /**
     * @test
     */
    public function itShouldCreate(): void
    {
        $uploadedFile = new UploadedFile(
            __DIR__.'/../fixtures/test.png',
            'test.png'
        );

        $this->client->request(
            'POST',
            '/api/images',
            [],
            [
                'file' => $uploadedFile
            ]
        );

        self::assertResponseIsSuccessful();

        /** @var InMemoryTransport $transport */
        $transport = self::$container->get('messenger.transport.async_priority_high');
        self::assertCount(1, $transport->get());

    }
}
