<?php

namespace Modules\ContentManagement\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Modules\ContentManagement\Database\factories\ProductFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title', 'file'];

    // protected static function newFactory(): ProductFactory
    // {
    //     //return ProductFactory::new();
    // }

    protected $appends = ['file_url'];

    public function getFileUrlAttribute(): ?string
    {
        return $this->file ? asset(Storage::url($this->file)) : null;
    }
}
