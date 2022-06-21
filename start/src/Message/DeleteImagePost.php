<?php

declare(strict_types=1);

namespace App\Message;

use App\Entity\ImagePost;

final class DeleteImagePost
{
    /**
     * @var ImagePost
     */
    private $imagePost;

    /**
     * @param ImagePost $imagePost
     */
    public function __construct(ImagePost $imagePost)
    {
        $this->imagePost = $imagePost;
    }

    /**
     * @return ImagePost
     */
    public function getImagePost(): ImagePost
    {
        return $this->imagePost;
    }


}