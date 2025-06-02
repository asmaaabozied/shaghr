<?php

namespace App\Http\Controllers\Api\Rooms;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Rooms\FavouriteRoomRequest;
use App\Models\Hotels\Hotels;
use App\Models\Rooms\AmenityRoom;
use App\Models\Rooms\Availability;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\Rooms\RoomRequest;
use App\Models\User\User;
use App\Http\Resources\Api\Rooms\RoomResource;
use App\Models\Rooms\Room;
use App\Models\Rooms\RoomImage;
use App\Services\Rooms\RoomService;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    use ApiResponse;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;

    }

    /**
     * @OA\Get(
     *     path="/api/rooms",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with name_ar, name_en, title_en,title_ar,space,pricing,active,description_ar,description_en,hotel_id, and status",
     *     tags={"Rooms"},

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
     *                 @OA\Property(
     *                     property="name_en",
     *                     type="string",
     *                     description="English name",
     *                     example="Name EN"
     *                 ),
     *                 @OA\Property(
     *                     property="name_ar",
     *                     type="string",
     *                     description="Arabic name",
     *                     example="Name Ar"
     *                 ),
     *                     @OA\Property(
     *                     property="description_ar",
     *                     type="string",
     *                     description="Arabic name",
     *                     example="Description Ar"
     *                 ),
     *                    @OA\Property(
     *                     property="description_en",
     *                     type="string",
     *                     description="English name",
     *                     example="Description En"
     *                 ),
     *                 @OA\Property(
     *                     property="title_en",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example="Title En"
     *                 ),
     *                      @OA\Property(
     *                      property="title_ar",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example="Title Ar"
     *                  ),
     *                       @OA\Property(
     *                      property="space",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example="space"
     *                  ),
     *                        @OA\Property(
     *                      property="pricing",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example="pricing"
     *                  ),
     *            @OA\Property(
     *                      property="active",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example=true
     *                  ),
     *                  @OA\Property(
     *                      property="status",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example=true
     *                  ),
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

    public function index(Request $request)
    {

        $wheresIn = $with = $wheres = $withCount = $orWheres = [];
        $is_paginate = $request->is_paginate ?? 0;
        if ($request->search) {
            $orWheres[] = ['name_en', 'like', '%' . $request->search . '%'];
            $orWheres[] = ['name_ar', 'like', '%' . $request->search . '%'];
        }
        $wheres[] = ['created_by', '=', auth()->user()->id];

        $result = $this->roomService->getAll($is_paginate, $wheres, $wheresIn, $with, $withCount, $orWheres);

        return self::makeSuccess(200, 'data retrieved successfully.', RoomResource::collection($result), !$is_paginate);


    }

    /**
     * @OA\Post(
     *     path="/api/rooms/favourite",
     *     summary="Add favourite rooms",
     *      tags={"Rooms"},
     *     @OA\Parameter(
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
     *     @OA\Parameter(
     *         name="room_id",
     *         in="query",
     *         description="room_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="Rooms Add Favourite successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function addFavourite(FavouriteRoomRequest $request)
    {

        $user_id = Auth::id();
        $user = User::find($user_id);
        $data = $user->favouritesRoom()->toggle($request->room_id);
        $status = ($data['attached'] !== []) ? 'favourite' : 'unfavourite';
        return self::makeSuccess(200, __('messages.success'), $status);

    }

    /**
     * @OA\Get(
     *     path="/api/rooms/get-active",
     *     summary="Get a list of Active entries with columns",
     *     description="Retrieve a list of entries with name_ar, name_en, title_en,title_ar,space,pricing,active,description_ar,description_en, and status",
     * *     tags={"Rooms"},



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
    @OA\Property(
    property="name_en",
    type="string",
    description="English name",
    example="Name EN"
    ),
    @OA\Property(
    property="name_ar",
    type="string",
    description="Arabic name",
    example="Name Ar"
    ),
    @OA\Property(
    property="description_ar",
    type="string",
    description="Arabic name",
    example="Description Ar"
    ),
    @OA\Property(
    property="description_en",
    type="string",
    description="English name",
    example="Description En"
    ),
    @OA\Property(
    property="title_en",
    type="string",
    description="Code (5 characters max)",
    example="Title En"
    ),
    @OA\Property(
    property="title_ar",
    type="string",
    description="Code (5 characters max)",
    example="Title Ar"
    ),
    @OA\Property(
    property="space",
    type="string",
    description="Code (5 characters max)",
    example="space"
    ),
    @OA\Property(
    property="pricing",
    type="string",
    description="Code (5 characters max)",
    example="pricing"
    ),
    @OA\Property(
    property="active",
    type="string",
    description="Code (5 characters max)",
    example=true
    ),
    @OA\Property(
    property="status",
    type="string",
    description="Code (5 characters max)",
    example=true
    ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No entries found"
     *     )
     * )
     */
    public function getActive()
    {
        $data = RoomResource::collection(Room::where('active', '=', 1)->get());

        return self::makeSuccess(200, __("messages.success"), $data);


    }

    /**
     * @OA\Post(
     *     path="/api/rooms/update-active",
     *     summary="Update Active Room",
     *      tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Room Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="Room Updated Status successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function updateActive(Request $request)
    {

        $data = Room::find($request->id);

        $status = ($data->active == 0) ? 1 : 0;

        $data->active = $status;

        $data->save();

        return self::makeSuccess(200, __('messages.status updated successfully.'), $data);


    }

    function str_random($length = 4)
    {
        return Str::random($length);
    }

    function str_slug($title, $separator = '-', $language = 'en')
    {
        return Str::slug($title, $separator, $language);
    }

    public function AddImage(Request $request)
    {
        if ($request->file('images')) {
            $imagess = $request->file('images');
            foreach ($imagess as $images) {

                $img = "";
                $img = $this->str_random(4) . $images->getClientOriginalName();
                $originname = time() . '.' . $images->getClientOriginalName();
                $filename = $this->str_slug(pathinfo($originname, PATHINFO_FILENAME), "-");
                $filename = $images->hashName();
                $extention = pathinfo($originname, PATHINFO_EXTENSION);
                $img = $filename;
                $destintion = 'images/rooms';
                $images->move($destintion, $img);
                $data->image = $img;
                $data->save();

            }
            $data = RoomImage::create(['room_id' => $request['id']]);

        }


        return self::makeSuccess(200, 'data added successfully.', $request);

    }


    /**
     * @OA\Get(
     *     path="/api/rooms/show-image",
     *     summary="Update Image Room",
     *      tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Room Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="Room Updated Status successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function ShowImage(Request $request)
    {
        $data = RoomImage::where('room_id', '=', $request['id'])->get();
        try {
            if (!$data) {
                // Handle the case where the country is not found
                return self::makeError(404, __("messages.data"));
            }
            // Return success if the country is found
            return self::makeSuccess(200, __("messages.success"), $data);

        } catch (\Throwable $th) {
            // Handle any other exceptions
            return self::makeError(400, $th->getMessage());
        }


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * @OA\Post(
     *     path="/api/rooms",
     *     summary="Add Room",
     *      tags={"Rooms"},
    @OA\Parameter(
    name="title_en",
    in="query",
    description="Title English",
    required=true,
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="title_ar",
    in="query",
    description="Title Arabic",
    @OA\Schema(type="string")
    ),
     *           @OA\Parameter(
    name="prices[]",
    in="query",
    description="Prices",
    @OA\Schema(type="string")
    ),
     *
     *           @OA\Parameter(
    name="number_people",
    in="query",
    description="number_people",
    @OA\Schema(type="integer")
    ),
     *

    @OA\Parameter(
    name="images[]",
    in="query",
    description="Images",
    @OA\Schema(type="file")
    ),
    @OA\Parameter(
    name="amenities[]",
    in="query",
    description="amenities",
    @OA\Schema(type="string")
    ),

    @OA\Parameter(
    name="description_ar",
    in="query",
    description="Description Arabic",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="description_en",
    in="query",
    description="Description English",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="active",
    in="query",
    description="active",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="space",
    in="query",
    description="space",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="pricing",
    in="query",
    description="pricing",
    @OA\Schema(type="integer")
    ),
     *     @OA\Parameter(
     * name="hotel_id",
     * in="query",
     * description="hotel_id",
     * @OA\Schema(type="integer")
     * ),
     *        @OA\Parameter(
     * name="availabilities",
     * in="query",
     * description="availabilities[]",
     * @OA\Schema(type="integer")
     * ),
    @OA\Parameter(
    name="status",
    in="query",
    description="status",
    @OA\Schema(type="integer")
    ),
     *     @OA\Response(response="201", description="User registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function store(RoomRequest $request)
    {
        $data_request = $request->except('images', 'amenities', 'availabilities');
        $data_request['created_by'] = auth()->user()->id;
        $data_request['status']=Hotels::find($request['hotel_id'])->status;
        $data = Room::create($data_request);
        if ($request->amenities) {
            $data->amenities()->attach($request->amenities);

        }
        if ($request->prices) {
            $data->prices()->createMany($request->prices);

        }
        if ($request->availabilities) {
            foreach ($request['availabilities'] as $value)
            Availability::create([
                'date' => $value,
                'hotel_id' => $request->hotel_id,
                'room_id' => $data['id'],
                'type' => 'available',
                'created_by'=>auth()->user()->id,

            ]);
        }


        if ($request->file('images')) {

            $imagess = $request->file('images');
            foreach ($imagess as $images) {

                $img = "";
                $img = $this->str_random(4) . $images->getClientOriginalName();
                $originname = time() . '.' . $images->getClientOriginalName();
                $filename = $this->str_slug(pathinfo($originname, PATHINFO_FILENAME), "-");
                $filename = $images->hashName();
                $extention = pathinfo($originname, PATHINFO_EXTENSION);
                $img = $filename;
                $destintion = 'images/rooms';
                $images->move($destintion, $img);
                $dataimage = RoomImage::create(['room_id' => $data['id']]);
                $dataimage->image = $img;
                $dataimage->save();

            }

        }


        return self::makeSuccess(200, __('messages.created_successfully'), $data);


    }

    /**
     * Display the specified resource.
     */


    /**
     * @OA\Get(
     *      path="/api/rooms/{id}",
     *      operationId="getRoomById",
     *      tags={"Rooms"},
     *      summary="Get Room information",
     *      description="Returns Room data",
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
     *          description="Room id",
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
        $data = Room::with(['amenities','availabilities','images','prices','comments','reviews','roomTypes'])->find($id);
        try {
            if (!$data) {
                // Handle the case where the country is not found
                return self::makeError(404, __('messages.not_found'));

            }
            // Return success if the country is found
            return self::makeSuccess(200, __("messages.success"), RoomResource::make($data));

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
     *      path="/api/rooms/{id}",
     *      operationId="updateRoom",
     *      tags={"Rooms"},
     *      summary="Update existing Room",
     *      description="Returns updated Room data",
     *
     *           @OA\Parameter(
     *           name="id",
     *           description="Room id",
     *           required=true,
     *           in="path",
     *           @OA\Schema(
     *               type="integer"
     *           )
     *       ),
    @OA\Parameter(
    name="Accept-Language",
    in="header",
    description="Set language parameter",
    @OA\Schema(
    type="string",
    enum={"en", "ar"},
    default="en"
    ),
    example="en"
    ),
    @OA\Parameter(
    name="_method",
    in="header",
    example="put"
    ),
     *     @OA\Parameter(
    name="title_en",
    in="query",
    description="Title English",
    required=true,
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="title_ar",
    in="query",
    description="Title Arabic",
    @OA\Schema(type="string")
    ),
     *
     *
     *           @OA\Parameter(
     * name="availabilities[]",
     * in="query",
     * description="availabilities[]",
     * @OA\Schema(type="string")
     * ),
    @OA\Parameter(
    name="prices[]",
    in="query",
    description="Prices",
    @OA\Schema(type="string")
    ),



    @OA\Parameter(
    name="number_people",
    in="query",
    description="number_people",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="images[]",
    in="query",
    description="Images",
    @OA\Schema(type="file")
    ),
     *       @OA\Parameter(
    name="amenities[]",
    in="query",
    description="amenities",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="description_ar",
    in="query",
    description="Description Arabic",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="description_en",
    in="query",
    description="Description English",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="active",
    in="query",
    description="active",
    @OA\Schema(type="integer")
    ),
     *       @OA\Parameter(
    name="hotel_id",
    in="query",
    description="hotel_id",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="space",
    in="query",
    description="space",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="pricing",
    in="query",
    description="pricing",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="status",
    in="query",
    description="status",
    @OA\Schema(type="integer")
    ),
     *      @OA\Response(
     *          response=202,
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
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

    public
    function update(RoomRequest $request, string $id)
    {


        $data = Room::find($id);

        $data->update($request->except('images', 'amenities', 'availabilities'));


        if (!empty($request->amenities)) {


            $data->amenities()->sync($request->amenities);
        }

        if (!empty($request->prices)) {
            $data->prices()->delete();

            $data->prices()->createMany($request->prices);

        }

        if (!empty($request->availabilities)) {

            $data->availabilities()->delete();
            foreach ($request['availabilities'] as $value)
            Availability::create([
                    'date' => $value,
                    'hotel_id' => $request->hotel_id,
                    'room_id' => $data['id'],
                    'type' => 'available',
                ]);
        }
        if($request->images_ids)
             $data->images()->whereNotIn('id', $request->images_ids)->delete();
         else
             $data->images()->delete();

        if (!empty($request->file('images'))) {



            $imagess = $request->file('images');
            foreach ($imagess as $images) {

                $img = "";
                $img = $this->str_random(4) . $images->getClientOriginalName();
                $originname = time() . '.' . $images->getClientOriginalName();
                $filename = $this->str_slug(pathinfo($originname, PATHINFO_FILENAME), "-");
                $filename = $images->hashName();
                $extention = pathinfo($originname, PATHINFO_EXTENSION);
                $img = $filename;
                $destintion = 'images/rooms';
                $images->move($destintion, $img);

                $dataimage = RoomImage::create(['room_id' => $id]);
                $dataimage->image = $img;
                $dataimage->save();

            }

        }


        return self::makeSuccess(200, __('messages.updated_successfully'), $data);

    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *      path="/api/rooms/{id}",
     *      operationId="deleteRoom",
     *      tags={"Rooms"},
     *      summary="Delete existing Room",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Room id",
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
        $data = Room::find($id);

        if (!$data) {
            return self::makeError(404, __('messages.not_found'));
        }

        $data->images()->delete();
        $data->amenities()->detach();
        $data->prices()->delete();
        $data->availabilities()->delete();
        $data->delete();
        return self::makeSuccess(200, __('messages.delete_successfully'));

    }

}
