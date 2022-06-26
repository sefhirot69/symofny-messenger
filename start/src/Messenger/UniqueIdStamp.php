<?php

declare(strict_types=1);

namespace App\Messenger;

use Symfony\Component\Messenger\Stamp\StampInterface;

final class UniqueIdStamp implements StampInterface
{
    private $uniqueid;

    public function __construct() {
        $this->uniqueid = uniqid('', true);
    }

    /**
     * @return string
     */
    public function getUniqueid(): string
    {
        return $this->uniqueid;
    }


}