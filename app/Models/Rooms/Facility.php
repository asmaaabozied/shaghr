<?php

namespace App\Models\Rooms;

use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{

    use HasFactory,HasLocaleValue,softDeletes;

    protected $guarded = [];
    
    protected $hidden = ['deleted_at', 'updated_at'];


    public function getNameAttribute()
    {
        return self::getLocaleValue('name');
    }
    public function getDescriptionAttribute()
    {
        return self::getLocaleValue('description');
    }
}
