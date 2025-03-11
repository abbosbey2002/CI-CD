<?php

namespace Modules\ContentManagement\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Modules\ContentManagement\Database\factories\FAQFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class FAQ extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['question', 'answer', 'category_id', 'is_active'];

    protected $table = 'faqs';

    public function category()
    {
        return $this->belongsTo(FaqCategory::class);
    }

    // protected static function newFactory(): FAQFactory
    // {
    //     return FAQFactory::new();
    // }

    protected static function booted()
    {
        static::creating(function ($faq) {
            $faq->created_by = auth()->user()->id;
            $faq->updated_by = auth()->user()->id;
        });

        static::updating(function ($faq) {
            $faq->updated_by = auth()->user()->id;
        });
    }
}
