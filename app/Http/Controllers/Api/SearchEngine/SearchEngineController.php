<?php

namespace App\Http\Controllers\Api\SearchEngine;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Api\Rooms\RoomResource;
use App\Http\Resources\Api\Search\SearchResultsResource;
use App\Models\Hotels\Hotels;
use App\Models\Rooms\Room;
use App\Services\SearchService;
use App\Trait\ApiResponse;

class SearchEngineController extends Controller
{
    use ApiResponse;
    private $searchService;
    public function __construct(SearchService $searchService){
        $this->searchService = $searchService;
    }
    /**
     * @OA\Get(
     *     path="/api/search",
     *     summary="User search",
     *     tags={"Search"},
     *     description="Search using city",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter",
     *         @OA\Schema(
     *             type="string",
     *             enum={"en", "ar"},
     *             default="en"
     *         ),
     *         example="en"
     *     ),
     *     @OA\Parameter(
     *         name="city_id",
     *         in="query",
     *         required=true,
     *         description="City ID",
     *         @OA\Schema(type="integer"),
     *         example=28
     *     ),
     *     @OA\Parameter(
     *         name="check_in_date",
     *         in="query",
     *         required=true,
     *         description="Check-in date",
     *         @OA\Schema(type="string", format="date-time"),
     *         example="2025-03-20"
     *     ),
     *          @OA\Parameter(
     *         name="check_in_time",
     *         in="query",
     *         description="Check-in time",
     *         @OA\Schema(type="string", format="date-time"),
     *         example="14:00:00"
     *     ),
     *     @OA\Parameter(
     *         name="num_people",
     *         in="query",
     *         description="Number of people",
     *         @OA\Schema(type="integer"),
     *
     *     ),
     *     @OA\Parameter(
     *         name="room_type_id",
     *         in="query",
     *         description="Room type ID",
     *         @OA\Schema(type="integer"),
     *
     *     ),
     *     @OA\Parameter(
     *         name="number_people",
     *         in="query",
     *         description="Number of people per room",
     *         @OA\Schema(type="integer"),
     *
     *     ),
     *     @OA\Parameter(
     *         name="min_price",
     *         in="query",
     *         description="Minimum price",
     *         @OA\Schema(type="integer"),
     *
     *     ),
     *     @OA\Parameter(
     *         name="max_price",
     *         in="query",
     *         description="Maximum price",
     *         @OA\Schema(type="integer"),
     *
     *     ),
     *     @OA\Parameter(
     *         name="amenities",
     *         in="query",
     *         description="Amenities filter",
     *         @OA\Schema(type="integer"),
     *
     *     ),
     *     @OA\Parameter(
     *         name="review_rate",
     *         in="query",
     *         description="Minimum review rating",
     *         @OA\Schema(type="integer"),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data fetched successfully",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="invalid_request")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Invalid email or password.")
     *         )
     *     )
     * )
     */

    public function search(SearchRequest $request)
    {
        $validatedData = $request->validated();

        $rooms = $this->searchService->search($validatedData);
        $roomsArray = $rooms->toArray();
        // Return results or a message if no hotels match
        if (empty($roomsArray))
        {
            return self::makeSuccess(200, 'No rooms found matching your criteria.',$roomsArray);
        }
        return self::makeSuccess(200, 'data retrieved successfully.', SearchResultsResource::collection($rooms));

    }
    /**
     * @OA\Get(
     *      path="/api/hotels/{id}/room-search",
     *      operationId="getHotelSearchById1",
     *      tags={"Search"},
     *      summary="Get Search information",
     *      description="Returns Search data",
     *          @OA\Parameter(
     *  name="Accept-Language",
     *  in="header",
     *  description="Set language parameter by ",
     *  @OA\Schema(
     *  type="string",
     *  enum={"en", "ar"},
     *  default="en"
     *  ),
     *  example="en"
     *  ),
     *      @OA\Parameter(
     *          name="id",
     *          description="hotels id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function getRooms($id){

        $rooms = Room::where('id',$id)
            ->with(['roomType', 'prices', 'reviews', 'amenities'])
            ->get();
        if ($rooms->isEmpty()) {
            return response()->json([
                'message' => 'No available rooms found for this hotel.',
                'data' => []

            ], 404);
        }

        return self::makeSuccess(200, 'data retrieved successfully.', RoomResource::collection($rooms));

    }
}
