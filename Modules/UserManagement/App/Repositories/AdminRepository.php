<?php

namespace Modules\UserManagement\App\Repositories;

use Modules\UserManagement\App\Models\User;

class AdminRepository
{
    public function createAdmin(array $data)
    {
        // Hash the password
        if (! empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        // Assign the role
        $data['role'] = 'admin'; // Default to admin

        return User::create($data);
    }

    public function findAdmin(int $id)
    {
        return User::role('admin')->findOrFail($id);
    }

    public function updateAdmin($id, array $data)
    {
        $user = $this->findAdmin($id);
        if (! empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);

        return $user;
    }

    public function deleteAdmin($id)
    {
        return $this->findAdmin($id)->delete();
    }
}
