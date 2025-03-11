<?php

namespace Modules\TariffsAndPromotions\App\Repositories;

use Modules\TariffsAndPromotions\App\Models\Tariff;

class TariffRepository
{
    public function getTariffsByFilter(array $filter = [], int $limit = 15)
    {

        $query = Tariff::latest();

        if (isset($filter['is_active'])) {
            $query->where('is_active', $filter['is_active']);
        }

        return $query->paginate($limit);
    }

    public function getById($id)
    {
        return Tariff::findOrFail($id);
    }

    public function getTariffByTitle($title)
    {
        return Tariff::where('title', $title)->first();
    }

    public function create(array $data)
    {
        return Tariff::create($data);
    }

    public function update($id, array $data)
    {
        $tariff = $this->getById($id);
        $tariff->update($data);

        return $tariff;
    }

    public function delete($id)
    {
        $tariff = $this->getById($id);
        $tariff->delete();
    }
}
