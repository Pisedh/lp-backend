<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
   protected $fillable = [
        'rental_id', 'amount', 'due_date', 'paid_date', 'status', 'note',
        'water_old', 'water_new', 'water_rate',
        'elec_old',  'elec_new',  'elec_rate',
        'booking_price',
        'sanitation', 'wifi',
    ];

     public function rental() {
        return $this->belongsTo(Rentals::class);
    }
}
