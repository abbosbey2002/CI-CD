<?php

namespace Modules\ContentManagement\App\Http\Resources;

use AutoSwagger\Laravel\Resources\PaginatedResource;
use Modules\ContentManagement\App\Models\FAQ;

class FAQPaginatedResource extends PaginatedResource
{
    public function initCollection()
    {
        return $this->collection->map(function (FAQ $faq) {
            return $faq;
        });
    }
}
