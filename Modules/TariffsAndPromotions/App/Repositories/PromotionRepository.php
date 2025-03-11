<?php

namespace Modules\TariffsAndPromotions\App\Repositories;

use Modules\TariffsAndPromotions\App\Models\Promotion;

class PromotionRepository
{
    public function getAllWithFilters(array $filters = [], $limit = 15)
    {
        $query = Promotion::latest();

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->paginate($limit);
    }

    public function getById($id)
    {
        return Promotion::findOrFail($id);
    }

    public function create(array $data)
    {
        return Promotion::create($data);
    }

    public function update($id, array $data)
    {
        $promotion = $this->getById($id);
        $promotion->update($data);

        return $promotion;
    }

    public function delete($id)
    {
        $promotion = $this->getById($id);
        $promotion->delete();
    }
}
