<?php

namespace App\Models\Pages;

use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use HasFactory, HasLocaleValue,SoftDeletes;
    protected $fillable = [
        'name_ar',
        'name_en',
        'status',
        'description_ar',
        'description_en',
        'image',

    ];
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
