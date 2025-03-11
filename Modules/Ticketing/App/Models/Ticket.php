<?php

namespace Modules\Ticketing\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\UserManagement\App\Models\User;


class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'priority',
        'assigned_to',
    ];

    public function comments()
    {
        return $this->hasMany(TicketComment::class);
    }

    public function tg_id()
    {
        return $this->belongsTo(User::class, 'tg_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function messages()
    {
    return $this->hasMany(TicketMessage::class);
    }

    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class);
    }
}
