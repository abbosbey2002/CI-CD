<?php

namespace Modules\ContentManagement\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Modules\ContentManagement\Database\factories\FAQCategoryFactory;

class FAQCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title', 'description', 'parent_category_id', 'image', 'created_by', 'updated_by', 'is_active'];

    protected $table = 'faq_categories';

    public function faqs()
    {
        return $this->hasMany(FAQ::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_category_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_category_id');
    }

    // protected static function newFactory(): FAQCategoryFactory
    // {
    //     //return FAQCategoryFactory::new();
    // }

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset(Storage::url($this->image)) : null;
    }

    protected static function booted()
    {
        static::creating(function ($faq_category) {
            $faq_category->created_by = auth()->user()->id;
            $faq_category->updated_by = auth()->user()->id;
        });

        static::updating(function ($faq_category) {
            $faq_category->updated_by = auth()->user()->id;
        });
    }
}
