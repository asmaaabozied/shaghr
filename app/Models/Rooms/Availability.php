<?php

namespace App\Models\Rooms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Availability extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'room_availabilities';
    protected $guarded = [];
    protected $hidden = ['updated_at', 'deleted_at', 'updated_by', 'deleted_by'];


}
