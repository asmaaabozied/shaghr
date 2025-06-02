<?php

namespace App\Models\Rooms;

use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomTypes extends Model
{
    use HasFactory, HasLocaleValue, SoftDeletes;

    protected $guarded = [];
    public function rooms()
    {
        return $this->hasMany(Room::class); // Each RoomType has many Rooms
    }
    public function getNameAttribute()
    {
        return self::getLocaleValue('name');
    }

    public function getDescriptionAttribute()
    {
        return self::getLocaleValue('description');
    }

}
