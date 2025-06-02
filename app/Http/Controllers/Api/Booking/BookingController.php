<?php

namespace App\Http\Controllers\Api\Booking;
use App\Enums\CommonEnum;
use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBookingRequest;
use App\Http\Resources\Api\Booking\BookingGuestResource;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Hotels\Hotels;
use App\Services\BookingService;
use App\Trait\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use ApiResponse;

    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }


    public function index(Request $request)
    {
        $wheresIn = $with = $wheres = $withCount = $orWheres = [];
        $is_paginate = $request->is_paginate ?? 0;
        $with = ['room', 'user', 'hotel'];
        $wheres[] = ['user_id', '=', auth()->user()->id];
        $result = $this->bookingService->getAll($is_paginate, $wheres, $wheresIn, $with, $withCount, $orWheres);
        return self::makeSuccess(200, __('messages.success'), BookingResource::collection($result), !$is_paginate);


    }

    public function create(CreateBookingRequest $request)
    {

    }

    /**
     * @OA\Post(
     *     path="/api/booking",
     *     tags={"Bookings"},
     *     operationId="storeBooking",
     *     summary="Create a new booking",
     *     description="Stores a new booking with provided data.",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="room_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\Parameter(
     *         name="hotel_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Parameter(
     *         name="check_in_date",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", format="date-time", example="2025-02-10 14:00:00")
     *     ),
     *     @OA\Parameter(
     *         name="start_time",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", format="date-time", example="2025-02-10 15:00:00")
     *     ),
     *     @OA\Parameter(
     *         name="end_time",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", format="date-time", example="2025-02-10 18:00:00")
     *     ),
     *     @OA\Parameter(
     *         name="time_slot",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Parameter(
     *         name="price",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", example=200)
     *     ),
     *     @OA\Parameter(
     *         name="number_people",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\Parameter(
     *         name="room_type_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", enum={"pending", "confirmed", "cancelled"}, example="pending")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Booking created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(CreateBookingRequest $request)
    {
        $booking = $this->bookingService->createBooking($request->validated());
        return self::makeSuccess(200, __('messages.success'), $booking);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/booking/guest",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with columns",
     *     tags={"Bookings"},

    @OA\Parameter(
    name="Accept-Language",
    in="header",
    description="Set language parameter by ",
    @OA\Schema(
    type="string",
    enum={"en", "ar"},
    default="en"
    ),
    example="en"
    ),
    security={{"bearer": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="room_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\Parameter(
     *         name="hotel_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Parameter(
     *         name="check_in_date",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", format="date-time", example="2025-02-10 14:00:00")
     *     ),
     *     @OA\Parameter(
     *         name="start_time",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string", format="date-time", example="2025-02-10 15:00:00")
     *     ),
     *     @OA\Parameter(
     *         name="end_time",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", format="date-time", example="2025-02-10 18:00:00")
     *     ),
     *     @OA\Parameter(
     *         name="time_slot",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Parameter(
     *         name="price",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer", example=200)
     *     ),
     *     @OA\Parameter(
     *         name="number_people",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", example=2)
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", enum={"pending", "confirmed", "cancelled"}, example="pending")
     *     ),
     *
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No entries found"
     *     )
     * )
     */


    public function listGuest(Request $request)
    {

        $hotel_id = auth()->user()->hotels()->pluck('id')->toArray();
        $is_paginate = $request->is_paginate ?? 0;
        $model = Booking::whereIn('hotel_id', $hotel_id);

        if ($request->room_id) {
            $model->where('room_id', $request->room_id);

        } elseif ($request->hotel_id) {

            $model->where('hotel_id', $request->hotel_id);
        }

        if ($is_paginate) {
            $data = $model->orderBy('id', 'desc')->with('user','room')->paginate(CommonEnum::paginate);
        } else {
            $data = $model->orderBy('id', 'desc')->with('user', 'room')->get();
        }


        return self::makeSuccess(200, 'data retrieved successfully.', BookingGuestResource::collection($data), !$is_paginate);

    }
}
