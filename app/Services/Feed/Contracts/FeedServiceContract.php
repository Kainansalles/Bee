<?php

namespace App\Services\Feed\Contracts;

interface FeedServiceContract
{
    /**
     * @param array $data
     * @return mixed
     */
    public function createMessage(array $data);

    /**
     * @param array $filters
     */
    public function feed(array $filters = []);
}
