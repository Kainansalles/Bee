<?php

namespace Tests\Unit\Feed;

use App\Models\Consumer;
use App\Models\Feed;
use App\Repositories\Consumer\ConsumerRepositoryEloquent;
use App\Repositories\Consumer\Contracts\ConsumerRepositoryContract;
use App\Repositories\Feed\Contracts\FeedRepositoryContract;
use App\Repositories\Feed\FeedRepositoryEloquent;
use App\Services\Feed\Contracts\FeedServiceContract;
use App\Services\Feed\FeedService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \Exception;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class FeedServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var FeedService|mixed
     */
    private FeedService $service;

    /**
     * Set up the test
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        app()->bind(FeedServiceContract::class, FeedService::class);
        app()->bind(FeedRepositoryContract::class, FeedRepositoryEloquent::class);
        app()->bind(ConsumerRepositoryContract::class, ConsumerRepositoryEloquent::class);

        $this->service = app()->make(FeedService::class);
    }

    /**
     * @test
     * @return void
     * @throws Exception
     */
    public function should_create_message_from_anonymous_consumer()
    {
        $consumer = Consumer::create([
            'name' => "Anonymous"
        ]);
        $data = [
            'consumer_id' => $consumer->id,
            'message' => 'xpto',
            'anonymous' => true,
        ];

        $this->assertInstanceOf(Feed::class, $this->service->createMessage($data));
    }

    /**
     * @test
     * @return void
     * @throws Exception
     */
    public function should_receive_exception_not_found_consumer()
    {
        $this->expectException(Exception::class);
        $data = [
            'consumer_id' => '3',
            'message' => 'xpto',
            'anonymous' => false,
        ];

        $this->service->createMessage($data);
    }

    /**
     * @test
     * @return void
     * @throws Exception
     */
    public function should_create_message_from_other_consumer()
    {
        $consumer = Consumer::create([
            'name' => "Anonymous"
        ]);
        $data = [
            'consumer_id' => $consumer->id,
            'message' => 'xpto',
            'anonymous' => false,
        ];

        $this->assertInstanceOf(Feed::class, $this->service->createMessage($data));
    }

    /**
     * @test
     * @return void
     * @throws Exception
     */
    public function should_get_messages_with_keyword()
    {
        $consumer = Consumer::create([
            'name' => "Anonymous"
        ]);
        Feed::create([
            'consumer_id' => $consumer->id,
            'message' => 'Lorem ipsum dolor sit amet'
        ]);

        $filters = [
            'keyword' => 'ipsum'
        ];

        $result = $this->service->feed($filters);
        $this->assertNotEmpty($result);

        foreach ($result as $feed) {
            $this->assertStringContainsString($filters['keyword'], $feed->message);
        }
    }

    /**
     * @test
     * @return void
     * @throws Exception
     */
    public function should_get_messages_without_keyword()
    {
        $consumer = Consumer::create([
            'name' => "Anonymous"
        ]);

        for ($i = 1; $i <= 10; $i++) {
            Feed::create([
                'consumer_id' => $consumer->id,
                'message' => 'Lorem ipsum dolor sit amet'
            ]);
        }

        $filters = [];
        $result = $this->service->feed($filters);

        $this->assertNotEmpty($result);
        $this->assertCount(Config::get('feed.items_per_page'), $result);
    }

    /**
     * @test
     * @return void
     * @throws Exception
     */
    public function should_get_empty_messages()
    {
        $filters = [];
        $result = $this->service->feed($filters);

        $this->assertEmpty($result);
        $this->assertCount(0, $result);
    }
}
