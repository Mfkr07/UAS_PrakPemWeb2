<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'computer_id',
        'duration_hours',
        'package_type',
        'start_time',
        'end_time',
        'total_price',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function computer()
    {
        return $this->belongsTo(Computer::class);
    }

    public function canteenItems()
    {
        return $this->hasMany(BookingCanteenItem::class);
    }
}
