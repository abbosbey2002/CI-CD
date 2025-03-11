<?php

namespace Modules\ContentManagement\App\Http\Resources;

use AutoSwagger\Laravel\Resources\PaginatedResource;
use Modules\ContentManagement\App\Models\ContactBranch;

class ContactBranchPaginatedResource extends PaginatedResource
{
    public function initCollection()
    {
        return $this->collection->map(function (ContactBranch $contactBranch) {
            return $contactBranch;
        });
    }
}
