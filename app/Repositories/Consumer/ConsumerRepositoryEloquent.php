<?php

namespace App\Repositories\Consumer;

use App\Models\Consumer;
use App\Repositories\BaseRepository;
use App\Repositories\Consumer\Contracts\ConsumerRepositoryContract;

class ConsumerRepositoryEloquent extends BaseRepository implements ConsumerRepositoryContract
{
    /**
     * @var Consumer
     */
    protected $model;

    /**
     * @param Consumer $consumer
     */
    public function __construct(Consumer $consumer)
    {
        $this->model = $consumer;
    }
}
