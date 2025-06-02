<?php

namespace App\Models\Hotels;

use App\Models\Chains\Chains;
use App\Models\Places\City;
use App\Models\Places\Country;
use App\Models\Places\District;
use App\Models\Rooms\Room;
use App\Models\User\User;
use App\Trait\HasLocaleValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Hotels extends Model
{
    use HasFactory, HasLocaleValue, SoftDeletes;

    protected $guarded = [];
    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        // Set creator_id on create
        static::creating(function ($hotel) {
            if (Auth::check()) {
                $hotel->creator_id = Auth::id();
            }
        });

        // Set update_id on update
        static::updating(function ($hotel) {
            if (Auth::check()) {
                $hotel->update_id = Auth::id();
            }
        });

        // Set delete_id on delete
        static::deleting(function ($hotel) {
            if (Auth::check()) {
                $hotel->delete_id = Auth::id();
                $hotel->save(); // Ensure delete_id is saved before the record is soft deleted
            }
        });
    }

    public function chain()
    {
        return $this->belongsTo(Chains::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }


    public function rooms()
    {
        return $this->hasMany(Room::class,'hotel_id');
    }

    public function getNameAttribute()
    {
        return self::getLocaleValue('name');
    }

    public function getDescriptonAttribute()
    {
        return self::getLocaleValue('descripton');
    }

    public function images()
    {
        return $this->hasMany(HotelImage::class, 'hotel_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'hotel_users','user_id','hotel_id');
    }
}
