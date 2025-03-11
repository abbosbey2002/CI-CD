<?php

namespace Modules\ContentManagement\App\Services;

use Modules\ContentManagement\App\Repositories\FAQCategoryRepository;

class FAQCategoryService
{
    protected $faqCategoryRepository;

    public function __construct(FAQCategoryRepository $faqCategoryRepository)
    {
        $this->faqCategoryRepository = $faqCategoryRepository;
    }

    public function getAll(array $filter = [], $limit = 15)
    {
        return $this->faqCategoryRepository->getAll($filter, $limit);
    }

    public function getById($id)
    {
        return $this->faqCategoryRepository->getById($id);
    }

    public function create($data)
    {

        return $this->faqCategoryRepository->create($data);
    }

    public function update($id, $data)
    {

        return $this->faqCategoryRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->faqCategoryRepository->delete($id);
    }
}
