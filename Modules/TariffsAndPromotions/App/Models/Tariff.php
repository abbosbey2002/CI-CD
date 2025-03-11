<?php

namespace Modules\TariffsAndPromotions\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Modules\TariffsAndPromotions\Database\factories\TariffFactory;

class Tariff extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
        'feature_1',
        'feature_2',
        'feature_3',
        'feature_4',
        'feature_5',
        'feature_6',
        'feature_7',
        'feature_8',
        'feature_9',
        'feature_10',
        'is_active',
        'is_deleted',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset(Storage::url($this->image)) : null;
    }
    // protected static function newFactory(): TariffFactory
    // {
    //     //return TariffFactory::new();
    // }

    protected static function booted(): void
    {
        static::creating(function (Tariff $tariff) {
            $tariff->created_by = auth()->user()->id;
            $tariff->updated_by = auth()->user()->id;
        });

        static::updating(function (Tariff $tariff) {
            $tariff->updated_by = auth()->user()->id;
        });

    }
}
