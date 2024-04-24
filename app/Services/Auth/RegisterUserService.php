<?php

namespace App\Services\Auth;

use App\Mail\Auth\VerifyMailRegister;
use App\Services\User\CreateUserService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class RegisterUserService extends CreateUserService
{
    public function handle()
    {
        try {
            parent::handle();

            return true;
        } catch (Exception $e) {
            Log::error("register user fail", ['memo' => $e->getMessage()]);

            return false;
        }
    }
}
