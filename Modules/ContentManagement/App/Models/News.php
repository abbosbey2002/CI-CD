<?php

namespace Modules\ContentManagement\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Modules\ContentManagement\Database\factories\NewsFactory;

class News extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title', 'description', 'image', 'is_active', 'created_by', 'updated_by'];

    // protected static function newFactory(): NewsFactory
    // {
    //     //return NewsFactory::new();
    // }

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset(Storage::url($this->image)) : null;
    }

    protected static function booted(): void
    {
        static::creating(function (News $news) {
            $news->created_by = auth()->user()->id;
            $news->updated_by = auth()->user()->id;
        });

        static::updating(function (News $news) {
            $news->updated_by = auth()->user()->id;
        });

    }
}
