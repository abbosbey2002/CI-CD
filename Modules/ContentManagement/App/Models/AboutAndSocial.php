<?php

namespace Modules\ContentManagement\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Modules\ContentManagement\Database\factories\AboutAndSocialFactory;

class AboutAndSocial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'about_description',
        'facebook_link',
        'instagram_link',
        'telegram_link',
        'telegram_bot_link',
        'youtube_link',
        'linkedin_link',
        'whatsapp_link',
        'terms_title',
        'terms_description',
        'terms_file',
    ];

    protected $table = 'about_company';

    // protected static function newFactory(): AboutAndSocialFactory
    // {
    //     //return AboutAndSocialFactory::new();
    // }

    protected $appends = ['file_url'];

    public function getFileUrlAttribute(): ?string
    {
        return $this->terms_file ? asset(Storage::url($this->terms_file)) : null;
    }

    protected static function booted()
    {
        static::creating(function ($aboutAndSocial) {
            $aboutAndSocial->created_by = auth()->user()->id;
            $aboutAndSocial->updated_by = auth()->user()->id;
        });

        static::updating(function ($aboutAndSocial) {
            $aboutAndSocial->updated_by = auth()->user()->id;
        });
    }
}
