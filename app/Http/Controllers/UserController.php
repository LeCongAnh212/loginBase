<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\User;
use App\Services\User\ChangePasswordService;
use App\Services\Auth\RegisterUserService;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    const EXPIRED_DAY_TOKEN = 7;

    /**
     * Register a User.
     * @param ClientRequest $request
     * @return array|string|null
     */
    public function register(ClientRequest $request)
    {
        $result = resolve(RegisterUserService::class)->setParam($request->all())->handle();

        if ($result) {
            return $this->responseSuccess([
                'message' => __('messages.signup_success'),
            ], response::HTTP_CREATED);
        }

        return $this->responseErrors(__('messages.signup_fail'));
    }

    /**
     * Log in based on email and password
     * @param string $email
     * @param string $password
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (
            !empty($user) &&
            auth()->attempt(['email' => $request->email, 'password' => $request->password])
        ) {
            $token = auth()->user()->createToken(
                'authToken',
                ['*'],
                now()->addDays(self::EXPIRED_DAY_TOKEN)
            )->plainTextToken;

            return $this->responseSuccess([
                'message' => __('messages.login_success'),
                'type_token' => 'bearer',
                'token' => $token,
            ]);
        }

        return $this->responseErrors(__('messages.incorrect_information'), Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Retrieve user information on the server
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        return $this->responseSuccess([
            'user' => $request->user(),
        ]);
    }

    /**
     * Summary of changePassword
     * @param string|mixed password
     * @param string|mixed new_password
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $check = resolve(ChangePasswordService::class)->setParam([
            'password' => $request->password,
            'new_password' => $request->new_password,
        ])->handle();

        if ($check) {
            return $this->responseSuccess([
                'message' => __('messages.change_password_success'),
            ]);
        }

        return $this->responseErrors(__('messages.incorrect_information'), Response::HTTP_UNAUTHORIZED);
    }
}
