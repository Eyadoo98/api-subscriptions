<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use App\Models\User;
use Closure;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\RateLimiter;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$throttleKey): Response
    {


//        Here
//        $apiKey = $request->header('API-Key');

        $user = $request->user();

//        if (!$apiKey || !ApiKey::query()->where('key', $apiKey)->where('active', true)->exists()) {
//            return response()->json(['error' => 'Invalid API key.'], 401);
//        }
//
//        $apiKeyModel = ApiKey::query()->where('key', $apiKey)->where('active', true)->where('user_id', $user->id)->first();
//
//        if (!$apiKeyModel) {
//            return response()->json(['error' => 'Invalid API key.'], 401);
//        }
//
//        $apiKeyModel->count = $apiKeyModel->count + 1;
//
//        $limits = [
//            'free' => [
//                'daily' => 5,
//                'monthly' => 10,
//            ],
//            'paid' => [
//                'daily' => 10,
//                'monthly' => 20,
//            ],
//        ];
//
//        $subscriptionType = $user->subscription_type;
//        $userType = $user->type;
//
//        $limit = $limits[$subscriptionType][$userType] ?? null;
//
//        if ($limit !== null && $apiKeyModel->count > $limit) {
//            return response()->json(['error' => 'API usage limit exceeded.'], 429);
//        }
//
//        $apiKeyModel->save();

//        Here

        $apiKey = $request->header('API-Key');
//
//        check for api key
        if (!$apiKey || !ApiKey::query()->where('key', $apiKey)->where('active', true)->exists()) {
            return response()->json(['error' => 'Invalid API key.'], 401);
        }
//
        $apiKeyModel = ApiKey::query()->where('key', $apiKey)->where('active', true)->where('user_id', $user->id)->first();

        if($user->subscription_type == 'free'){//$user->type == 'daily'
            $executed = RateLimiter::attempt(
                'send-message:' . $apiKeyModel->key,
                $perMinute = 5,
                function () use ($request, $user, $apiKeyModel) {

                    if (!$apiKeyModel) {
                        return response()->json(['error' => 'Invalid API key.'], 401);
                    }
                    return true;
                },
            );
            //use RateLimiter to handle hourly and daily limits

            if (!$executed) {
                return response()->json(['error' => 'API usage limit exceeded.XXXXXXXX'], 429);
            }

        }
        if($user->subscription_type == 'paid'){//$user->type == 'monthly'
            $executed = RateLimiter::attempt(
                'send-message:' . $apiKeyModel->key,
                10,
                function () use ($request, $user, $apiKeyModel) {

                    if (!$apiKeyModel) {
                        return response()->json(['error' => 'Invalid API key.'], 401);
                    }
                    return true;
                }

            );
            if (!$executed) {
                return response()->json(['error' => 'API usage limit exceeded.XXXXXXXX'], 429);
            }
        }




//        $limiter = RateLimiter::for('send-message:' . $apiKeyModel->key, function () use ($request, $user, $apiKeyModel,$next) {
//            Limit::perMinute(5);
//            if (!$apiKeyModel) {
//                return response()->json(['error' => 'Invalid API key.'], 401);
//            }
//            return $next($request);
//        });



            //        Here

//        if ($user->type === 'daily') {
//            $minuteAttempts = ApiKey::query()->where('user_id', $user->id)
//                ->firstOr(function () use ($user) {
//                    return ApiKey::query()->create([
//                        'user_id' => $user->id,
//                    ]);
//                });
//            $minuteLimit = 10;
//
//            // Check hourly limit
//            if ($minuteAttempts->count >= $minuteLimit) {
//                return response()->json(['error' => 'minutes API usage limit exceeded.'], 429);
//            }
//            $minuteAttempts->increment('count');
//        }
//        Here


//        if ($user->subscription_type === 'free' && $user->type == 'daily' && $apiKey->count > 5) {
//            return response()->json(['error' => 'API usage limit exceeded.'], 429);
//        }
//        if ($user->subscription_type === 'free' && $user->type == 'monthly' && $apiKey->count > 10) {
//            return response()->json(['error' => 'API usage limit exceeded.'], 429);
//        }
//        if ($user->subscription_type === 'paid' && $user->type == 'daily' && $apiKey->count > 10) {
//            return response()->json(['error' => 'API usage limit exceeded.'], 429);
//        }
//        if ($user->subscription_type === 'paid' && $user->type == 'monthly' && $apiKey->count > 20) {
//            return response()->json(['error' => 'API usage limit exceeded.'], 429);
//        }
//        $apiKey->save();


//        $cacheKey = 'api_usage_' . $apiKey;
//
//        $apiUsageCount = Cache::get($cacheKey, 0);
//
//        Cache::put($cacheKey, $apiUsageCount + 1, now()->addMinutes(1));
//
//        $apiLimit = $user->subscription_type === 'free' ? 5 : 10;
//
//        if ($apiUsageCount >= $apiLimit) {
//            return response()->json(['error' => 'API usage limit exceeded.'], 429);
//        }

        return $next($request);
    }

}
