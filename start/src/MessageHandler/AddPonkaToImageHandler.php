<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AddPonkaToImage;
use App\Message\DeleteImagePost;
use App\Photo\PhotoFileManager;
use App\Photo\PhotoPonkaficator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class AddPonkaToImageHandler implements MessageHandlerInterface
{

    /**
     * @var PhotoPonkaficator
     */
    private $ponkaficator;
    /**
     * @var PhotoFileManager
     */
    private $photoManager;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        PhotoPonkaficator $ponkaficator,
        PhotoFileManager $photoManager,
        EntityManagerInterface $entityManager
    ) {
        $this->ponkaficator = $ponkaficator;
        $this->photoManager = $photoManager;
        $this->entityManager = $entityManager;
    }

    public function __invoke(AddPonkaToImage $addPonkaToImage)
    {
        /*
         * Start Ponkafication!
         */
        $imagePost = $addPonkaToImage->getImagePost();
        $filename = $imagePost->getFilename();

        $updatedContents = $this->ponkaficator->ponkafy(
            $this->photoManager->read($filename)
        );
        $this->photoManager->update($filename, $updatedContents);
        $imagePost->markAsPonkaAdded();
        $this->entityManager->flush();
        /*
         * You've been Ponkafied!
         */
    }
}