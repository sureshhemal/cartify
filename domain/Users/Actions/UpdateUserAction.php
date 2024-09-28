<?php

namespace Domain\Users\Actions;

use Domain\Users\Models\User;

class UpdateUserAction
{
    public function execute(User $user, array $data): User
    {
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $user->syncRoles(array_column($data['roles'], 'name'));

        return $user;
    }
}
