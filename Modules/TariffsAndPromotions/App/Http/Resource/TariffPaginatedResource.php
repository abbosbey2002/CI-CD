<?php

namespace Modules\TariffsAndPromotions\App\Http\Resource;

use AutoSwagger\Laravel\Resources\PaginatedResource;
use Modules\TariffsAndPromotions\App\Models\Tariff;

class TariffPaginatedResource extends PaginatedResource
{
    public function initCollection()
    {
        return $this->collection->map(function (Tariff $tariff) {

            return $tariff;
        });
    }
}
