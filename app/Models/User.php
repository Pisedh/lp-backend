<?php

    namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;


    class User extends Authenticatable
    {
    use HasApiTokens, Notifiable, HasFactory;
        protected $fillable = [
            'name',
            'email',
            'password',
            'role',
            'room_number',
            'type',
            'tools',
            'photo'


        ];

        /**
         * The attributes that should be hidden for serialization.
         *
         * @var list<string>
         */
        protected $hidden = [
            'password',
            'remember_token',
        ];

        /**
         * Get the attributes that should be cast.
         *
         * @return array<string, string>
         */
        protected function casts(): array
        {
            return [
                'email_verified_at' => 'datetime',
                'password' => 'hashed',
                'tools'     => 'array'
            ];
        }




    }
