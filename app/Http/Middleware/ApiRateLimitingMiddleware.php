<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ApiRateLimitingMiddleware
{

    public $count_calls = 0;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        $apiKey = $request->header('API-Key');
//        $apiKeyTable = ApiKey::query()->where('key', $apiKey)->where('active', true)->first();
//        dd($apiKeyTable);
//        $companyId = $request->user()->company_id;// Get the company ID from the request or authentication
//
//        $cacheKey = 'api_usage_' . $companyId;
//
//        $user = $request->user();
//
//        $apiUsageCount = Cache::get($cacheKey, 0);
//
//        if ($user->hasCompany()) { //if user has company
//            $apiLimit = $user->subscription_type == 'free' ? 5 : 20;
//
//            if ($apiUsageCount >= $apiLimit) {//if user has company and subscription type is free or paid
//                return response()->json([
//                    'error' => 'API usage limit exceeded for the company.'
//                ], 429);
//            }
//        }else{
//            $apiLimit = $user->subscription_type == 'free' ? 5 : 10;
//
//            $cacheKey = 'api_usage_' . $user->id;
//
//            $apiUsageCount = Cache::get($cacheKey, 0);
//
//            if ($apiUsageCount >= $apiLimit) {//if user has  no company and subscription type is free or paid
//
//                return response()->json([
//                    'error' => 'API usage limit exceeded for the user.'
//                ], 429);
//            }
//        }
//        // Increment the API usage count
//        Cache::put($cacheKey, $apiUsageCount + 1, now()->addDay());

        return $next($request);
    }
}
