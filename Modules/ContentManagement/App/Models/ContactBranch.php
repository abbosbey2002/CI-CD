<?php

namespace Modules\ContentManagement\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\ContentManagement\Database\factories\ContactBranchFactory;

class ContactBranch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'full_address',
        'country',
        'state',
        'city',
        'street',
        'comment',
        'use_full_address',
        'use_phone_numbers',
        'phone_number_1',
        'phone_number_1_person',
        'phone_number_2',
        'phone_number_2_person',
    ];

    // protected static function newFactory(): ContactBranchFactory
    // {
    //     //return ContactBranchFactory::new();
    // }
}
