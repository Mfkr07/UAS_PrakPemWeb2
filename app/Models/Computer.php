<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    protected $fillable = ['name', 'status', 'price_per_hour'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
