<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'files';

    protected $fillable = ['title', 'last_update', 'file', 'type'];

    protected $casts = [
        'last_update' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($file) {
            $file->last_update = now();
        });
    }

}
