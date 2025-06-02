<?php

namespace App\Models\Places;

use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory,HasLocaleValue,softDeletes;
    public $timestamps = true;
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    public function getNameAttribute()
    {
        return self::getLocaleValue('name');
    }
    public function country(){
        return $this->belongsTo(Country::class);
    }
}
