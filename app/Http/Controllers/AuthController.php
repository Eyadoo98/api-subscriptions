<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\Company;
use App\Models\User;
use App\Traits\AppResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use AppResponse;

    /**
     * @lrd
     * Register User.
     */
    public function createUser(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required'
                ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::query()->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'subscription_type'=> $request->subscription_type,
                'type'=> $request->type,
            ]);

            $apiKey = ApiKey::query()->create([
                'user_id' => $user->id, // foreign key reference to users table
                'key' => Str::random(40), // Generate a random string as the API key
                'active' => true,
            ]);

            $user['api_key'] = $apiKey->key;
            $user['token'] = $user->createToken("API TOKEN")->plainTextToken;
            return $this->success($user, __('message_user_created'));


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */

    /**
     * @lrd
     * Login User.
     */
    public function loginUser(Request $request): \Illuminate\Http\JsonResponse
    {

        try {
            $validateUser = Validator::make($request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return $this->success($user, __('message_user_created'));
//            return response()->json([
//                'status' => true,
//                'message' => 'User Logged In Successfully',
//                'token' => $user->createToken("API TOKEN")->plainTextToken
//            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
