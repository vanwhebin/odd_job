<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth("api")->check()) {
            return response()->json([
                'status' => "error",
                'code' => Response::HTTP_UNAUTHORIZED,
                "message" => '用户未登录'
            ], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
