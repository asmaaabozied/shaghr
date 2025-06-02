<?php

namespace App\Http\Controllers\Api\Rooms;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Rooms\AvailabilityRequest;
use App\Http\Requests\Api\Rooms\SearchAvailabityRequest;
use App\Http\Resources\Api\Rooms\AvailabilityResource;
use App\Models\Rooms\Availability;
use App\Models\Rooms\Room;
use App\Services\Rooms\AvailabilityService;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    use ApiResponse;

    public function __construct(readonly AvailabilityService $availabilityService)
    {

    }

/**
 * @OA\Get(
 *     path="/api/availabilities",
 *     summary="Get a list of entries with columns",
 *     description="Retrieve a list of entries with type,date,hotel_id and room_id",
 *     tags={"Availabilities"},
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
 *
 *                  @OA\Property(
 *                     property="hotel_id",
 *                     type="string",
 *                     description="Code (5 characters max)",
 *                     example="hotel_id"
 *                 ),
 *                    @OA\Property(
 *                     property="room_id",
 *                     type="string",
 *                     description="room_id",
 *                     example="1"
 *                 ),
 *                      @OA\Property(
 *                     property="date",
 *                     type="string",
 *                     description="date",
 *                     example="date"
 *                 ),
 *                            @OA\Property(
 *                     property="type",
 *                     type="string",
 *                     description="type",
 *                     example="available"
 *                 ),
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

public
function index(Request $request)
{

    $wheresIn = $with = $wheres = $withCount = $orWheres = [];
    $is_paginate = $request->is_paginate ?? 0;
    if ($request->search) {
        $wheres[] = ['date', 'like', '%' . $request->search . '%'];
    }
    $wheres[] = ['created_by', auth()->user()->id];
    $result = $this->availabilityService->getAll($is_paginate, $wheres, $wheresIn, $with, $withCount, $orWheres);
    return self::makeSuccess(200, __("messages.success"), AvailabilityResource::collection($result), !$is_paginate);


}


/**
 * @OA\Post(
 *     path="/api/search/availabilities",
 *     summary="search availabilities",
 *      tags={"Availabilities"},
 *       @OA\Parameter(
name="room_id",
in="query",
description="room_id",
required=true,
@OA\Schema(type="integer")
),
@OA\Parameter(
name="hotel_id",
in="query",
description="hotel_id",
@OA\Schema(type="integer")
),
 *     @OA\Response(response="201", description="Availability Search registered successfully"),
 *     @OA\Response(response="422", description="Validation errors")
 * )
 */

public
function searchAvailability(SearchAvailabityRequest $request)
{

    if (!empty($request->hotel_id && $request->room_id)) {
        $data = Availability::where('created_by', '=', auth()->user()->id)->where('hotel_id', $request->hotel_id)->where('room_id', $request->room_id)->get();

    } elseif (!empty($request->hotel_id)) {
        $data = Availability::where('created_by', '=', auth()->user()->id)->where('hotel_id', $request->hotel_id)->get();


    } elseif (!empty($request->room_id)) {

        $data = Availability::where('created_by', '=', auth()->user()->id)->where('room_id', $request->room_id)->get();

    } else {

        $data = Availability::where('created_by', '=', auth()->user()->id)->get();
    }

    return self::makeSuccess(200, __("messages.success"), AvailabilityResource::collection($data));


}

/**
 * Show the form for creating a new resource.
 */
public
function create()
{
    //
}

/**
 * Store a newly created resource in storage.
 */

/**
 * @OA\Post(
 *     path="/api/availabilities",
 *     summary="Add Availabilities",
 *      tags={"Availabilities"},
 *        @OA\Parameter(
name="type",
in="query",
description="type",
@OA\Schema(type="string")
),
 *       @OA\Parameter(
name="date",
in="query",
description="date",
@OA\Schema(type="string")
),
 *           @OA\Parameter(
name="room_id",
in="query",
description="room_id",
@OA\Schema(type="string")
),
 *           @OA\Parameter(
name="hotel_id",
in="query",
description="hotel_id",
@OA\Schema(type="string")
),
 *     @OA\Response(response="201", description="Availability registered successfully"),
 *     @OA\Response(response="422", description="Validation errors")
 * )
 */


public
function store(AvailabilityRequest $request)
{
    $request_data = $request->all();
    $request_data['created_by'] = auth()->user()->id;
    $data = Availability::create($request_data);
    return self::makeSuccess(200, __('messages.created_successfully'), $data);


}

/**
 * Display the specified resource.
 */

/**
 * @OA\Get(
 *      path="/api/availabilities/{id}",
 *      operationId="getAvailabilityById",
 *      tags={"Availabilities"},
 *      summary="Get Availability information",
 *      description="Returns Availability data",
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
 *  security={{"bearer": {}}},
 *      @OA\Parameter(
 *          name="id",
 *          description="Availability id",
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


public
function show(string $id)
{
    $data = Availability::find($id);
    try {
        if (!$data) {
            // Handle the case where the country is not found
            return self::makeError(404, __('messages.not_found'));

        }
        // Return success if the country is found
        return self::makeSuccess(200, __("messages.success"), AvailabilityResource::make($data));

    } catch (\Throwable $th) {
        // Handle any other exceptions
        return self::makeError(400, $th->getMessage());
    }

}

/**
 * Show the form for editing the specified resource.
 */
public
function edit(string $id)
{
    //
}

/**
 * Update the specified resource in storage.
 */

/**
 * @OA\Put(
 *      path="/api/availabilities/{id}",
 *      operationId="updateavailability",
 *      tags={"Availabilities"},
 *      summary="Update existing availability",
 *      description="Returns updated availability data",
 *           @OA\Parameter(
 *           name="id",
 *           description="Availability id",
 *           required=true,
 *           in="path",
 *           @OA\Schema(
 *               type="integer"
 *           )
 *       ),
 *          @OA\Parameter(
 *              name="Accept-Language",
 *              in="header",
 *              description="Set language parameter",
 *              @OA\Schema(
 *                  type="string",
 *                  enum={"en", "ar"},
 *                  default="en"
 *              ),
 *              example="en"
 *       ),
 *            @OA\Parameter(
 *               name="_method",
 *               in="header",
 *               example="put"
 *        ),
 *     @OA\Parameter(
 * name="type",
 * in="query",
 * description="type",
 * @OA\Schema(type="string")
 * ),
 *      *
 *     @OA\Parameter(
 * name="date[]",
 * in="query",
 * description="date[]",
 * @OA\Schema(type="date")
 * ),
 *
@OA\Parameter(
 * name="room_id",
 * in="query",
 * description="room_id",
 * @OA\Schema(type="string")
 * ),
 * @OA\Parameter(
 * name="hotel_id",
 * in="query",
 * description="hotel_id",
 * @OA\Schema(type="string")
 * ),
 *
 * @OA\Response(
 *          response=202,
 *          description="Successful operation",
 *       ),
 * @OA\Response(
 *          response=400,
 *          description="Bad Request"
 *      ),
 * @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 * @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      ),
 * @OA\Response(
 *          response=404,
 *          description="Resource Not Found"
 *      )
 * )
 */


public
function update(AvailabilityRequest $request, $id)
{
    $request_data = $request->all();
    if (!empty($request['date'])) {
        Availability::where('hotel_id', $request->hotel_id)->where('created_by', auth()->user()->id)->where('room_id', $request->room_id)->delete();
        foreach ($request['date'] as $value) {
            $data = Availability::create([
                'date' => $value,
                'hotel_id' => $request->hotel_id,
                'room_id' => $request->room_id,
                'type' => 'available',
                'created_by' => auth()->user()->id
            ]);
        }
    }
    return self::makeSuccess(200, __('messages.updated_successfully'), $data);

}

/**
 * Remove the specified resource from storage.
 */

/**
 * @OA\Delete(
 *      path="/api/availabilities/{id}",
 *      operationId="deleteAvailability",
 *      tags={"Availabilities"},
 *      summary="Delete existing Availability",
 *      description="Deletes a record and returns no content",
 *      @OA\Parameter(
 *          name="id",
 *          description="Availability id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=204,
 *          description="Successful operation",
 *          @OA\JsonContent()
 *       ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 *      @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Resource Not Found"
 *      )
 * )
 */


public
function destroy(string $id)
{
    $data = Availability::find($id);
    if (!$data) {
        return self::makeError(404, __('messages.not_found'));
    }
    $data->delete();
    return self::makeSuccess(200, __('messages.delete_successfully'));

}

}
