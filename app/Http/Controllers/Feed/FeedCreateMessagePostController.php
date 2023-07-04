<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedCreateMessage\FeedCreateMessageRequest;
use App\Services\Feed\FeedService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class FeedCreateMessagePostController extends Controller
{
    /**
     * @var FeedService
     */
    private FeedService $consumerService;

    /**
     * @param FeedService $consumerService
     */
    public function __construct(FeedService $consumerService)
    {
        $this->consumerService = $consumerService;
    }

    /**
     * @param FeedCreateMessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(FeedCreateMessageRequest $request)
    {
        try {
            DB::beginTransaction();

            $this->consumerService->createMessage($request->all());

            DB::commit();

            return response()->json(
                [
                    'success' => 'Message Published',
                ],
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('unexpected_error', [
                'context' => 'feed-create-message',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'traceString' => $e->getTraceAsString(),
            ]);

            return response()->json(
                [
                    'message' => 'Service failed',
                    'exception_message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
