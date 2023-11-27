<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use http\Env\Response;
use Illuminate\Cache\RateLimiter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Mod;

class GetAllUsersController extends Controller
{
    /**
     * @lrd
     * Get User Api For Free.
     */

    public function freeIndex(Request $request)
    {
        $apiKey = $request->header('API-Key');

        if (!$apiKey || !ApiKey::query()->where('key', $apiKey)->where('active', true)->exists()) {
            return response()->json(['error' => 'Api Key Is Disabled'], 401);
        }
        return \App\Models\User::all();
    }

    /**
     * @lrd
     * Get User Api For Paid
     */
    public function paidIndex(Request $request)
    {
        $apiKey = $request->header('API-Key');

        if (!$apiKey || !ApiKey::query()->where('key', $apiKey)->where('active', true)->exists()) {
            return response()->json(['error' => 'Api Key Is Disabled'], 401);
        }
        return \App\Models\User::all();
    }
}
