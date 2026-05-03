<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingCanteenItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'canteen_item_id',
        'quantity',
        'subtotal',
    ];

    public function canteenItem()
    {
        return $this->belongsTo(CanteenItem::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
