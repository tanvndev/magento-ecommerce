<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class LogRequestsAndResponses
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Log request
        Log::info('>>Incoming request<<', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            // 'headers' => $request->headers->all(),
            'payload' => $this->getPayload($request),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        $response = $next($request);

        // Log response
        Log::info('>>Outgoing response<<', [
            'status' => $response->status(),
            // 'headers' => $response->headers->all(),
            'request_id' => $request->header('X-Request-ID'),
        ]);

        return $response;
    }

    /**
     * Get request payload (limit the size to avoid excessive logging).
     *
     * @return array|string
     */
    protected function getPayload(Request $request)
    {
        $payload = $request->all();
        if (strlen(json_encode($payload)) > 1000) {
            return 'Payload too large to log';
        }

        return $payload;
    }

    /**
     * Get response content (limit the size to avoid excessive logging).
     *
     * @return string
     */
    protected function getContent(Response $response)
    {
        $content = $response->getContent();
        if (strlen($content) > 1000) {
            return 'Content too large to log';
        }

        return $content;
    }
}
