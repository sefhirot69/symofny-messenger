<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\DeleteImagePost;
use App\Message\Event\ImagePostDeletedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class DeleteImagePostHandler implements MessageHandlerInterface
{

    private $entityManager;
    private $eventBus;


    public function __construct(MessageBusInterface $eventBus, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->eventBus = $eventBus;
    }

    public function __invoke(DeleteImagePost $deleteImagePost)
    {
        $imagePost = $deleteImagePost->getImagePost();

        $this->entityManager->remove($imagePost);
        $this->entityManager->flush();

        $this->eventBus->dispatch(new ImagePostDeletedEvent($imagePost->getFilename()));
    }
}