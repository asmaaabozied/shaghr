<?php

namespace App\Services;

use App\Models\Hotels\Hotels;
use App\Models\Rooms\Room;
use App\Models\Rooms\RoomTypes;
use App\Sorts\CustomPriceSearchSort;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
class SearchService
{
    public function searchHotels(array $criteria)
    {
//        return Hotels::with('rooms')
//            ->whereHas('city', function ($query) use ($criteria) {
//                $query->where('name', $criteria['city']);
//            })
//            ->whereHas('rooms', function ($query) use ($criteria) {
//                $query->where('room_type_id', $this->getRoomTypeId($criteria['room_type']))
//                    ->where('availability_date', $criteria['check_in_date'])
//                    ->where('number_people', '>=', $criteria['number_of_people']);
//            })
//            ->get();
    }

    private function getRoomTypeId(?string $roomType)
    {
        return $roomType ? RoomTypes::where('name', $roomType)->value('id') : null;
    }
//    public function search($filters)
//    {
//
//      $rooms = Room::query()->with(['bookings',
//            'reviews',
//            'roomType',
//            'prices',
//          'hotel'
//        ]);
//        $rooms=  $rooms->whereHas('hotel',function ($query) use ($filters) {
//          $query->where('city_id',$filters['city_id']);
//      });
//
//        if (!empty($filters['number_people'])) {
//            $rooms=   $rooms->where('number_people', '>=', $filters['number_people']);
//        }
//        if (!empty($filters['room_type_id'])) {
//            $rooms=   $rooms->where('room_type_id', $filters['room_type_id']);
//        }
//
//
//                if (!empty($filters['check_in_date']) && !empty($filters['time_slot'])) {
//                    try {
//                        $start_time = Carbon::parse($filters['start_time']);
//                        $end_time = $start_time->copy()->addHours($filters['time_slot']);
//
//                        $rooms=   $rooms->whereDoesntHave('bookings', function ($bookingQuery) use ($start_time, $end_time) {
//                            $bookingQuery->where(function ($q) use ($start_time, $end_time) {
//                                $q->whereBetween('start_time', [$start_time, $end_time])
//                                    ->orWhereBetween('end_time', [$start_time, $end_time])
//                                    ->orWhere(function ($q) use ($start_time, $end_time) {
//                                        $q->where('start_time', '<', $start_time)
//                                            ->where('end_time', '>', $end_time);
//                                    });
//                            });
//                        });
//
//                    } catch (\Exception $e) {
//                        // Handle invalid date or time slot format
//                        throw new \InvalidArgumentException('Invalid date or time slot provided');
//                    }
//                }
//
//        // Filter by price range
//        if (!empty($filters['min_price']) || !empty($filters['max_price'] )  ) {
//            $rooms=   $rooms->whereHas('prices', function ($priceQuery) use ($filters) {
//                if (!empty($filters['min_price'])) {
//                    $priceQuery->where('price', '>=', $filters['min_price']);
//                }
//                if (!empty($filters['max_price'])) {
//                    $priceQuery->where('price', '<=', $filters['max_price']);
//                }
//
//
//            });
//        }
//        if(!empty($filters['time_slot'])) {
//            $rooms=   $rooms->whereHas('prices', function ($priceQuery) use ($filters) {
//             $priceQuery->where('time_slot', $filters['time_slot']);
//            });
//        }
//
//        // Filter by minimum review rating
//        if (!empty($filters['review_rate'])) {
//            $rooms=   $rooms->whereHas('reviews', function ($reviewQuery) use ($filters) {
//                $reviewQuery->where('rating', '>=', $filters['review_rate']);
//            });
//        }
//
//        // Filter by amenities
//        if (!empty($filters['amenities'])) {
//            $rooms=   $rooms->whereHas('amenities', function ($amenityQuery) use ($filters) {
//                $amenityQuery->whereIn('id', $filters['amenities']);
//            });
//        }
//        if(!empty($filters['sort_order'])){
//            $rooms =   $rooms->whereHas('prices', function ($priceQuery) use ($filters) {
//                $priceQuery->orderBy('price', $filters['sort_order'])->limit(1);
//            });
//        }
//        // Get the filtered results
//        return $rooms->get();
//    }
    public function search($filters)
    {
        $query = QueryBuilder::for(Room::class)
            ->with(['bookings', 'reviews', 'roomType', 'prices', 'hotel', 'amenities','availabilities'])
            ->whereHas('hotel', function ($query) use ($filters) {
                $query->where('city_id', $filters['city_id'])->where('status',1)->whereHas('chain', function ($query) use ($filters) {
                    $query->where('active', 1);
                });
            })->whereHas('availabilities', function ($query) use ($filters) {
                $checkInDate = Carbon::parse($filters['check_in_date']);
                $query->where('start_date', '<=', $checkInDate)
                    ->where('end_date', '>=', $checkInDate);

            })
            // Filter by number of people
            ->allowedFilters([
                AllowedFilter::exact('room_type_id'),
                AllowedFilter::callback('number_people', function (Builder $query, $value) {
                    $query->where('number_people', '>=', $value);
                }),
                AllowedFilter::callback('review_rate', function (Builder $query, $value) {
                    $query->whereHas('reviews', function ($reviewQuery) use ($value) {
                        $reviewQuery->where('rating', $value);
                    });
                }),
                AllowedFilter::callback('amenities', function ($query, $value) {
                    $query->whereHas('amenities', function ($amenityQuery) use ($value) {
                        $amenityQuery->whereIn('id', $value);
                    });
                }),

                AllowedFilter::callback('min_price', function ($query, $value) use ($filters) {
                    $query->whereHas('prices', function ($priceQuery) use ($value) {
                        $priceQuery->where('price', '>=', $value);
                    });
                }),
                AllowedFilter::callback('max_price', function ($query, $value) use ($filters) {
                    $query->whereHas('prices', function ($priceQuery) use ($value) {
                        $priceQuery->where('price', '<=', $value);
                    });
                }),
                AllowedFilter::callback('time_slot', function ($query, $value) use ($filters) {
                    $query->whereHas('prices', function ($priceQuery) use ($value) {
                        $priceQuery->where('time_slot', $value);
                    });
                }),
            ])
            // Custom time slot and check-in filtering logic
            ->when(!empty($filters['check_in_date']) && !empty($filters['time_slot']), function ($query) use ($filters) {
                try {
                    $start_time = Carbon::parse($filters['check_in_date']);
                    $end_time = $start_time->copy()->addHours($filters['time_slot']);

                    $query->whereDoesntHave('bookings', function ($bookingQuery) use ($start_time, $end_time) {
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
            })
            // Sorting by price
            ->allowedSorts([
                AllowedSort::custom('price',new CustomPriceSearchSort())
            ]);
//dd($query->toSql());
        return $query->get();
    }
}
