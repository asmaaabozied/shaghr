<?php

namespace App\Models\Hotels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelImage extends Model
{
    use HasFactory;

    protected $fillable = ["hotel_id", "image"];
    protected $appends = ['image_path'];
    protected $hidden = ['deleted_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by', 'room_id'];

    public function getImagePathAttribute()
    {
        return asset('images/hotels/' . $this->image);

    }//end of get image path
}
