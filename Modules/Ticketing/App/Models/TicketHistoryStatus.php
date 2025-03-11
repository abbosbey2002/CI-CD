<?php

namespace Modules\Ticketing\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Ticketing\Database\factories\TicketHistoryStatusFactory;

class TicketHistoryStatus extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'ticket_id',
        'old_status',
        'new_status',
        'updated_by_id',
        'date',
        'created_at',
        'updated_at',
    ];
    
    protected static function newFactory(): TicketHistoryStatusFactory
    {
        //return TicketHistoryStatusFactory::new();
    }


    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function ticket(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
