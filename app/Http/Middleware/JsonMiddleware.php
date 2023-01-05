<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
class JsonMiddleware
{
    protected $factory;

    public function __construct(ResponseFactory $factory)
    {
        $this->factory = $factory;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // First, set the header so any other middleware knows we're
        // dealing with a should-be JSON response.
        $request->headers->set('Accept', 'application/json');

        // Get the response
        $response = $next($request);

        // If the response is not strictly a JsonResponse, we make it
        if (!$response instanceof JsonResponse) {
            $response = $this->factory->json(
                $response->content(),
                $response->status(),
                $response->headers->all()
            );
        }
        return $response;
    }
}
