<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    protected $table="Features";
    protected $fillable = [
        'name_ar',
        'name_en',
        'status',
        'description_ar',
        'description_en',
        'image',

    ];
    protected $hidden = ['deleted_at', 'updated_at'];

}
