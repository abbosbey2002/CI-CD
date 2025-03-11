<?php

namespace Modules\ContentManagement\App\Services;

use Modules\ContentManagement\App\Repositories\NewsRepository;

class NewsService
{
    protected $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function getAll($filter = [], $limit = 15)
    {
        return $this->newsRepository->getAll($filter, $limit);
    }

    public function getById($id)
    {
        return $this->newsRepository->getById($id);
    }

    public function create(array $data)
    {
        return $this->newsRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->newsRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->newsRepository->delete($id);
    }
}
