<?php

namespace Modules\TariffsAndPromotions\App\Services;

use Illuminate\Support\Facades\Storage;
use Modules\TariffsAndPromotions\App\Repositories\TariffRepository;

class TariffService
{
    protected $tariffRepository;

    public function __construct(TariffRepository $tariffRepository)
    {
        $this->tariffRepository = $tariffRepository;
    }

    public function getTariffs(array $filter, int $limit)
    {
        return $this->tariffRepository->getTariffsByFilter($filter, $limit);
    }

    public function getById($id)
    {
        return $this->tariffRepository->getById($id);
    }

    public function getTariffByTitle($title)
    {
        return $this->tariffRepository->getTariffByTitle($title);
    }

    public function create(array $data, $file = null)
    {
        if ($file) {
            // Store the file in the 'tariffs' folder on the 'public' disk.
            // This returns a path like "tariffs/abc123.jpg".
            $data['image'] = $file->store('tariffs', 'public');
        }

        return $this->tariffRepository->create($data);
    }

    public function update($id, array $data, $file = null)
    {
        $tariff = $this->getById($id);
        if ($file) {
            // If a new file is provided, delete the old file if it exists.
            if ($tariff->image && Storage::disk('public')->exists($tariff->image)) {
                Storage::disk('public')->delete($tariff->image);
            }

            // Store the new file and update the data with its path.
            $data['image'] = $file->store('tariffs', 'public');
        } else {
            // If no file is provided, do not overwrite the image field.
            unset($data['image']);
        }

        return $this->tariffRepository->update($id, $data);
    }

    public function delete($id)
    {
        $this->tariffRepository->delete($id);
    }
}
