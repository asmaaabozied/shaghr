<?php

namespace App\Http\Controllers\Api\Owner\Services;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Services\ServiceRequest;
use App\Http\Resources\Api\Pages\ServiceResource;
use App\Models\Pages\Service;
use App\Services\Pages\ServiceService;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ApiResponse;


    /**
     * @OA\Get(
     *     path="/api/services",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with name_en, name_ar, type, description_ar,description_en,image, and active",
     *     tags={"Services"},

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
     *                     example="Service Name EN"
     *                 ),
     *                 @OA\Property(
     *                     property="name_ar",
     *                     type="string",
     *                     description="Arabic name",
     *                     example="اسم الخدمه "
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example="Type"
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
     *                     property="image",
     *                     type="string",
     *                     description="Icon URL",
     *                     nullable=true,
     *                     example="http://example.com/image.png"
     *                 ),
     *                 @OA\Property(
     *                     property="active",
     *                     type="boolean",
     *                     description="Whether the entry is active",
     *                     example=true
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

    public function index()
    {
        $data = ServiceResource::collection(Service::get());

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
     *     path="/api/services",
     *     summary="Add Service",
     *      tags={"Services"},
     *
     *               @OA\Parameter(
     *           name="name_en",
     *           in="query",
     *           description="Name English",
     *           required=true,
     *           @OA\Schema(type="string")
     *       ),
     *               @OA\Parameter(
     *           name="name_ar",
     *           in="query",
     *           description="Name Arabic",
     *           required=true,
     *           @OA\Schema(type="string")
     *       ),
     *            @OA\Parameter(
     *            name="type",
     *            description="Type",
     *            in="query",
     *            @OA\Schema(
     *                type="string"
     *            )
     *        ),
     *              @OA\Parameter(
     *            name="description_ar",
     *            description="description Arabic",
     *            in="query",
     *            @OA\Schema(
     *                type="string"
     *            )
     *        ),
     *              @OA\Parameter(
     *            name="description_en",
     *            description="description English",
     *            in="query",
     *            @OA\Schema(
     *                type="string"
     *            )
     *        ),
     *         @OA\Parameter(
     *            name="image",
     *            description="Image",
     *            in="query",
     *            @OA\Schema(
     *                type="string"
     *            )
     *        ),
     *             @OA\Parameter(
     *            name="active",
     *            description="active",
     *            in="query",
     *            @OA\Schema(
     *                type="integer"
     *            )
     *        ),
     *     @OA\Response(response="201", description="Roles registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */


    public function store(ServiceRequest $request)
    {
        $request_data = $request->except('image');
        $request_data['created_by'] = auth()->user()->id ?? null;
        $data = Service::create($request_data);

        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image');
            $destinationPath = 'images/services/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $data->image = $filename;
            $data->save();
        }

        return self::makeSuccess(200, __('messages.created_successfully'), $data);


    }


    /**
     * @OA\Get(
     *      path="/api/services/{id}",
     *      operationId="getServiceById",
     *      tags={"Services"},
     *      summary="Get Service information",
     *      description="Returns Service data",
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
     *          description="Service id",
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
        $data = Service::find($id);
        try {
            if (!$data) {
                // Handle the case where the country is not found
                return self::makeError(404 , __('messages.not_found') );

            }
            // Return success if the country is found
            return self::makeSuccess(200, __("messages.success"), ServiceResource::make($data));

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
     *      path="/api/services/{id}",
     *      operationId="updateService",
     *      tags={"Services"},
     *      summary="Update existing Service",
     *      description="Returns updated Service data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Service id",
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
     *          name="name_en",
     *          in="query",
     *          description="Name English",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *              @OA\Parameter(
     *          name="name_ar",
     *          in="query",
     *          description="Name Arabic",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *           @OA\Parameter(
     *           name="type",
     *           description="Type",
     *           in="query",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *             @OA\Parameter(
     *           name="description_ar",
     *           description="description Arabic",
     *           in="query",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *             @OA\Parameter(
     *           name="description_en",
     *           description="description English",
     *           in="query",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *        @OA\Parameter(
     *           name="image",
     *           description="Image",
     *           in="query",
     *           @OA\Schema(
     *               type="string"
     *           )
     *       ),
     *            @OA\Parameter(
     *           name="active",
     *           description="active",
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
    function update(ServiceRequest $request, string $id)
    {
        $data = Service::find($id);

        $data->update($request->except('image'));
        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image');
            $destinationPath = 'images/services/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $data->image = $filename;
            $data->save();
        }

        return self::makeSuccess(200, __('messages.updated_successfully'), $data);

    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *      path="/api/services/{id}",
     *      operationId="deleteService",
     *      tags={"Services"},
     *      summary="Delete existing Service",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Service id",
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
        $data = Service::find($id);

        $data->delete();


        return self::makeSuccess(200, __('messages.delete_successfully'));

    }


    /**
     * @OA\Post(
     *     path="/api/service/block",
     *     summary="Update Active Service",
     *      tags={"Services"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Service Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="Service Updated Active successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function block(Request $request)
    {

        $data = Service::find($request->id);

        $status = ($data->active == 0) ? 1 : 0;

        $data->active = $status;

        $data->save();

        return self::makeSuccess(200, __('messages.status updated successfully.'), $data);


    }

}
