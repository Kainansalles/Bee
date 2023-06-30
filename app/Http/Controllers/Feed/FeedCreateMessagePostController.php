<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeedCreateMessage\FeedCreateMessageRequest;
use App\Services\Consumer\ConsumerService;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class FeedCreateMessagePostController extends Controller
{
    /**
     * @var ConsumerService
     */
    private ConsumerService $consumerService;

    /**
     * @param ConsumerService $consumerService
     */
    public function __construct(ConsumerService $consumerService)
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
            $this->consumerService->createMessage($request->all());

            return response()->json(
                [
                    'success' => 'Message Published',
                ],
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
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
                    'traceString' => $e->getTraceAsString(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
