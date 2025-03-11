<?php

namespace Modules\ContentManagement\App\Repositories;

use Modules\ContentManagement\App\Models\News;

class NewsRepository
{
    public function getAll($filter = [], $limit = 15)
    {
        $query = News::latest();

        if (isset($filter['is_active'])) {
            $query->where('is_active', $filter['is_active']);
        }

        return $query->paginate($limit);
    }

    public function getById($id)
    {
        return News::findOrFail($id);
    }

    public function create(array $data)
    {
        return News::create($data);
    }

    public function update($id, array $data)
    {
        $news = $this->getById($id);
        $news->update($data);

        return $news;
    }

    public function delete($id)
    {
        $news = $this->getById($id);
        $news->delete();
    }
}
