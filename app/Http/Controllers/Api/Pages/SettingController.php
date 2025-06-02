<?php

namespace App\Http\Controllers\Api\Pages;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Chains\Requests\Api\Pages\PageRequest;
use App\Http\Resources\Api\Pages\PageResource;
use App\Models\Pages\Page;
use App\Models\PartnerLog;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Get(
     *     path="/api/partnerlogo",
     *     summary="Get a list of entries with columns",
     *     description="Retrieve a list of entries with image, and id",
     *     tags={"Logo"},
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
     *                     property="image",
     *                     type="file",
     *                     description="Image",
     *                     example="Image"
     *                 ),
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

        $data = PartnerLog::get();


        return self::makeSuccess(200, __("messages.success"), $data);

    }

    /**
     * @OA\Post(
     *     path="/api/partnerlogo/store",
     *     summary="Add Logo",
     *      tags={"Logo"},
    @OA\Parameter(
    name="image",
    in="query",
    description="Image",
    required=true,
    @OA\Schema(type="file")
    ),

     *     @OA\Response(response="201", description="User registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */

    public function store(Request $request){

        $data=new PartnerLog();

        if ($request->hasFile('image')) {
            $thumbnail = $request->file('image');
            $destinationPath = 'images/logo/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $data->image = $filename;
            $data->save();
        }

        return self::makeSuccess(200, __("messages.success"), $data);

    }


}
