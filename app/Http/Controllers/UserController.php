<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\User\DeleteUserService;
use App\Services\User\GetUserService;
use App\Services\User\UpdateUserService;

class UserController extends Controller
{

    /**
     * update infomation for user
     * @param \App\Http\Requests\UpdateUserRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request)
    {
        $check = resolve(UpdateUserService::class)->setParams($request->all())->handle();

        if ($check) {
            return $this->responseSuccess([
                'message' => __('messages.update_success')
            ]);
        }

        return $this->responseErrors(__('messages.error_server'));
    }

    /**
     * delete user by id
     * @param int $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $check = resolve(DeleteUserService::class)->setParams($id)->handle();

        if ($check) {
            return $this->responseSuccess([
                'message' => __('messages.delete_success'),
            ]);
        }

        return $this->responseErrors(__('messages.error_server'));
    }

    /**
     * get all user
     * @return void
     */
    public function getAllUser()
    {
        $users = resolve(GetUserService::class)->handle();

        if ($users) {
            return $this->responseSuccess([
                'users' => $users
            ]);
        }

        return $this->responseErrors(__('messages.error_server'));
    }

    /**
     * get info current user
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function info()
    {
        return $this->responseSuccess([
            'user' => auth()->user()
        ]);
    }
}
