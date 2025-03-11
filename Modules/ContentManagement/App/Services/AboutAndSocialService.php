<?php

namespace Modules\ContentManagement\App\Services;

use Modules\ContentManagement\App\Repositories\AboutAndSocialRepository;

class AboutAndSocialService
{
    protected $repository;

    public function __construct(AboutAndSocialRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAboutAndSocial()
    {
        return $this->repository->getAboutAndSocial();
    }

    public function updateAboutAndSocial(array $data)
    {
        return $this->repository->updateAboutAndSocial($data);
    }
}
