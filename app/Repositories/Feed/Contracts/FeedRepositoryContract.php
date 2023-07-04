<?php

namespace App\Repositories\Feed\Contracts;

use App\Models\Feed;

interface FeedRepositoryContract
{
    /**
     * @param array $data
     * @return mixed
     */
    public function createMessage(array $data): Feed;

    /**
     * @param array $filters
     * @return mixed
     */
    public function getMessages(array $filters);
}
