<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\DeleteImagePost;
use App\Photo\PhotoFileManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class DeleteImagePostHandler implements MessageHandlerInterface
{

    private $entityManager;
    private $photoManager;

    public function __construct(PhotoFileManager $photoManager, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->photoManager = $photoManager;
    }

    public function __invoke(DeleteImagePost $deleteImagePost)
    {
        $imagePost = $deleteImagePost->getImagePost();

        $this->photoManager->deleteImage($imagePost->getFilename());

        $this->entityManager->remove($imagePost);
        $this->entityManager->flush();
    }
}