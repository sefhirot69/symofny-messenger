<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\AddPonkaToImage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class AddPonkaToImageHandler implements MessageHandlerInterface
{
    public function __invoke(AddPonkaToImage $addPonkaToImage)
    {
        dump($addPonkaToImage);
    }
}