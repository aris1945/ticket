<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Events\TicketCreated;

class Ticket extends Model
{
    const STATUS_ASSIGNED = 'assigned';
    const STATUS_DONE = 'done';

    protected $fillable = [
      'ticket_number',
      'category',
      'subcategory',
      'assigned_to',
      'evident_image',
      'description',
      'status',
    ];

    protected $dispatchesEvents = [
        'created' => TicketCreated::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to', 'nik');
    }
}
