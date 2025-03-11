<?php

namespace Modules\ContentManagement\App\Services;

use Modules\ContentManagement\App\Repositories\TermsConditionRepository;

class TermsConditionService
{
    protected $termsConditionRepository;

    public function __construct(TermsConditionRepository $termsConditionRepository)
    {
        $this->termsConditionRepository = $termsConditionRepository;
    }

    public function getAll()
    {
        return $this->termsConditionRepository->getAll();
    }

    public function getById($id)
    {
        return $this->termsConditionRepository->getById($id);
    }

    public function create(array $data)
    {
        // dd($data);
        return $this->termsConditionRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->termsConditionRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->termsConditionRepository->delete($id);
    }
}
