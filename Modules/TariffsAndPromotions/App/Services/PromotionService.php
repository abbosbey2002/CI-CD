<?php

namespace Modules\TariffsAndPromotions\App\Services;

use Illuminate\Support\Facades\Storage;
use Modules\TariffsAndPromotions\App\Repositories\PromotionRepository;

class PromotionService
{
    protected $promotionRepository;

    public function __construct(PromotionRepository $promotionRepository)
    {
        $this->promotionRepository = $promotionRepository;
    }

    public function getAllWithFilters(array $filters = [], $limit = 15)
    {
        return $this->promotionRepository->getAllWithFilters($filters, $limit);
    }

    public function getById($id)
    {
        return $this->promotionRepository->getById($id);
    }

    public function create(array $data, $file = null)
    {
        // dd($data);
        if ($file) {
            // Store the file in the 'tariffs' folder on the 'public' disk.
            // This returns a path like "tariffs/abc123.jpg".
            $data['image'] = $file->store('promotions', 'public');
        }

        return $this->promotionRepository->create($data);
    }

    public function update($id, array $data, $file = null)
    {
        $promotion = $this->getById($id);
        if ($file) {
            // If a new file is provided, delete the old file if it exists.
            if ($promotion->image && Storage::disk('public')->exists($promotion->image)) {
                Storage::disk('public')->delete($promotion->image);
            }

            // Store the new file and update the data with its path.
            $data['image'] = $file->store('promotions', 'public');
        } else {
            // If no file is provided, do not overwrite the image field.
            unset($data['image']);
        }

        return $this->promotionRepository->update($id, $data);
    }

    public function delete($id)
    {
        $this->promotionRepository->delete($id);
    }
}
