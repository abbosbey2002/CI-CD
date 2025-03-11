<?php

namespace Modules\ContentManagement\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\ContentManagement\Database\factories\TermsConditionFactory;

class TermsCondition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title', 'description', 'file'];

    // protected static function newFactory(): TermsConditionFactory
    // {
    //     //return TermsConditionFactory::new();
    // }
}
