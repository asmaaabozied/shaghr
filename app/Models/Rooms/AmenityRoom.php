<?php

namespace App\Models\Rooms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmenityRoom extends Model
{

    use HasFactory;
    protected $table ="amenity_rooms";
    protected $fillable =["room_id", "amenity_id"];
    protected $hidden = ['updated_at'];



}
