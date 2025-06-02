<?php

namespace App\Http\Controllers\Api\Owner\Hotels;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Hotels\FavouriteHotelsRequest;
use App\Http\Requests\Api\Hotels\StoreAddressHotelsRequest;
use App\Http\Requests\Api\Hotels\StoreHotelsRequest;
use App\Http\Requests\Api\Hotels\UpdateHotelsRequest;
use App\Http\Resources\Api\Hotels\HotelResource;
use App\Http\Resources\Api\Rooms\RoomResource;
use App\Models\Chains\Chains;
use App\Models\Hotels\HotelImage;
use App\Models\Hotels\Hotels;
use App\Models\Rooms\Room;
use App\Models\User\User;
use App\Services\Chains\HotelService;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HotelsController extends Controller
{
    use ApiResponse;

    protected HotelService $service;

    public function __construct(HotelService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */

    /**
     * @OA\Get(
     *     path="/api/hotels",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with name_en, name_ar,total_rooms,rating,street,building_number,country_id,city_id,district_id and chain_id",
     *     tags={"Hotels"},

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
     *                     example="AmenitiesTypes Name EN"
     *                 ),
     *                 @OA\Property(
     *                     property="name_ar",
     *                     type="string",
     *                     description="Arabic name",
     *                     example="AmenitiesTypes Name AR"
     *                 ),
     *        @OA\Property(
     *                     property="total_rooms",
     *                     type="string",
     *                     description="total_rooms",
     *                     example="2"
     *                 ),
     *        @OA\Property(
     *                     property="rating",
     *                     type="string",
     *                     description="rating",
     *                     example="rating"
     *                 ),
     *        @OA\Property(
     *                     property="building_number",
     *                     type="string",
     *                     description="building_number",
     *                     example="122"
     *                 ),
     *        @OA\Property(
     *                     property="street",
     *                     type="string",
     *                     description="street",
     *                     example="street"
     *                 ),
     *                 @OA\Property(
     *                     property="chain_id",
     *                     type="integer",
     *                     description="Code (5 characters max)",
     *                     example=true
     *                 ),
     *     @OA\Property(
     *                     property="country_id",
     *                     type="integer",
     *                     description="Code (5 characters max)",
     *                     example=true
     *                 ),
     *      @OA\Property(
     *                     property="city_id",
     *                     type="integer",
     *                     description="Code (5 characters max)",
     *                     example=true
     *                 ),
     *      *      @OA\Property(
     *                     property="district_id",
     *                     type="integer",
     *                     description="Code (5 characters max)",
     *                     example=true
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


    public function index(Request $request)
    {
        $wheresIn = $with = $wheres = $withCount = $orWheres = [];
        $is_paginate = $request->is_paginate ?? 0;
        if ($request->search) {
            $orWheres[] = ['name_en', 'like', '%' . $request->search . '%'];
            $orWheres[] = ['name_ar', 'like', '%' . $request->search . '%'];
        }
        $wheres[] = ['creator_id',auth()->user()->id];

        $with = ['country', 'city', 'district', 'chain'];

        $result = $this->service->getAll($is_paginate, $wheres, $wheresIn, $with, $withCount, $orWheres);
        return self::makeSuccess(200, __('messages.success'), HotelResource::collection($result), !$is_paginate);

    }
    /**
     * @OA\Post(
     *     path="/api/hotels/favourite",
     *     summary="Add favourite hotels",
     *      tags={"Hotels"},
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
     *         name="hotel_id",
     *         in="query",
     *         description="hotel_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),


     *     @OA\Response(response="201", description="Hotels Add Favourite successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function addFavourite(FavouriteHotelsRequest $request)
    {

        $user_id = Auth::id();
        $user = User::find($user_id);
        $data = $user->favourites()->toggle($request->hotel_id);
        $status = ($data['attached'] !== []) ? 'favourite' : 'unfavourite';
        return self::makeSuccess(200, __('messages.success'), $status);

    }

    function str_random($length = 4)
    {
        return Str::random($length);
    }

    function str_slug($title, $separator = '-', $language = 'en')
    {
        return Str::slug($title, $separator, $language);
    }
    /**
     * Store a newly created resource in storage.
     */

    /**
     * @OA\Post(
     *     path="/api/hotels",
     *     summary="Add hotels",
     *      tags={"Hotels"},
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
     *         name="chain_id",
     *         in="query",
     *         description="chain_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *          @OA\Parameter(
     *         name="name_en",
     *         in="query",
     *         description="Name English",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *         @OA\Parameter(
     *         name="name_ar",
     *         in="query",
     *         description="Name Arabic",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *           @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         description="phone",
     *         @OA\Schema(type="string")
     *     ),
     *               @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email",
     *         @OA\Schema(type="string")
     *     ),
     *
     *                 @OA\Parameter(
     *         name="total_rooms",
     *         in="query",
     *         description="total_rooms",
     *         @OA\Schema(type="string")
     *     ),
     *
     *                  @OA\Parameter(
     *         name="building_number",
     *         in="query",
     *         description="building_number",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="descripton_en",
     *         in="query",
     *         description="descripton_en",
     *         @OA\Schema(type="string")
     *     ),
     *         @OA\Parameter(
     *         name="descripton_ar",
     *         in="query",
     *         description="descripton_ar",
     *         @OA\Schema(type="string")
     *     ),
     *
     *   *         @OA\Parameter(
     *         name="hotel_policy_ar",
     *         in="query",
     *         description="hotel_policy_ar",
     *         @OA\Schema(type="string")
     *     ),
     *
     *   *         @OA\Parameter(
     *         name="hotel_policy_en",
     *         in="query",
     *         description="hotel_policy_en",
     *         @OA\Schema(type="string")
     *     ),
     *              @OA\Parameter(
     *          name="address",
     *          in="query",
     *          description="address",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *                   @OA\Parameter(
     *          name="images[]",
     *          in="query",
     *          description="images",
     *          required=true,
     *          @OA\Schema(type="file")
     *      ),
     *                       @OA\Parameter(
     *          name="document",
     *          in="query",
     *          description="document",
     *          required=true,
     *          @OA\Schema(type="file")
     *      ),
     *          @OA\Parameter(
     *          name="country_id",
     *          in="query",
     *          description="country_id",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *            @OA\Parameter(
     *          name="city_id",
     *          in="query",
     *          description="city_id",
     *          @OA\Schema(type="integer")
     *      ),
     *                @OA\Parameter(
     *          name="district_id",
     *          in="query",
     *          description="district_id",
     *          @OA\Schema(type="integer")
     *      ),
     *     @OA\Response(response="201", description="Hotels registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */


    public function store(StoreHotelsRequest $request)
    {
        $data = $request->except('images', 'document');
        $softDeletedChain = Chains::withTrashed()->find($data['chain_id']);
        if ($softDeletedChain->trashed()) {
            return self::makeError(400, __('messages.softDeleteError'));

        }
        $data['creator_id'] = auth()->user()->id;

        $hotel = Hotels::create($data);

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
                $destintion = 'images/hotels';
                $images->move($destintion, $img);
                $dataimage = HotelImage::create(['hotel_id' => $hotel['id']]);
                $dataimage->image = $img;
                $dataimage->save();

            }

        }

        if ($request->hasFile('document')) {
            $thumbnail = $request->file('document');
            $destinationPath = 'images/hotels/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $hotel->document = $filename;
            $hotel->save();
        }

        return self::makeSuccess(200, __('messages.created_successfully'), $hotel);

    }

    /**
     * @OA\Post(
     *     path="/api/addressHotel",
     *     summary="Add AddressHotel",
     *      tags={"Hotels"},
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
     *         name="id",
     *         in="query",
     *         description="id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *         @OA\Parameter(
     *         name="address",
     *         in="query",
     *         description="address",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *         @OA\Parameter(
     *         name="country_id",
     *         in="query",
     *         description="country_id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *           @OA\Parameter(
     *         name="city_id",
     *         in="query",
     *         description="city_id",
     *         @OA\Schema(type="integer")
     *     ),
     *               @OA\Parameter(
     *         name="district_id",
     *         in="query",
     *         description="district_id",
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(response="201", description="Hotels registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function addressHotel(StoreAddressHotelsRequest $request)
    {
        $data = $request->validated();
        $hotel = Hotels::find($request['id']);
        $hotel->update([
            'address' => $request['address'],
            'country_id' => $request['country_id'],
            'city_id' => $request['city_id'],
            'district_id' => $request['district_id'],
        ]);
        return self::makeSuccess(200, __('messages.created_successfully'), $hotel);

    }

    /**
     * @OA\Get(
     *      path="/api/hotels/{id}",
     *      operationId="getHotelById",
     *      tags={"Hotels"},
     *      summary="Get Hotel information",
     *      description="Returns Hotel data",
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
     *          description="Hotel id",
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
    public function show($id)
    {
        if ($this->service->checkExists(["id" => $id])) {
            $chain = $this->service->showById($id);
            return self::makeSuccess(200, __('messages.success'), HotelResource::make($chain));
        }

        return self::makeError(404, __('messages.not_found'));

    }


    /**
     * @OA\Put(
     *      path="/api/hotels/{id}",
     *      operationId="updateHotel",
     *      tags={"Hotels"},
     *      summary="Update existing Hotel",
     *      description="Returns updated Hotel data",
    @OA\Parameter(
    name="id",
    in="path",
    description="Id",
    required=true,
    @OA\Schema(type="integer")
    ),
     *          @OA\Parameter(
     *             name="Accept-Language",
     *             in="header",
     *             description="Set language parameter",
     *             @OA\Schema(
     *                 type="string",
     *                 enum={"en", "ar"},
     *                 default="en"
     *             ),
     *             example="en"
     *      ),
     *           @OA\Parameter(
     *              name="_method",
     *              in="header",
     *              example="put"
     *       ),
     *
    @OA\Parameter(
    name="name_en",
    in="query",
    description="Name English",
    required=true,
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="name_ar",
    in="query",
    description="Name Arabic",
    required=true,
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="chain_id",
    in="query",
    description="chain_id",
    required=true,
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="phone",
    in="query",
    description="phone",
    @OA\Schema(type="string")
    ),

       @OA\Parameter(
    name="hotel_policy_en",
    in="query",
    description="hotel_policy_en",
    @OA\Schema(type="string")
    ),
          @OA\Parameter(
    name="hotel_policy_ar",
    in="query",
    description="hotel_policy_ar",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="email",
    in="query",
    description="email",
    @OA\Schema(type="string")
    ),

    @OA\Parameter(
    name="total_rooms",
    in="query",
    description="total_rooms",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="images[]",
    in="query",
    description="images[]",
    @OA\Schema(type="file")
    ),
     *
    @OA\Parameter(
    name="document",
    in="query",
    description="document",
    @OA\Schema(type="file")
    ),
    @OA\Parameter(
    name="building_number",
    in="query",
    description="building_number",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="descripton_en",
    in="query",
    description="descripton_en",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="descripton_ar",
    in="query",
    description="descripton_ar",
    @OA\Schema(type="string")
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
    public function update(UpdateHotelsRequest $request, Hotels $hotel)
    {
        $data = $request->except('images', 'document','images_ids');
        $hotel->update($data);
        if ($request->hasFile('document')) {
            $thumbnail = $request->file('document');
            $destinationPath = 'images/hotels/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $hotel->document = $filename;
            $hotel->save();
        }
        if($request->images_ids)
           $hotel->images()->whereNotIn('id', $request->images_ids)->delete();
        else
            $hotel->images()->delete();

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
                $destintion = 'images/hotels';
                $images->move($destintion, $img);
                $dataimage = HotelImage::create(['hotel_id' => $hotel['id']]);
                $dataimage->image = $img;
                $dataimage->save();

            }

        }

        return self::makeSuccess(200, __('messages.updated_successfully'), HotelResource::make($hotel));
    }

    /**
     * @OA\Delete(
     *      path="/api/hotels/{id}",
     *      operationId="deleteHotels",
     *      tags={"Hotels"},
     *      summary="Delete existing Hotel",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Hotel id",
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
    public function destroy($id)
    {
        $hotel = Hotels::find($id);
        if (!$hotel) {
            return self::makeError(404, __('messages.not_found'));
        }
        $hotel->delete();
        return self::makeSuccess(200, __('messages.delete_successfully'));
    }

    /**
     * @OA\Post(
     *     path="/api/hotels/block",
     *     summary="Update Active hotels",
     *      tags={"Hotels"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="hotel Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="hotels Updated Status successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */



    public function block(Request $request)
    {
        $data = Hotels::find($request->id);
        if (!$data) {
            return self::makeError(404, __('messages.not_found'));
        }
        $status = ($data->status == 0) ? 1 : 0;

        $data->status = $status;

        $data->save();

        return self::makeSuccess(200, __('messages.status updated successfully.'), $data);
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/{id}/rooms",
     *     tags={"Hotels"},
     *     summary="Get Rooms by  Hotel ID",
     *     description="Retrieve details of a specific Rooms by its ID.",
     *     operationId="getRoomsByHotelId",
     *     security={{"bearer": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Hotel to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *           name="Accept-Language",
     *           in="header",
     *           description="Set language parameter",
     *           @OA\Schema(
     *               type="string",
     *               enum={"en", "ar"},
     *               default="en"
     *           ),
     *           example="en"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Room not found",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "Room not found"}
     *         )
     *     )
     * )
     */
    public function getRoomsInHotel($id)
    {

        $Rooms = Room::where('hotel_id' , $id)->get();
        return self::makeSuccess(200, __("messages.success"), RoomResource::collection($Rooms));

    }


    /**
     * @OA\Get(
     *     path="/api/city/hotels/{id}",
     *     tags={"Hotels"},
     *     summary="Get Hotel by  City ID",
     *     description="Retrieve details of a specific Hotels by its CityID.",
     *     operationId="getHotelInCity",
     *     security={{"bearer": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the city to retrieve Hotels",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             example=1
     *         )
     *     ),
     *     @OA\Parameter(
     *           name="Accept-Language",
     *           in="header",
     *           description="Set language parameter",
     *           @OA\Schema(
     *               type="string",
     *               enum={"en", "ar"},
     *               default="en"
     *           ),
     *           example="en"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hotel not found",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "Hotel not found"}
     *         )
     *     )
     * )
     */
    public function getHotelInCity($id)
    {

        $hotels = Hotels::where('city_id' ,'=', $id)->get();
        return self::makeSuccess(200, __("messages.success"), HotelResource::collection($hotels));

    }



}
