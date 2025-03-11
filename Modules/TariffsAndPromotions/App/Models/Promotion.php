<?php

namespace Modules\TariffsAndPromotions\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Promotion extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title', 'description', 'date_from', 'date_to', 'is_active', 'image', 'created_by', 'updated_by'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset(Storage::url($this->image)) : null;
    }

    protected static function booted(): void
    {
        static::creating(function (Promotion $promotion) {
            $promotion->created_by = auth()->user()->id;
            $promotion->updated_by = auth()->user()->id;
        });

        static::updating(function (Promotion $promotion) {
            $promotion->updated_by = auth()->user()->id;
        });

    }
}
