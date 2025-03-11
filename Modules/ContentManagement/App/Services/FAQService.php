<?php

namespace Modules\ContentManagement\App\Services;

use Modules\ContentManagement\App\Repositories\FAQRepository;

class FAQService
{
    protected $faqRepository;

    public function __construct(FAQRepository $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    public function getAll($filter, $limit)
    {
        return $this->faqRepository->getAll($filter, $limit);
    }

    public function getById($id)
    {
        return $this->faqRepository->getById($id);
    }

    public function create($data)
    {

        return $this->faqRepository->create($data);
    }

    public function update($id, $data)
    {
        // dd($id, $data);
        return $this->faqRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->faqRepository->delete($id);
    }
}
