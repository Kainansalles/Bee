<?php

namespace App\Services\Feed\Contracts;

use App\Models\Feed;

interface FeedServiceContract
{
    /**
     * @param array $data
     * @return mixed
     */
    public function createMessage(array $data): Feed;

    /**
     * @param array $filters
     */
    public function feed(array $filters = []);
}
