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
    public function register(ClientRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $info = $request->all();
            $info['password'] = bcrypt($request->password);
            $check = client::create($info);
            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'signed up successfully',
            ]);
        } catch (\Throwable $th)
        {
            DB::rollBack();

            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function login(Request $request)
    {
        $client = Client::where('email', $request->email)->first();
        if ($client && Hash::check($request->password, $client->password))
        {
            Auth::guard('clients')->login($client);
            $saveClient = Auth::guard('clients')->user();
            $token = $saveClient->createToken('authToken', ['*'], now()->addDays(7))->plainTextToken;

            return response()->json([
                'status'    => 200,
                'message'   => 'Login successfully',
                'token'   => $token,
            ]);
        } else
        {
            return response()->json([
                'status'    => 500,
                'message'   => 'You have entered incorrect information',
            ]);
        }
    }

    public function info(Request $request)
    {
        return response()->json([
            'status'   => 200,
            'message'    => $request->user(),
        ]);
    }
}
