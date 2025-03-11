<?php

namespace Modules\UserManagement\App\Repositories;

use Modules\UserManagement\App\Models\User;

class UserRepository
{
    public function create(array $data)
    {
        if (! empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        return User::create($data);
    }

    public function find($id)
    {
        return User::findorFail($id);
    }

    public function update($id, array $data)
    {
        $user = $this->find($id);
        if (! empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);

        return $user;
    }

    /**
     * Paginated + optional filters for listing users.
     */
    public function getUserByPagination(array $filters = [], int $limit = 10)
    {
        $query = User::latest();

        if (! empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        // Filter by type
        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        // Filter by name (partial match)
        if (! empty($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        $query->latest();

        return $query->paginate($limit);
    }

    public function deleteUser($id)
    {
        $user = $this->find($id);

        return $user->delete();
    }
}
