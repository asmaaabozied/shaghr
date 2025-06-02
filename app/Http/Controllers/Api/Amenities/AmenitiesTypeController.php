<?php

namespace App\Http\Controllers\Api\Amenities;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Amenities\AmenitiesTypeRequest;
use App\Http\Resources\Api\Amenities\AmenitiesTypeResource;
use App\Models\Amenities\AmenitiesType;
use App\Services\Amenities\AmenitiesTypeService;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class AmenitiesTypeController extends Controller
{
    use ApiResponse;

    public function __construct(readonly AmenitiesTypeService $AmenitiesType)
    {

    }


    /**
     * @OA\Get(
     *     path="/api/amenities-types",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with name_en, name_ar, and status",
     *     tags={"AmenitiesTypes"},

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
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
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
            $wheres[] = ['name_en', 'like', '%' . $request->search . '%'];
            $orWheres[] = ['name_ar', 'like', '%' . $request->search . '%'];
        }

        $result = $this->AmenitiesType->getAll($is_paginate, $wheres, $wheresIn, $with, $withCount, $orWheres);
        return self::makeSuccess(200, __("messages.success"), AmenitiesTypeResource::collection($result), !$is_paginate);


    }


    /**
     * @OA\Get(
     *     path="/api/amenities-types/get-active",
     *     summary="Get a list of AmenitiesTypes entries with columns",
     *     description="Retrieve a list of  AmenitiesTypes entries with name_en, name_ar, status, description_ar,description_en,icon, and type_id",
     *     tags={"AmenitiesTypes"},


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
     * *                     property="name_en",
     * *                     type="string",
     * *                     description="English name",
     * *                     example="AmenitiesTypes Name EN"
     * *                 ),
     * *                 @OA\Property(
     * *                     property="name_ar",
     * *                     type="string",
     * *                     description="Arabic name",
     * *                     example="AmenitiesTypes Name AR"
     * *                 ),
     * *                 @OA\Property(
     * *                     property="status",
     * *                     type="string",
     * *                     description="Code (5 characters max)",
     * *                     example=true
     * *                 ),
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
        $data = AmenitiesTypeResource::collection(AmenitiesType::where('status', '=', 1)->get());

        return self::makeSuccess(200, __("messages.success"), $data);


    }


    /**
     * @OA\Post(
     *     path="/api/amenities-types/update-active",
     *     summary="Update Active AmenitiesTypes",
     *      tags={"AmenitiesTypes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="AmenitiesType Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="AmenitiesType registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function updateActive(Request $request)
    {
        $data = AmenitiesType::find($request->id);

        $status = ($data->status == 0) ? 1 : 0;

        $data->status = $status;

        $data->save();

        return self::makeSuccess(200, __('messages.status updated successfully.'), $data);


    }

    /**
     * @OA\Get(
     *     path="/api/amenities-types/get-deleted",
     *     summary="Get a list of Deleted AmenitiesTypes  with columns",
     *     description="Retrieve a list of  Deleted AmenitiesTypes with name_en, name_ar, status, description_ar,description_en,icon, and type_id",
     *     tags={"AmenitiesTypes"},


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

        $data = AmenitiesTypeResource::collection(AmenitiesType::onlyTrashed()->get());

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
     * @OA\Post(
     *     path="/api/amenities-types",
     *     summary="Add Amenities Type",
     *      tags={"AmenitiesTypes"},
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
     *     @OA\Response(response="201", description="Amenities registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function store(AmenitiesTypeRequest $request)
    {
        $data_request = $request->all();
        $data_request['created_by'] = auth()->user()->id ?? null;
        $data = AmenitiesType::create($data_request);


        return self::makeSuccess(200, __('messages.created_successfully'), $data);


    }


    /**
     * @OA\Get(
     *      path="/api/amenities-types/{id}",
     *      operationId="getAmenityTypeById",
     *      tags={"AmenitiesTypes"},
     *      summary="Get AmenityType information",
     *      description="Returns AmenityType data",
     *     @OA\Parameter(
     * name="Accept-Language",
     * in="header",
     * description="Set language parameter by ",
     * @OA\Schema(
     * type="string",
     * enum={"en", "ar"},
     * default="en"
     * ),
     * example="en"
     * ),
     * security={{"bearer": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="AmenityType id",
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
        $data = AmenitiesType::find($id);

        try {
            if (!$data) {
                // Handle the case where the country is not found
                return self::makeError(404 , __('messages.not_found') );

            }
            // Return success if the country is found
            return self::makeSuccess(200, __("messages.success"), AmenitiesTypeResource::make($data));

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
     *      path="/api/amenities-types/{id}",
     *      operationId="updateAmenityType",
     *      tags={"AmenitiesTypes"},
     *      summary="Update existing AmenityType",
     *      description="Returns updated AmenityType data",
     *      @OA\Parameter(
     *          name="id",
     *          description="AmenityType id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *               @OA\Parameter(
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
     *          @OA\Parameter(
     *          name="name_ar",
     *          in="query",
     *          description="Name Arabic",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *           @OA\Parameter(
     *           name="name_en",
     *           description="Name English",
     *           in="query",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *             @OA\Parameter(
     *           name="status",
     *           description="status",
     *           in="query",
     *           @OA\Schema(
     *               type="integer"
     *           )
     *       ),
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
    function update(AmenitiesTypeRequest $request, string $id)
    {
        $data = AmenitiesType::find($id);

        $data->update($request->all());


        return self::makeSuccess(200, __('messages.updated_successfully'), $data);

    }


    /**
     * @OA\Delete(
     *      path="/api/amenities-types/{id}",
     *      operationId="deleteAmenityType",
     *      tags={"AmenitiesTypes"},
     *      summary="Delete existing AmenityType",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="AmenityType id",
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
        $data = AmenitiesType::find($id);
        if(!$data){
            return self::makeError(404 , __('messages.not_found') );
        }
        $data->delete();


        return self::makeSuccess(200, __('messages.delete_successfully'));

    }

}
