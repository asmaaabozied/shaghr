<?php

namespace App\Models\Testimonials;

use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory, HasLocaleValue, SoftDeletes;

    protected $fillable = [
        'submission_date',
        'rating',
        'Published',
        'Status',
        'review_text_ar',
        'review_text_en',
        'active',
        'name_ar',
        'name_en',
        'position'

    ];

    protected $hidden = ['deleted_at', 'updated_at'];
    public function getNameAttribute()
    {
        return self::getLocaleValue('name');
    }


    public function getReviewTextAttribute()
    {
        return self::getLocaleValue('review_text');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User\User','user_id');
    }
}
