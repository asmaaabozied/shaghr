<?php

namespace App\Models\Chains;

use App\Models\Hotels\Hotels;
use App\Models\User\User;
use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chains extends Model
{
    use HasFactory, SoftDeletes,HasLocaleValue;
    protected $guarded=[];
    protected $dates = ['deleted_at'];


    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getNameAttribute()
    {
        return self::getLocaleValue('name');
    }

    public function hotels()
    {
        return $this->hasMany(Hotels::class, 'chain_id');
    }
    public function document()
    {
        return $this->hasOne(VerificationDocument::class,'chain_id','id');
    }
}
