<?php

namespace App\Http\Controllers\Api\Owner\Chains;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Chains\StorechainsRequest;
use App\Http\Requests\Api\Chains\UpdatechainsRequest;
use App\Http\Resources\Api\Chains\ChainResource;
use App\Http\Resources\Api\DocumentResource;
use App\Http\Resources\Api\Hotels\HotelResource;
use App\Models\Chains\chains;
use App\Models\Chains\VerificationDocument;
use App\Models\Hotels\Hotels;
use App\Services\Chains\ChainService;
use App\Services\Documents\DocumentService;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use OpenApi\Annotations as OA;

class ChainsController extends Controller
{
    use ApiResponse;


    protected $service;
    protected $document;

    public function __construct(ChainService $service, DocumentService $document)
    {
        $this->service = $service;
        $this->document = $document;
    }

    /**
     * @OA\Get(
     *     path="/api/chains",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with name_ar, name_en,image,active, hotels_count, and user_id",
     *     tags={"Chains"},
     *          @OA\Parameter(
     *           name="Accept-Language",
     *           in="header",
     *           description="Set language parameter by ",
     *       @OA\Schema(
     *               type="string",
     *               enum={"en", "ar"},
     *               default="en"
     *           ),
     *           example="en"
     *       ),
     *      security={{"bearer": {}}},
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
     *                     example="Name AR"
     *                 ),
     *                     @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     description="image",
     *                     example="image"
     *                 ),
     *                          @OA\Property(
     *                     property="active",
     *                     type="string",
     *                     description="active",
     *                     example="active"
     *                 ),
     *
     *                  @OA\Property(
     *                     property="hotels_count",
     *                     type="integer",
     *                     description="hotels_count",
     *                     example="Name AR"
     *                 ),
     *
     *                 @OA\Property(
     *                      property="user_id",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                     example="1"
     *                  ),
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
            $wheres[] = ['creator_id', '=', auth()->user()->id];
            $orWheres[] = ['name_en', 'like', '%' . $request->search . '%'];
            $orWheres[] = ['name_ar', 'like', '%' . $request->search . '%'];
        }
        $wheres[] = ['user_id', auth()->user()->id];
        $result = $this->service->getAll($is_paginate, $wheres, $wheresIn, $with, $withCount, $orWheres);
        return self::makeSuccess(200, __('messages.success'), ChainResource::collection($result), !$is_paginate);

    }


    /**
     * Store a newly created resource in storage.
     */


    /**
     * @OA\Post(
     *     path="/api/chains",
     *     summary="Add chains",
     *      tags={"Chains"},
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
    @OA\Schema(type="string")
    ),
     *        @OA\Parameter(
    name="image",
    in="query",
    description="image",
    @OA\Schema(type="file")
    ),
     *        @OA\Parameter(
    name="active",
    in="query",
    description="active",
    @OA\Schema(type="integer")
    ),

    @OA\Parameter(
    name="hotels_count",
    in="query",
    description="hotels_count",
    @OA\Schema(type="integer")
    ),

    @OA\Parameter(
    name="user_id",
    in="query",
    description="User Id",
    @OA\Schema(type="integer")
    ),
     *     @OA\Response(response="201", description="User registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function store(StorechainsRequest $request)
    {
        $data = $request->validated();
        $data['creator_id'] = auth()->user()->id;
        $chain = Chains::create($data);
        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image');
            $destinationPath = 'images/chains/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $chain->image = $filename;
            $chain->save();
        }
        return self::makeSuccess(200, __('messages.created_successfully'), ChainResource::make($chain));


    }

    /**
     * Display the specified resource.
     */


    /**
     * @OA\Get(
     *      path="/api/chains/{id}",
     *      operationId="getChainById",
     *      tags={"Chains"},
     *      summary="Get Chain information",
     *      description="Returns Chain data",
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
     *          description="Chain id",
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
            return self::makeSuccess(200, __('messages.success'), ChainResource::make($chain));
        }

        return self::makeError(404, __('messages.not_found'));

    }



    /**
     * Update the specified resource in storage.
     */

    /**
     * @OA\Put(
     *      path="/api/chains/{id}",
     *      operationId="updateChain",
     *      tags={"Chains"},
     *      summary="Update existing Chain",
     *      description="Returns updated Chain data",
     *           @OA\Parameter(
     *           name="id",
     *           description="Chain id",
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
    @OA\Schema(type="string")
    ),
     *      @OA\Parameter(
    name="image",
    in="query",
    description="image",
    @OA\Schema(type="file")
    ),
     *          @OA\Parameter(
    name="active",
    in="query",
    description="active",
    @OA\Schema(type="integer")
    ),

    @OA\Parameter(
    name="hotels_count",
    in="query",
    description="hotels_count",
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="user_id",
    in="query",
    description="User Id",
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

    public function update(UpdatechainsRequest $request, chains $chain)
    {
        $data = $request->validated();
        $data['update_id'] = auth()->user()->id;
        $chain->update($data);

        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image');
            $destinationPath = 'images/chains/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $chain->image = $filename;
            $chain->save();
        }
        return self::makeSuccess(200, __('messages.updated_successfully'), ChainResource::make($chain));
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *      path="/api/chains/{id}",
     *      operationId="deleteChain",
     *      tags={"Chains"},
     *      summary="Delete existing Chain",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Chain id",
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
        $chain = Chains::find($id);
        if (!$chain) {
            return self::makeError(404, __('messages.not_found'));
        }
        $chain->delete();
        return self::makeSuccess(200, __('messages.delete_successfully'));

    }


    /*
     *
     * */


    /**
     * @OA\Get(
     *     path="/api/chains/document/list",
     *     summary="Get a list  document of entries with columns",
     *     description="Retrieve a list  document of entries with name_ar, name_en,hotels_count,  and user_id",
     *     tags={"Chains"},
     *          @OA\Parameter(
     *           name="Accept-Language",
     *           in="header",
     *           description="Set language parameter by ",
     *       @OA\Schema(
     *               type="string",
     *               enum={"en", "ar"},
     *               default="en"
     *           ),
     *           example="en"
     *       ),
     *      security={{"bearer": {}}},
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
     *                     example="Name AR"
     *                 ),
     *
     *                 @OA\Property(
     *                      property="user_id",
     *                      type="string",
     *                      description="Code (5 characters max)",
     *                     example="1"
     *                  ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No entries found"
     *     )
     * )
     */

    public function list(Request $request)
    {
        $wheresIn = $with = $wheres = $withCount = $orWheres = [];
        $is_paginate = $request->is_paginate ?? 0;
        if ($request->search) {
            $wheres[] = ['name_en', 'like', '%' . $request->search . '%'];
            $orWheres[] = ['name_ar', 'like', '%' . $request->search . '%'];
        }

        $result = $this->document->getAll($is_paginate, $wheres, $wheresIn, $with, $withCount, $orWheres);
        return self::makeSuccess(200, __('messages.success'), DocumentResource::collection($result), !$is_paginate);

    }

    /*
     *
     * */

    /**
     * @OA\Post(
     * path="/api/chains/document/upload",
     *summary="Add document chains",
     *tags={"Chains"},
    @OA\Parameter(
    name="chain_id",
    in="query",
    description="chain_id",
    required=true,
    @OA\Schema(type="integer")
    ),
    @OA\Parameter(
    name="document",
    in="query",
    description="document",
    required=true,
    @OA\Schema(type="file")
    ),
     *     @OA\Response(response="201", description="Document chains registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function upload(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,docx',
            'chain_id' => 'required|exists:chains,id'
        ]);
        $checkDocument = $this->document->uploadFile($request);
        if ($checkDocument) {
            return self::makeSuccess(200, __('messages.upload_document'), DocumentResource::make($checkDocument));
        }
        return self::makeError(404, __('messages.wrong'));

    }

    /*
     *
     * */
    public function deleteDocument(Request $request)
    {
        $request->validate(['id' => 'required|exists:verification_documents,id']);
        $document = VerificationDocument::findOrFail($request->id);
        if ($document) {

            if (Storage::exists($document->document_path)) {
                Storage::delete($document->document_path);
            }
            $document->delete();

            return self::makeSuccess(200, __('messages.delete_successfully'));

        }
        return self::makeError(404, __('messages.not_found'));

    }

    public function review(Request $request)
    {
        $document = $this->document->review($request);
        return self::makeSuccess(200, __('messages.review_successfully'));
    }


    /**
     * @OA\Post(
     *     path="/api/chains/block",
     *     summary="Update Active chain",
     *      tags={"Chains"},
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="chain Id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="201", description="chain Updated Active successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function block(Request $request)
    {

        $data = Chains::find($request->id);
        if (!$data) {
            return self::makeError(404, __('messages.not_found'));
        }

        $status = ($data->active == 0) ? 1 : 0;

        $data->active = $status;

        $data->save();

        return self::makeSuccess(200, __('messages.status updated successfully.'), $data);


    }

    /**
     * @OA\Get(
     *     path="/api/chains/{id}/hotels",
     *     tags={"Chains"},
     *     summary="Get Hotels by  Chain ID",
     *     description="Retrieve details of a specific Hotels by its ID",
     *     operationId="getHotelsByChainsId",
     *     security={{"bearer": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Chain to retrieve",
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
    public function getHotelsInChain($id)
    {

        $Hotels = Hotels::with('chain')->where('chain_id', $id)->get();
        return self::makeSuccess(200, __("messages.success"), HotelResource::collection($Hotels));

    }

}
