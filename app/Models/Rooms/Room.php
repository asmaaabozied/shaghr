<?php

namespace App\Models\Rooms;

use App\Models\Amenities\Amenity;
use App\Models\Booking;
use App\Models\Hotels\Hotels;
use App\Trait\HasLocaleValue;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, HasLocaleValue, SoftDeletes;

    protected $fillable = [
        'name_ar',
        'name_en',
        'title_en',
        'title_ar',
        'availability',
        'number_people',
        'space',
        'pricing',
        'status',
        'active',
        'description_ar',
        'description_en',
        'hotel_id',
        'room_type_id',
        'created_by'


    ];

    protected $hidden = ['deleted_at', 'updated_at'];


    public function getNameAttribute()
    {
        return self::getLocaleValue('name');
    }

    public function getTitleAttribute()
    {
        return self::getLocaleValue('title');
    }

    public function getDescriptionAttribute()
    {
        return self::getLocaleValue('description');
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class,'amenity_rooms','room_id','amenity_id');
    }

    public function images()
    {
        return $this->hasMany(RoomImage::class, 'room_id');
    }
    public function deleteRoomImagesExcept($roomId, $keepImageIds)
    {
        RoomImage::where('room_id', $roomId)
            ->whereNotIn('id', $keepImageIds)
            ->delete();
    }
    public function prices()
    {
        return $this->hasMany(RoomPrice::class, 'room_id');
    }
    public function comments()
    {
        return $this->hasMany(RoomComment::class, 'room_id');
    }

    public function reviews()
    {
        return $this->hasMany(RoomReview::class, 'room_id');
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'room_id');
    }


    public function hotel()
    {
        return $this->belongsTo(Hotels::class, 'hotel_id');
    }
    public function roomType()
    {
        return $this->belongsTo(RoomTypes::class); // A Room belongs to a RoomType
    }
    public function bookings(){
        return $this->hasMany(Booking::class, 'room_id');
    }

    public function scopeAvailable($query, $check_in_date, $time_slot)
    {
        try {
            $start_time = Carbon::parse($check_in_date);
            $end_time = $start_time->copy()->addHours($time_slot);

            return $query->whereDoesntHave('bookings', function ($bookingQuery) use ($start_time, $end_time) {
                $bookingQuery->where(function ($q) use ($start_time, $end_time) {
                    $q->whereBetween('start_time', [$start_time, $end_time])
                        ->orWhereBetween('end_time', [$start_time, $end_time])
                        ->orWhere(function ($q) use ($start_time, $end_time) {
                            $q->where('start_time', '<', $start_time)
                                ->where('end_time', '>', $end_time);
                        });
                });
            });
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid date or time slot provided');
        }
    }

    public function scopePriceRange($query, $min_price, $max_price)
    {
        return $query->whereHas('prices', function ($priceQuery) use ($min_price, $max_price) {
            if (!empty($min_price)) {
                $priceQuery->where('price', '>=', $min_price);
            }
            if (!empty($max_price)) {
                $priceQuery->where('price', '<=', $max_price);
            }
        });
    }

    public function scopeReviewRate($query, $review_rate)
    {
        return $query->whereHas('reviews', function ($reviewQuery) use ($review_rate) {
            $reviewQuery->where('rating', '>=', $review_rate);
        });
    }

    public function scopeAmenities($query, $amenities)
    {
        return $query->whereHas('amenities', function ($amenityQuery) use ($amenities) {
            $amenityQuery->whereIn('id', $amenities);
        });
    }
}
