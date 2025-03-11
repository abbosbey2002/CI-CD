<?php

namespace Modules\UserManagement\App\Services;

use Modules\UserManagement\App\Repositories\AdminRepository;

class AdminService
{
    private $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function createAdmin(array $data)
    {
        return $this->adminRepository->createAdmin($data);
    }

    public function findAdmin(int $id)
    {
        return $this->adminRepository->findAdmin($id);
    }

    public function updateAdmin($id, array $data)
    {
        return $this->adminRepository->updateAdmin($id, $data);
    }

    public function deleteAdmin($id)
    {
        return $this->adminRepository->deleteAdmin($id);
    }
}
