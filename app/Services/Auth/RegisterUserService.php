<?php

namespace App\Services\Auth;

use App\Interfaces\User\UserRepositoryInterface;
use App\Services\User\CreateUserService;
use Illuminate\Support\Facades\Log;

class RegisterUserService extends CreateUserService
{
    public function handle()
    {
        try {
            parent::handle();

            return true;
        } catch (\Throwable $th) {
            Log::error("register user fail", ['memo' => $th->getMessage()]);

            return false;
        }
    }
}
