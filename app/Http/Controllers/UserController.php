<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\client;
use App\Models\User;
use App\Services\Auth\RegisterUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(ClientRequest $request)
    {
        $result = resolve(RegisterUserService::class)->setParam($request->all())->handle();

        if ($result) {
            return $this->responseSuccess([
                'message' => __('messages.signup_success'),
            ]);
        }

        return $this->responseErrors(__('messages.signup_fail'));
    }

    /**
     * Log in based on email and password
     * @param String $email, String $password
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if (
            ($user = User::where('email', $request->email)->first()) &&
            Hash::check($request->password, $user->password)
        ) {
            Auth::login($user);
            $saveUser = Auth::user();
            $token = $saveUser->createToken(
                'authToken',
                ['*'],
                now()->addDays(7)
            )->plainTextToken;

            return $this->responseSuccess([
                'message' => __('messages.login_success'),
                'type_token' => 'bearer',
                'token' => $token,
            ]);
        }

        return $this->responseErrors(__('messages.incorrect_information'), 401);
    }

    /**
     * Retrieve user information on the server
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        return response()->json([
            'status'   => 200,
            'user'    => $request->user(),
        ], 200);
    }
}
