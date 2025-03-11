<?php

namespace Modules\ContentManagement\App\Repositories;

use Modules\ContentManagement\App\Models\ContactBranch;

class ContactBranchRepository
{
    public function getAll($perPage = 15)
    {
        return ContactBranch::latest()->paginate($perPage);
    }

    public function getById($id)
    {
        return ContactBranch::findorFail($id);
    }

    public function create(array $data)
    {
        return ContactBranch::create($data);
    }

    public function update($id, array $data)
    {
        $contactBranch = $this->getById($id);
        $contactBranch->update($data);

        return $contactBranch;
    }

    public function delete($id)
    {
        $contactBranch = $this->getById($id);
        $contactBranch->delete();

        return $contactBranch;
    }
}
