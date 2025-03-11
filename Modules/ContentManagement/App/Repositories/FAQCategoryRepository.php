<?php

namespace Modules\ContentManagement\App\Repositories;

use Modules\ContentManagement\App\Models\FAQCategory;

class FAQCategoryRepository
{
    public function getAll($filter = [], $limit = 15)
    {
        $query = FAQCategory::latest();

        if (isset($filter['is_active'])) {
            $query->where('is_active', $filter['is_active']);
        }

        return $query->paginate($limit);
    }

    public function getById($id)
    {
        // dd($id);
        return FAQCategory::findorFail($id);
    }

    public function create(array $data)
    {

        return FAQCategory::create($data);
    }

    public function update($id, array $data)
    {
        $faq = $this->getById($id);
        $faq->update($data);

        return $faq;
    }

    public function delete($id)
    {
        return FAQCategory::findorFail($id)->delete();
    }
}
