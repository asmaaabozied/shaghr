<?php

namespace App\Models\Rooms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomPrice extends Model
{

    use HasFactory;
    protected $guarded=[];
    protected $hidden = ['deleted_at', 'updated_at','room_id'];
    public function rooms()
    {
        return $this->hasMany(Room::class); // Each RoomType has many Rooms
    }
}
