<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiKeyController extends Controller
{

    /**
     * @lrd
     * Generate Api Key.
     */
    public function generateApiKey(): \Illuminate\Http\JsonResponse
    {
        $apiKey = ApiKey::query()->create([
            'user_id' => auth()->user()->id, // foreign key reference to users table
            'key' => Str::random(40), // Generate a random string as the API key
            'active' => true,
        ]);

        return response()->json(['api_key' => $apiKey->key]);
    }

//    hide function from show on request-docs view

    /**
     * @lrd
     * Update Api Key.
     */
    public function updateGenerateApiKey(Request $request): \Illuminate\Http\JsonResponse
    {

        $apiKeyNumber = ApiKey::query()->where('user_id', auth()->user()->id)->get()->pluck('key')->last();
        $apiKey = ApiKey::query()->where('user_id', auth()->user()->id)->where('key', $apiKeyNumber)->first();
        $apiKey->active = false;
//        $apiKey->key = Str::random(40);
        $apiKey->save();
        $newApiKey = ApiKey::query()->create([
            'user_id' => auth()->user()->id, // foreign key reference to users table
            'key' => Str::random(40), // Generate a random string as the API key
            'active' => true,
        ]);
        if($apiKey->key == $newApiKey->key){
            return response()->json(['api_key' => 'Api Key Not Updated Because It Is Same As Previous One']);
        }

        return response()->json(['api_key' => $newApiKey->key]);
    }
}
