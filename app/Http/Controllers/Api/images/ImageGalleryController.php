<?php

namespace App\Http\Controllers\Api\images;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Images\ImageGalleryRequest;
use App\Http\Resources\Api\Images\ImageGalleryResource;
use App\Models\Images\ImageGallery;
use App\Services\images\ImageGalleryService;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class ImageGalleryController extends Controller
{
    use ApiResponse;

    public function __construct(readonly ImageGalleryService $imageservice)
    {

    }

    /**
     * @OA\Get(
     *     path="/api/image-galleries",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with title_ar, title_en, image_name, extension,image,size,thumbnail,status,alternative_text_ar,alternative_text_en and published",
     *     tags={"ImageGalleries"},

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
     *                     property="title_en",
     *                     type="string",
     *                     description="English name",
     *                     example="Title EN"
     *                 ),
     *                 @OA\Property(
     *                     property="title_ar",
     *                     type="string",
     *                     description="Arabic name",
     *                     example="اTitle AR"
     *                 ),
     *                 @OA\Property(
     *                     property="image_name",
     *                     type="string",
     *                     description="Code (5 characters max)",
     *                     example="image_name"
     *                 ),
     *                      @OA\Property(
     *                      property="extension",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example="extension"
     *                  ),
     *                 @OA\Property(
     *                      property="image",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                     example="http://example.com/image.png"
     *                  ),
     *              @OA\Property(
     *                      property="size",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example="size"
     *                  ),
     *       @OA\Property(
     *                      property="thumbnail",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                      example="thumbnail"
     *                  ),
     *                 @OA\Property(
     *                     property="alternative_text_ar",
     *                     type="boolean",
     *                     description="Whether the entry is active",
     *                     example="alternative_text_ar"
     *                 ) ,
     *                  @OA\Property(
     *                     property="alternative_text_en",
     *                     type="boolean",
     *                     description="Whether the entry is active",
     *                     example="alternative_text_en"
     *                 ) ,
     *        @OA\Property(
     *                     property="published",
     *                     type="boolean",
     *                     description="Whether the entry is active",
     *                     example=true
     *                 ) ,
     *               @OA\Property(
     *                     property="status",
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

    public function index(Request $request)
    {

        $wheresIn = $with = $wheres = $withCount = $orWheres = [];
        $is_paginate = $request->is_paginate ?? 0;
        if ($request->search) {
            $wheres[] = ['title_ar', 'like', '%' . $request->search . '%'];
            $orWheres[] = ['title_en', 'like', '%' . $request->search . '%'];
        }

        $result = $this->imageservice->getAll($is_paginate, $wheres, $wheresIn, $with, $withCount, $orWheres);
        return self::makeSuccess(200,  __("messages.success"), ImageGalleryResource::collection($result), !$is_paginate);


    }


    /**
     * @OA\Get(
     *     path="/api/image-galleries/get-active",
     *     summary="Get a list of Active entries with columns",
     *     description="Retrieve a list of entries with title_ar, title_en, image_name, extension,image,size,thumbnail,status,alternative_text_ar,alternative_text_en and published",
     * *     tags={"ImageGalleries"},



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
    property="title_en",
    type="string",
    description="English name",
    example="Title EN"
    ),
    @OA\Property(
    property="title_ar",
    type="string",
    description="Arabic name",
    example="اTitle AR"
    ),
    @OA\Property(
    property="image_name",
    type="string",
    description="Code (5 characters max)",
    example="image_name"
    ),
    @OA\Property(
    property="extension",
    type="string",
    description="Code (5 characters max)",
    example="extension"
    ),
    @OA\Property(
    property="image",
    type="string",
    description="Code (5 characters max)",
    example="http://example.com/image.png"
    ),
    @OA\Property(
    property="size",
    type="string",
    description="Code (5 characters max)",
    example="size"
    ),
    @OA\Property(
    property="thumbnail",
    type="string",
    description="Code (5 characters max)",
    example="thumbnail"
    ),
    @OA\Property(
    property="alternative_text_ar",
    type="boolean",
    description="Whether the entry is active",
    example="alternative_text_ar"
    ) ,
    @OA\Property(
    property="alternative_text_en",
    type="boolean",
    description="Whether the entry is active",
    example="alternative_text_en"
    ) ,
    @OA\Property(
    property="published",
    type="boolean",
    description="Whether the entry is active",
    example=true
    ) ,
    @OA\Property(
    property="status",
    type="boolean",
    description="Whether the entry is active",
    example=true
    )
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
        $data = ImageGalleryResource::collection(ImageGallery::where('status', '=', 1)->get());

        return self::makeSuccess(200,  __("messages.success"), $data);


    }

    /**
     * @OA\Get(
     *     path="/api/image-galleries/get-publish",
     *     summary="Get a list of Publish entries with columns",
     *     description="Retrieve a list of  Publish entries with title_ar, title_en, image_name, extension,image,size,thumbnail,status,alternative_text_ar,alternative_text_en and published",
     * *     tags={"ImageGalleries"},



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
    property="title_en",
    type="string",
    description="English name",
    example="Title EN"
    ),
    @OA\Property(
    property="title_ar",
    type="string",
    description="Arabic name",
    example="اTitle AR"
    ),
    @OA\Property(
    property="image_name",
    type="string",
    description="Code (5 characters max)",
    example="image_name"
    ),
    @OA\Property(
    property="extension",
    type="string",
    description="Code (5 characters max)",
    example="extension"
    ),
    @OA\Property(
    property="image",
    type="string",
    description="Code (5 characters max)",
    example="http://example.com/image.png"
    ),
    @OA\Property(
    property="size",
    type="string",
    description="Code (5 characters max)",
    example="size"
    ),
    @OA\Property(
    property="thumbnail",
    type="string",
    description="Code (5 characters max)",
    example="thumbnail"
    ),
    @OA\Property(
    property="alternative_text_ar",
    type="boolean",
    description="Whether the entry is active",
    example="alternative_text_ar"
    ) ,
    @OA\Property(
    property="alternative_text_en",
    type="boolean",
    description="Whether the entry is active",
    example="alternative_text_en"
    ) ,
    @OA\Property(
    property="published",
    type="boolean",
    description="Whether the entry is active",
    example=true
    ) ,
    @OA\Property(
    property="status",
    type="boolean",
    description="Whether the entry is active",
    example=true
    )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No entries found"
     *     )
     * )
     */
    public function getPublish()
    {
        $data = ImageGalleryResource::collection(ImageGallery::where('published', '=', 1)->get());

        return self::makeSuccess(200,  __("messages.success"), $data);


    }


    /**
     * @OA\Post(
     *     path="/api/image-galleries/update-publish",
     *     summary="Update Publish ImageGalleries",
     *      tags={"ImageGalleries"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="ImageGallery Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="ImageGallery Updated Publish successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function updatePublish(Request $request)
    {
        $data = ImageGallery::find($request->id);

        $status = ($data->published == 0) ? 1 : 0;

        $data->published = $status;

        $data->save();

        return self::makeSuccess(200, __('messages.status updated successfully.'), $data);


    }


    /**
     * @OA\Post(
     *     path="/api/image-galleries/update-active",
     *     summary="Update Active ImageGalleries",
     *      tags={"ImageGalleries"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="ImageGallery Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="ImageGallery Updated Active successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function updateActive(Request $request)
    {
        $data = ImageGallery::find($request->id);

        $status = ($data->status == 0) ? 1 : 0;

        $data->status = $status;

        $data->save();

        return self::makeSuccess(200, __('messages.status updated successfully.'), $data);


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
     *     path="/api/image-galleries",
     *     summary="Add ImageGalleries",
     *      tags={"ImageGalleries"},
     *     @OA\Parameter(
     *         name="title_en",
     *         in="query",
     *         description="Title English",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="title_ar",
     *         in="query",
     *         description="Title Arabic",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="image_name",
     *         in="query",
     *         description="image_name",
     *         @OA\Schema(type="string")
     *     ),
     *         @OA\Parameter(
     *         name="extension",
     *         in="query",
     *         description="extension",
     *         @OA\Schema(type="string")
     *     ),
     *        @OA\Parameter(
     *         name="image",
     *         in="query",
     *         description="Image",
     *         @OA\Schema(type="string")
     *     ),
     *           @OA\Parameter(
     *         name="size",
     *         in="query",
     *         description="Size",
     *         @OA\Schema(type="string")
     *     ),
     *              @OA\Parameter(
     *         name="thumbnail",
     *         in="query",
     *         description="Thumbnail",
     *         @OA\Schema(type="string")
     *     ),
     *                 @OA\Parameter(
     *         name="alternative_text_ar",
     *         in="query",
     *         description="AlternativeText Arabic",
     *         @OA\Schema(type="string")
     *     ),
     *                     @OA\Parameter(
     *         name="alternative_text_en",
     *         in="query",
     *         description="AlternativeText English",
     *         @OA\Schema(type="string")
     *     ),
     *          @OA\Parameter(
     *         name="published",
     *         in="query",
     *         description="published",
     *         @OA\Schema(type="integer")
     *     ),
     *              @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="status",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="ImageGalleries registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */


    public function store(ImageGalleryRequest $request)
    {

        $data_request = $request->except('image', 'thumbnail');
        $data_request['created_by'] = auth()->user()->id ?? null;
        $data = ImageGallery::create($data_request);
        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image');
            $destinationPath = 'images/images/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $data->image = $filename;
            $data->save();
        }
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $destinationPath = 'images/images/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $data->thumbnail = $filename;
            $data->save();
        }

        return self::makeSuccess(200, __('messages.created_successfully'), $data);


    }

    /**
     * Display the specified resource.
     */


    /**
     * @OA\Get(
     *      path="/api/image-galleries/{id}",
     *      operationId="getImageGalleriesById",
     *      tags={"ImageGalleries"},
     *      summary="Get ImageGalleries information",
     *      description="Returns ImageGalleries data",
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
     *          description="ImageGallery id",
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
        $data =ImageGallery::find($id);
        try {
            if (!$data) {
                // Handle the case where the country is not found
                return self::makeError(404 , __('messages.not_found') );

            }
            // Return success if the country is found
            return self::makeSuccess(200, __("messages.success"), ImageGalleryResource::make($data));

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
     *      path="/api/image-galleries/{id}",
     *      operationId="updateImageGallery",
     *      tags={"ImageGalleries"},
     *      summary="Update existing ImageGallery",
     *      description="Returns updated ImageGallery data",
     *           @OA\Parameter(
     *           name="id",
     *           description="ImageGallery id",
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
    @OA\Parameter(
    name="image_name",
    in="query",
    description="image_name",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="extension",
    in="query",
    description="extension",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="image",
    in="query",
    description="Image",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="size",
    in="query",
    description="Size",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="thumbnail",
    in="query",
    description="Thumbnail",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="alternative_text_ar",
    in="query",
    description="AlternativeText Arabic",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="alternative_text_en",
    in="query",
    description="AlternativeText English",
    @OA\Schema(type="string")
    ),
    @OA\Parameter(
    name="published",
    in="query",
    description="published",
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
    function update(ImageGalleryRequest $request, string $id)
    {

        $data = ImageGallery::find($id);

        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image');
            $destinationPath = 'images/images/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $data->image = $filename;
            $data->save();
        }
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $destinationPath = 'images/images/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $data->thumbnail = $filename;
            $data->save();
        }

        $data->update($request->all());


        return self::makeSuccess(200, __('messages.updated_successfully'), $data);

    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *      path="/api/image-galleries/{id}",
     *      operationId="deleteImageGalleries",
     *      tags={"ImageGalleries"},
     *      summary="Delete existing ImageGallery",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="ImageGallery id",
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
        $data = ImageGallery::find($id);
        if(!$data){
            return self::makeError(404 , __('messages.not_found') );
        }
        $data->delete();
        return self::makeSuccess(200, __('messages.delete_successfully'));

    }



}
