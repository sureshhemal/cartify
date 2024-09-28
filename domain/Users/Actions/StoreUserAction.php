<?php

namespace Domain\Users\Actions;

use Domain\Users\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StoreUserAction
{
    public function execute(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make(Str::password()),
        ]);

        $user->assignRole(array_column($data['roles'], 'name'));

        // todo: send invitation email

        return $user;
    }
}
