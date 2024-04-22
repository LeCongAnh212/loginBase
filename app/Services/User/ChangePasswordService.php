<?php

namespace App\Services\User;

use App\Interfaces\User\UserRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordService extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * handle change password
     * @return bool
     */
    public function handle()
    {
        if (Hash::check($this->data['password'], Auth::user()->password)) {
            $this->userRepository->update([
                'password' => $this->data['new_password']
            ], Auth::user()->id);

            return true;
        }

        return false;
    }
}
