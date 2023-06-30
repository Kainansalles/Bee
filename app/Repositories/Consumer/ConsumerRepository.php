<?php

namespace App\Repositories\Consumer;

use App\Models\ConsumerFeedMessage;
use App\Repositories\BaseRepository;
use App\Repositories\Consumer\Contracts\ConsumerRepositoryContract;

class ConsumerRepository extends BaseRepository implements ConsumerRepositoryContract
{
    /**
     * @var ConsumerFeedMessage
     */
    protected $model;

    /**
     * @param ConsumerFeedMessage $consumerFeedMessage
     */
    public function __construct(ConsumerFeedMessage $consumerFeedMessage)
    {
        $this->model = $consumerFeedMessage;
    }

    /**
     * @param array $data
     * @return mixed|void
     */
    public function createMessage(array $data)
    {
        $this->store($data);
    }
}
