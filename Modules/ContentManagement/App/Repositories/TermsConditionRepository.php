<?php

namespace Modules\ContentManagement\App\Repositories;

use Modules\ContentManagement\App\Models\TermsCondition;

class TermsConditionRepository
{
    public function getAll()
    {
        return TermsCondition::all();
    }

    public function getById($id)
    {
        return TermsCondition::findOrFail($id);
    }

    public function create(array $data)
    {
        return TermsCondition::create($data);
    }

    public function update($id, array $data)
    {
        $terms = $this->getById($id);
        $terms->update($data);

        return $terms;
    }

    public function delete($id)
    {
        $terms = $this->getById($id);
        $terms->delete();
    }
}
