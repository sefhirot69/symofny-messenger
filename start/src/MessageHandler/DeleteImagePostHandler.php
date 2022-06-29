<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\DeleteImagePost;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class DeleteImagePostHandler implements MessageHandlerInterface
{

    private $entityManager;
    private $bus;


    public function __construct(MessageBusInterface $bus, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->bus = $bus;
    }

    public function __invoke(DeleteImagePost $deleteImagePost)
    {
        $imagePost = $deleteImagePost->getImagePost();

        $this->entityManager->remove($imagePost);
        $this->entityManager->flush();

//        $this->bus->dispatch(new DeletePhotoFile($imagePost->getFilename()));
    }
}