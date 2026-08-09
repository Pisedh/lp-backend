<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Houses extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'room_number',
        'price',
        'status',
        'description'
    ];

    public function rentals(){
        return $this->hasMany(Rentals::class);
    }
}
