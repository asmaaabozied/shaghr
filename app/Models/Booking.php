<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Models\Hotels\Hotels;
use App\Models\Rooms\Room;
use App\Models\User\User;
use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory,HasLocaleValue;
    protected $guarded=[];
    protected $casts = [
        'status' => BookingStatus::class,
    ];
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function hotel()
    {
        return $this->belongsTo(Hotels::class);
    }
}
