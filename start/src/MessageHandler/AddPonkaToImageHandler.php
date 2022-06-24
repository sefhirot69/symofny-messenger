<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\ImagePost;
use App\Message\AddPonkaToImage;
use App\Message\DeleteImagePost;
use App\Photo\PhotoFileManager;
use App\Photo\PhotoPonkaficator;
use App\Repository\ImagePostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use RuntimeException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class AddPonkaToImageHandler implements MessageHandlerInterface, LoggerAwareInterface
{

    use LoggerAwareTrait;

    private $ponkaficator;
    private $photoManager;
    private $entityManager;
    private $imagePostRepository;

    public function __construct(
        PhotoPonkaficator $ponkaficator,
        PhotoFileManager $photoManager,
        EntityManagerInterface $entityManager,
        ImagePostRepository $imagePostRepository
    ) {
        $this->ponkaficator = $ponkaficator;
        $this->photoManager = $photoManager;
        $this->entityManager = $entityManager;
        $this->imagePostRepository = $imagePostRepository;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(AddPonkaToImage $addPonkaToImage)
    {
        /*
         * Start Ponkafication!
         */
        $imagePostId = $addPonkaToImage->getImagePostId();
        $imagePost = $this->imagePostRepository->find($imagePostId);

        if (null === $imagePost) {
            $errorMessage = sprintf('ImagePost By id %s not found', $imagePostId);
            $this->logger->error($errorMessage);
            throw new RuntimeException($errorMessage);
        }

        if (random_int(0, 10) < 7) {
            throw new \RuntimeException('I Failed randomly!!!');
        }

        $filename = $imagePost->getFilename();

        $updatedContents = $this->ponkaficator->ponkafy(
            $this->photoManager->read($filename)
        );
        $this->photoManager->update($filename, $updatedContents);
        $imagePost->markAsPonkaAdded();
        $this->entityManager->persist($imagePost);
        $this->entityManager->flush();
        /*
         * You've been Ponkafied!
         */
    }
}