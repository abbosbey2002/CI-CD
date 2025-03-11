<?php

namespace Modules\TariffsAndPromotions\App\Http\Resource;

use AutoSwagger\Laravel\Resources\PaginatedResource;
use Modules\TariffsAndPromotions\App\Models\Promotion;

class PromotionPaginatedResource extends PaginatedResource
{
    public function initCollection()
    {
        return $this->collection->map(function (Promotion $promotion) {
            return $promotion;
        });
    }
}
