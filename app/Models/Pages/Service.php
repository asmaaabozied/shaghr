<?php

namespace App\Models\Pages;

use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory,HasLocaleValue,SoftDeletes;

    protected $fillable = [
        'name_ar',
        'name_en',
        'type',
        'description_ar',
        'description_en',
        'image',
        'active'

    ];
    protected $hidden = ['deleted_at','updated_at'];
    public function getNameAttribute()
    {
        return self::getLocaleValue('name');
    }
    public function getDescriptionAttribute()
    {
        return self::getLocaleValue('description');
    }
}
