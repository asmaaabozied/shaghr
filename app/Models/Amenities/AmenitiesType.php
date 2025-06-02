<?php

namespace App\Models\Amenities;

use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmenitiesType extends Model
{
    use HasFactory, HasLocaleValue, SoftDeletes;

//    protected $table="amenities_types";
    protected $fillable = [
        'name_ar',
        'name_en',
        'status'

    ];
    protected $hidden = ['deleted_at', 'updated_at'];

    public function getNameAttribute()
    {
        return self::getLocaleValue('name');
    }
}
