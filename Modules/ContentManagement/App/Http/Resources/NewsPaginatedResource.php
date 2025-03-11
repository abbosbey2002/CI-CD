<?php

namespace Modules\ContentManagement\App\Http\Resources;

use AutoSwagger\Laravel\Resources\PaginatedResource;
use Modules\ContentManagement\App\Models\News;

class NewsPaginatedResource extends PaginatedResource
{
    public function initCollection()
    {
        return $this->collection->map(function (News $news) {
            return $news;
        });
    }
}
