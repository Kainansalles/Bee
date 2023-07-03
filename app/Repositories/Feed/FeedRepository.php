<?php

namespace App\Repositories\Feed;

use App\Models\Feed;
use App\Repositories\BaseRepository;
use App\Repositories\Feed\Contracts\FeedRepositoryContract;
use Illuminate\Support\Facades\Config;

/**
 *
 */
class FeedRepository extends BaseRepository implements FeedRepositoryContract
{
    /**
     * @var Feed
     */
    protected $model;

    /**
     * @param Feed $feed
     */
    public function __construct(Feed $feed)
    {
        $this->model = $feed;
    }

    /**
     * @param array $data
     * @return void
     */
    public function createMessage(array $data)
    {
        $this->store($data);
    }

    /**
     * @param array $filters
     * @return mixed|void
     */
    public function getMessages(array $filters)
    {
        $query = Feed::query();
        $itemsPerPage = Config::get('feed.items_per_page');

        if (isset($filters['keyword'])) {
            $query->where('message', 'like', '%' . $filters['keyword'] . '%');
        }

        return $query->latest()->paginate($itemsPerPage);
    }
}
