<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeedResource;
use App\Services\Feed\FeedService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class FeedGetMessageController extends Controller
{
    /**
     * @var FeedService
     */
    private FeedService $feedService;

    /**
     * @param FeedService $feedService
     */
    public function __construct(FeedService $feedService)
    {
        $this->feedService = $feedService;
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection|JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {

            $feeds = $this->feedService->feed($request->query());

            return FeedResource::collection($feeds);

        } catch (\Exception $e) {
            Log::error('unexpected_error', [
                'context' => 'feed-get-message',
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
