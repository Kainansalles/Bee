<?php

namespace App\Services\Feed;

use App\Models\Consumer;
use App\Models\Feed;
use App\Repositories\Consumer\Contracts\ConsumerRepositoryContract;
use App\Repositories\Feed\Contracts\FeedRepositoryContract;
use App\Services\Feed\Contracts\FeedServiceContract;
use Exception;

class FeedService implements FeedServiceContract
{
    /**
     * @var FeedRepositoryContract
     */
    private FeedRepositoryContract $feedRepository;
    /**
     * @var ConsumerRepositoryContract
     */
    private ConsumerRepositoryContract $consumerRepository;

    /**
     * @param FeedRepositoryContract $feedRepository
     * @param ConsumerRepositoryContract $consumerRepository
     */
    public function __construct
    (
        FeedRepositoryContract $feedRepository,
        ConsumerRepositoryContract $consumerRepository
    ) {
        $this->feedRepository = $feedRepository;
        $this->consumerRepository = $consumerRepository;
    }

    /**
     * @param array $data
     * @return Feed
     * @throws Exception
     */
    public function createMessage(array $data): Feed
    {
        if ($data['anonymous']) {
            $data['consumer_id'] = Consumer::ANONYMOUS_ID;
            return $this->feedRepository->createMessage($data);
        }

        $consumer = $this->consumerRepository->getById($data['consumer_id']);
        if (empty($consumer)) {
            throw new Exception("Consumer not found");
        }

        return $this->feedRepository->createMessage($data);
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function feed(array $filters = [])
    {
        return $this->feedRepository->getMessages($filters);
    }
}
