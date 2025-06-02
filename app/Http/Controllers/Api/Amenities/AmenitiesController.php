<?php

namespace App\Http\Controllers\Api\Amenities;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Amenities\AmenitiesRequest;
use App\Http\Resources\Api\Amenities\AmenitiesResource;
use App\Models\Amenities\Amenity;
use App\Services\Amenities\AmenitiesService;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class AmenitiesController extends Controller
{
    use ApiResponse;


    public function __construct(readonly AmenitiesService $Amenities)
    {

    }


    /**
     * @OA\Get(
     *     path="/api/amenities",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with name_en, name_ar, status, description_ar,description_en,icon, and type_id",
     *     tags={"Amenities"},


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
     *                     example="Amenity Name EN"
     *                 ),
     *                 @OA\Property(
     *                     property="name_ar",
     *                     type="string",
     *                     description="Arabic name",
     *                     example="Amenity Name AR"
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example=true
     *                 ),
     *                      @OA\Property(
     *                      property="description_ar",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example="description_ar"
     *                  ),
     *                 @OA\Property(
     *                      property="description_en",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example="description_en"
     *                  ),
     *                 @OA\Property(
     *                     property="icon",
     *                     type="string",
     *                     description="Icon URL",
     *                     nullable=true,
     *                     example="http://example.com/icon.png"
     *                 ),
     *                 @OA\Property(
     *                     property="type_id",
     *                     type="boolean",
     *                     description="Whether the entry is active",
     *                     example=1
     *                 )
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
            $wheres[] = ['name_en', 'like', '%' . $request->search . '%'];
            $orWheres[] = ['name_ar', 'like', '%' . $request->search . '%'];
        }

        $result = $this->Amenities->getAll($is_paginate, $wheres, $wheresIn, $with, $withCount, $orWheres);
        return self::makeSuccess(200, __("messages.success"), AmenitiesResource::collection($result), !$is_paginate);


    }


    /**
     * @OA\Get(
     *     path="/api/amenities/get-active",
     *     summary="Get a list of Active entries with columns",
     *     description="Retrieve a list of  Active entries with name_en, name_ar, status, description_ar,description_en,icon, and type_id",
     *     tags={"Amenities"},


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
     *                     example="Amenity Name EN"
     *                 ),
     *                 @OA\Property(
     *                     property="name_ar",
     *                     type="string",
     *                     description="Arabic name",
     *                     example="Amenity Name AR"
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example=true
     *                 ),
     *                      @OA\Property(
     *                      property="description_ar",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example="description_ar"
     *                  ),
     *                 @OA\Property(
     *                      property="description_en",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example="description_en"
     *                  ),
     *                 @OA\Property(
     *                     property="icon",
     *                     type="string",
     *                     description="Icon URL",
     *                     nullable=true,
     *                     example="http://example.com/icon.png"
     *                 ),
     *                 @OA\Property(
     *                     property="type_id",
     *                     type="boolean",
     *                     description="Whether the entry is active",
     *                     example=1
     *                 )
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
        $data = AmenitiesResource::collection(Amenity::where('status', '=', 1)->get());

        return self::makeSuccess(200, __("messages.success"), $data);


    }


    /**
     * @OA\Post(
     *     path="/api/amenities/update-active",
     *     summary="Update Active Amenities",
     *      tags={"Amenities"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Amenity Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="Amenities registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function updateActive(Request $request)
    {

        $data = Amenity::find($request->id);

        $status = ($data->status == 0) ? 1 : 0;

        $data->status = $status;

        $data->save();

        return self::makeSuccess(200, __('messages.status updated successfully.'), $data);


    }


    /**
     * @OA\Get(
     *     path="/api/amenities/get-deleted",
     *     summary="Get a list of Deleted entries with columns",
     *     description="Retrieve a list of  Deleted entries with name_en, name_ar, status, description_ar,description_en,icon, and type_id",
     *     tags={"Amenities"},


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
     *                     example="Amenity Name EN"
     *                 ),
     *                 @OA\Property(
     *                     property="name_ar",
     *                     type="string",
     *                     description="Arabic name",
     *                     example="Amenity Name AR"
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example=true
     *                 ),
     *                      @OA\Property(
     *                      property="description_ar",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example="description_ar"
     *                  ),
     *                 @OA\Property(
     *                      property="description_en",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example="description_en"
     *                  ),
     *                 @OA\Property(
     *                     property="icon",
     *                     type="string",
     *                     description="Icon URL",
     *                     nullable=true,
     *                     example="http://example.com/icon.png"
     *                 ),
     *                 @OA\Property(
     *                     property="type_id",
     *                     type="boolean",
     *                     description="Whether the entry is active",
     *                     example=1
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No entries found"
     *     )
     * )
     */

    public function getDeleted()
    {

        $data = AmenitiesResource::collection(Amenity::onlyTrashed()->get());

        return self::makeSuccess(200, __("messages.success"), $data);
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
     *     path="/api/amenities",
     *     summary="Add Amenities",
     *      tags={"Amenities"},
     *     @OA\Parameter(
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
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Status",
     *         @OA\Schema(type="integer")
     *     ),
     *         @OA\Parameter(
     *         name="type_id",
     *         in="query",
     *         description="Type Id",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="description_ar",
     *         in="query",
     *         description="Description Arabic",
     *         @OA\Schema(type="longText")
     *     ),
     *       @OA\Parameter(
     *         name="description_en",
     *         in="query",
     *         description="Description English",
     *         @OA\Schema(type="longText")
     *     ),
     *
     *           @OA\Parameter(
     *         name="icon",
     *         in="query",
     *         description="Icon",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="Amenities registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */


    public function store(AmenitiesRequest $request)
    {
        $data_request = $request->all();
        $data_request['created_by'] = auth()->user()->id ?? null;

        $data = Amenity::create($data_request);

        if ($request->hasFile('icon')) {
            $thumbnail = $request->file('icon');
            $destinationPath = 'images/amenities/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $data->icon = $filename;
            $data->save();
        }


        return self::makeSuccess(200, __('messages.created_successfully'), $data);


    }


    /**
     * @OA\Get(
     *      path="/api/amenities/{id}",
     *      operationId="getAmenityById",
     *      tags={"Amenities"},
     *      summary="Get Amenity information",
     *      description="Returns Amenity data",
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
     *          description="Amenity id",
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
        $data = Amenity::find($id);


        try {
            if (!$data) {
                // Handle the case where the country is not found
                return self::makeError(404 , __('messages.not_found') );

            }
            // Return success if the country is found
            return self::makeSuccess(200, __("messages.success"), AmenitiesResource::make($data));

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
     * @OA\Put(
     *      path="/api/amenities/{id}",
     *      operationId="updateAmenity",
     *      tags={"Amenities"},
     *      summary="Update existing Amenity",
     *      description="Returns updated Amenity data",
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
     *      @OA\Parameter(
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
    name="status",
    in="query",
    description="Status",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="type_id",
    in="query",
    description="Type Id",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="description_ar",
    in="query",
    description="Description Arabic",
    @OA\Schema(type="longText")
    ),
    @OA\Parameter(
    name="description_en",
    in="query",
    description="Description English",
    @OA\Schema(type="longText")
    ),

    @OA\Parameter(
    name="icon",
    in="query",
    description="Icon",
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

    public
    function update(AmenitiesRequest $request, string $id)
    {

        $data = Amenity::find($id);

        $data->update($request->all());

        if ($request->hasFile('icon')) {
            $thumbnail = $request->file('icon');
            $destinationPath = 'images/amenities/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $data->icon = $filename;
            $data->save();
        }


        return self::makeSuccess(200, __('messages.updated_successfully'), $data);

    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *      path="/api/amenities/{id}",
     *      operationId="deleteAmenities",
     *      tags={"Amenities"},
     *      summary="Delete existing Amenity",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Amenity id",
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
        $data = Amenity::find($id);
        if(!$data){
            return self::makeError(404 , __('messages.not_found') );
        }

        $data->delete();


        return self::makeSuccess(200, __('messages.delete_successfully'));

    }

}
