<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Hotels\Hotels;
use App\Models\Rooms\Room;

use App\Models\Hotels\HotelUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{


    use  HasApiTokens, HasFactory, Notifiable,HasRoles;
    const TYPE_USER = 'user';
    const TYPE_OWNER = 'owner';
    const TYPE_ADMIN = 'admin';
    protected string $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'image',
        'birthday',
        'gender',
        'address',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function favourites()
    {
        return $this->belongsToMany(Hotels::class, 'hotel_users','user_id','hotel_id');
    }

    public function favouritesRoom()
    {
        return $this->belongsToMany(Room::class, 'favorite_room_user','user_id','room_id');
    }

    public function hotels()
    {
        return $this->hasMany(Hotels::class,'creator_id');
    }
}
