<?php

namespace App\Models\Pages;

use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory,HasLocaleValue,softDeletes;

    protected $fillable = [
        'title_ar',
        'title_en',
        'status',
        'category',
        'body_ar',
        'body_en',
        'published',

    ];
    protected $hidden = ['deleted_at', 'updated_at'];
    public function getTitleAttribute()
    {
        return self::getLocaleValue('title');
    }
    public function getBodyAttribute()
    {
        return self::getLocaleValue('body');
    }
}
