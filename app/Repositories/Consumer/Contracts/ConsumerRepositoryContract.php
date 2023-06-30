<?php

namespace App\Repositories\Consumer\Contracts;

interface ConsumerRepositoryContract
{
    /**
     * @param array $data
     * @return mixed
     */
    public function createMessage(array $data);
}
