<?php

namespace App\Models\Places;

use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use HasFactory,HasLocaleValue,softDeletes;
    public $timestamps = true;

    protected $dates = ['deleted_at'];
    protected $guarded = [];
    public function getNameAttribute()
    {
        return self::getLocaleValue('name');
    }
    public function city(){
        return $this->belongsTo(City::class);
    }

}
