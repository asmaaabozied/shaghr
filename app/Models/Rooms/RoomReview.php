<?php

namespace App\Models\Rooms;

use App\Models\User\User;
use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomReview extends Model
{
    use HasFactory, HasLocaleValue, SoftDeletes;


    protected $guarded = [];

    protected $hidden = ['deleted_at', 'updated_at'];

    public function getDescriptionAttribute()
    {
        return self::getLocaleValue('description');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
