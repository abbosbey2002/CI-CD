<?php

namespace Modules\ContentManagement\App\Repositories;

use Modules\ContentManagement\App\Models\AboutAndSocial;

class AboutAndSocialRepository
{
    public function getAboutAndSocial()
    {
        return AboutAndSocial::first();
    }

    public function updateAboutAndSocial(array $data)
    {
        $aboutAndSocial = AboutAndSocial::first();
        // var_dump($aboutAndSocial);

        if (! $aboutAndSocial) {
            $aboutAndSocial = AboutAndSocial::create($data);
        } else {
            $aboutAndSocial->update($data);
        }

        return $aboutAndSocial;
    }
}
