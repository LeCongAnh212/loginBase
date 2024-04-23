<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\User\UpdateUserService;

class UserController extends Controller
{

    public function update(UpdateUserRequest $request)
    {
        $check = resolve(UpdateUserService::class)->setParams($request->all())->handle();

        if ($check) {
            return $this->responseSuccess(__('messages.update_success'));
        }

        return $this->responseErrors(__('messages.error_server'));
    }
}
