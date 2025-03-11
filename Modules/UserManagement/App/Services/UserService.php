<?php

namespace Modules\UserManagement\App\Services;

use Illuminate\Validation\ValidationException;
use Modules\UserManagement\App\Repositories\UserRepository;

class UserService
{
    private $userRepository;

    // Allowed sub-types for each role
    protected $adminTypes = ['super_admin', 'owner', 'manager', 'operator'];

    protected $dealerTypes = ['dealer'];

    protected $userTypes = ['bot_user'];

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(array $data)
    {
        // Ensure 'role' is present
        if (! isset($data['role'])) {
            throw ValidationException::withMessages([
                'role' => ['role field is required.'],
            ]);
        }

        // Ensure 'type' is present
        $this->ensureValidType($data['role'], $data['type']);

        return $this->userRepository->create($data);
    }

    public function updateUser($id, array $data)
    {
        // Ensure 'role' is present
        $user = $this->userRepository->find($id);
        $role = $data['role'] ?? $user->role;
        $type = $data['type'] ?? $user->type;

        $this->ensureValidType($role, $type);

        return $this->userRepository->update($id, $data);

    }

    public function getUsersByPagination(array $filters = [], int $limit = 10)
    {
        return $this->userRepository->getUserByPagination($filters, $limit);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->deleteUser($id);
    }

    public function showUser($id)
    {
        return $this->userRepository->find($id);
    }

    public function ensureValidType(string $role, ?string $type): void
    {
        if (! $type) {
            return;
        }

        switch ($role) {
            case 'admin':
                if (! in_array($type, $this->adminTypes)) {
                    throw ValidationException::withMessages([
                        'type' => ['Invalid '.$type.' for admin.'],
                    ]);
                }
                break;
            case 'dealer':
                if (! in_array($type, $this->dealerTypes)) {
                    throw ValidationException::withMessages([
                        'type' => ['Invalid '.$type.' for dealer.'],
                    ]);
                }
                break;
            case 'user':
                if (! in_array($type, $this->userTypes)) {
                    throw ValidationException::withMessages([
                        'type' => ['Invalid '.$type.' for user.'],
                    ]);
                }
                break;
            default:
                throw ValidationException::withMessages([
                    'role' => ["Role '$role' is not recognized."],
                ]);
        }
    }
}
