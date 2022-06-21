<?php

declare(strict_types=1);

namespace App\Message;

final class AddPonkaToImage
{
    private $imagePostId;

    /**
     * @param int $imagePostId
     */
    public function __construct(int $imagePostId)
    {
        $this->imagePostId = $imagePostId;
    }

    public function getImagePostId(): int
    {
        return $this->imagePostId;
    }

}