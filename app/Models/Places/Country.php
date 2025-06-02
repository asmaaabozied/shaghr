<?php

namespace App\Models\Places;

use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory,HasLocaleValue,softDeletes;
    public $timestamps = true;

    protected $dates = ['deleted_at'];
    protected $fillable = ['name_en', 'name_ar', 'code', 'icon', 'is_active'];
    public function cities(): HasMany
    {
        return $this->hasMany('App\Models\Places\City');
    }

    public function users(): HasMany
    {
        return $this->hasMany('App\Models\User\User');
    }

    public function getNameAttribute()
    {
        return self::getLocaleValue('name');
    }
}
