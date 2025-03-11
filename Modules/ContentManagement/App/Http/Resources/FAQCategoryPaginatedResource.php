<?php

namespace Modules\ContentManagement\App\Http\Resources;

use AutoSwagger\Laravel\Resources\PaginatedResource;
use Modules\ContentManagement\App\Models\FAQCategory;

class FAQCategoryPaginatedResource extends PaginatedResource
{
    public function initCollection()
    {
        return $this->collection->map(function (FAQCategory $faq) {
            return $faq;
        });
    }
}
