<?php

namespace App\Models\Rooms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomUser extends Model
{

    use HasFactory;
    
    protected $table='favorite_room_user';
    protected $fillable = ["room_id", "user_id"];
    protected $hidden = ['deleted_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'];

}
