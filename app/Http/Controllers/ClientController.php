<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    /**
     * register based on $request
     * @param \App\Http\Requests\ClientRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function register(ClientRequest $request)
    {
        try {
            DB::beginTransaction();
            $info = $request->all();
            $info['password'] = bcrypt($request->password);
            $check = client::create($info);
            DB::commit();

            return response()->json([
                'status' => 201,
                'message' => __('messages.signup_success'),
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status' => 500,
                'error' => __('messages.error_server'),
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Log in based on email and password
     * @param String $email, String $password
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $client = Client::where('email', $request->email)
            ->first();

        if (
            $client &&
            Hash::check($request->password, $client->password)
        ) {
            Auth::guard('clients')->login($client);
            $saveClient = Auth::guard('clients')->user();
            $token = $saveClient->createToken(
                'authToken',
                ['*'],
                now()->addDays(7)
            )->plainTextToken;

            return response()->json([
                'status'    => 200,
                'message'   => __('messages.login_success'),
                'token'   => $token,
            ], 200);
        }
        
        return response()->json([
            'status'    => 401,
            'message'   => __('messages.incorrect_information'),
        ], 401);
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
            'user_info'    => $request->user(),
        ], 200);
    }
}
