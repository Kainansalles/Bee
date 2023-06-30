<?php

namespace App\Services\Consumer;

use App\Repositories\Consumer\Contracts\ConsumerRepositoryContract;
use App\Services\Consumer\Contracts\ConsumerServiceContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConsumerService implements ConsumerServiceContract
{
    /**
     * @var ConsumerRepositoryContract
     */
    private ConsumerRepositoryContract $consumerRepository;

    /**
     * @param ConsumerRepositoryContract $consumerRepositoryContract
     */
    public function __construct(ConsumerRepositoryContract $consumerRepositoryContract)
    {
        $this->consumerRepository = $consumerRepositoryContract;
    }

    /**
     * @param array $data
     * @return void
     */
    public function createMessage(array $data)
    {
        try {
            DB::beginTransaction();
            $data['consumer_id'] = $data['anonymous'] ? 1 : $data['consumer_id'];

            $this->consumerRepository->createMessage($data);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create Consumer in ' . self::class, [
                'code' => 'error_create_consumer',
                'exception' => $e,
            ]);
        }
    }
}
