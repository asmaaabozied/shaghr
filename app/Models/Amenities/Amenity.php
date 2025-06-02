<?php

namespace App\Models\Amenities;

use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amenity extends Model
{
    use HasFactory, HasLocaleValue, SoftDeletes;

    protected $fillable = [
        'name_ar',
        'name_en',
        'status',
        'icon',
        'description_ar',
        'description_en',
        'type_id'

    ];

    protected $hidden = ['deleted_at', 'updated_at','created_by','updated_by','deleted_by'];

    public function getNameAttribute()
    {
        return self::getLocaleValue('name');
    }

    public function getDescriptionAttribute()
    {
        return self::getLocaleValue('description');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Amenities\AmenitiesType','type_id');
    }
}
