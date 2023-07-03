<?php

namespace App\Repositories\Feed\Contracts;

interface FeedRepositoryContract
{
    /**
     * @param array $data
     * @return mixed
     */
    public function createMessage(array $data);

    /**
     * @param array $filters
     * @return mixed
     */
    public function getMessages(array $filters);
}
