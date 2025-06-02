<?php

namespace App\Models\Pages;

use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory,HasLocaleValue,SoftDeletes;

    protected $fillable = [
        'title_ar',
        'title_en',
        'tags',
        'description_ar',
        'description_en',
        'parent_page',
        'published'

    ];

    protected $hidden = ['deleted_at', 'updated_at'];

    public function getTitleAttribute()
    {
        return self::getLocaleValue('title');
    }
    public function getDescriptionAttribute()
    {
        return self::getLocaleValue('description');
    }

}
