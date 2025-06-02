<?php

namespace App\Models\Images;

use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageGallery extends Model
{
    use HasFactory, HasLocaleValue, SoftDeletes;

    protected $fillable = [
        'title_ar',
        'title_en',
        'image_name',
        'extension',
        'image',
        'size',
        'thumbnail',
        'published',
        'status',
        'alternative_text_ar',
        'alternative_text_en',

    ];
    protected $hidden = ['deleted_at', 'updated_at'];

    public function getTitleAttribute()
    {
        return self::getLocaleValue('title');
    }

    public function getAlternativeTextAttribute()
    {
        return self::getLocaleValue('alternative_text');
    }
}
