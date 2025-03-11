<?php

namespace Modules\ContentManagement\App\Repositories;

use Modules\ContentManagement\App\Models\FAQ;

class FAQRepository
{
    public function getAll($filter = [], $limit = 15)
    {
        $query = FAQ::latest();

        if (isset($filter['is_active'])) {
            $query->where('is_active', $filter['is_active']);
        }

        return $query->paginate($limit);
    }

    public function getById($id)
    {
        // dd(FAQ::findorFail($id));
        return FAQ::findorFail($id);
    }

    public function create(array $data)
    {

        return FAQ::create($data);
    }

    public function update($id, array $data)
    {
        $faq = $this->getById($id);
        $faq->update($data);

        return $faq;
    }

    public function delete($id)
    {
        return FAQ::findorFail($id)->delete();
    }
}
