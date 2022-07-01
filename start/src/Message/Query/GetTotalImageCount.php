<?php

declare(strict_types=1);

namespace App\Message\Query;

final class GetTotalImageCount
{
    private $test;

    /**
     * @param $test
     */
    public function __construct($test = null)
    {
        $this->test = $test;
    }

    /**
     * @return mixed
     */
    public function getTest()
    {
        return $this->test;
    }

}