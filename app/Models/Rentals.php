<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rentals extends Model
{
 use HasFactory;
    protected $fillable = [
        'user_id', 'house_id', 'start_date',
        'end_date', 'rent_price','booking_price', 'status', 'notes'
    ];
    public function user(){
        return $this->belongsTo(User::class);

    }

    public function house(){
        return $this->belongsTo(Houses::class);

    }
    public function payment(){
        return $this->hasMany(Payments::class);

    }
}
