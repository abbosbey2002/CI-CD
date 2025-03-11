<?php

namespace Modules\ContentManagement\App\Services;

use Modules\ContentManagement\App\Repositories\ContactBranchRepository;

class ContactBranchService
{
    private $contactBranchRepository;

    public function __construct(ContactBranchRepository $contactBranchRepository)
    {
        $this->contactBranchRepository = $contactBranchRepository;
    }

    public function getAllBranches($perPage = 15)
    {
        return $this->contactBranchRepository->getAll($perPage);
    }

    public function getBranch($id)
    {
        return $this->contactBranchRepository->getById($id);
    }

    public function createBranch(array $data)
    {
        return $this->contactBranchRepository->create($data);
    }

    public function updateBranch($id, array $data)
    {
        return $this->contactBranchRepository->update($id, $data);
    }

    public function deleteBranch($id)
    {
        return $this->contactBranchRepository->delete($id);
    }
}
