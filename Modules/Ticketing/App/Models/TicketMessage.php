<?php

namespace Modules\Ticketing\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Ticketing\Database\factories\TicketMessageFactory;

class TicketMessage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): TicketMessageFactory
    {
        //return TicketMessageFactory::new();
    }

    // TicketMessage modeli ichida
public function ticket()
{
    return $this->belongsTo(Ticket::class);
}

}
