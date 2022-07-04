<?php

declare(strict_types=1);

namespace App\MessageHandler\Command;

use App\Message\Command\DeleteImagePost;
use App\Message\Event\ImagePostDeletedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class DeleteImagePostHandler implements MessageSubscriberInterface
{

    private $entityManager;
    private $eventBus;
    /**
     * @var LoggerInterface
     */
    private $logger;


    public function __construct(MessageBusInterface $eventBus, EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->eventBus = $eventBus;
        $this->logger = $logger;
    }

    public function __invoke(DeleteImagePost $deleteImagePost)
    {
        $imagePost = $deleteImagePost->getImagePost();
        $filename = $imagePost->getFilename();

        $this->entityManager->remove($imagePost);
        $this->entityManager->flush();

        $this->eventBus->dispatch(new ImagePostDeletedEvent($filename));
    }

    public static function getHandledMessages(): iterable
    {
        yield DeleteImagePost::class => [
            'method' => '__invoke',
            'priority' => 10,
        ];
    }
}