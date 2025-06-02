<?php


use App\Http\Controllers\Api\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Api\Amenities\AmenitiesController;
use App\Http\Controllers\Api\Amenities\AmenitiesTypeController;
use App\Http\Controllers\Api\Booking\BookingController;
use App\Http\Controllers\Api\Faqs\FaqController;
use App\Http\Controllers\Api\images\ImageGalleryController;
use App\Http\Controllers\Api\Owner\Auth\OwnerAuthController;
use App\Http\Controllers\Api\Owner\Chains\ChainsController;
use App\Http\Controllers\Api\Owner\Features\FeatureController;
use App\Http\Controllers\Api\Owner\Hotels\HotelsController;
use App\Http\Controllers\Api\Owner\Places\CityController;
use App\Http\Controllers\Api\Owner\Places\CountryController;
use App\Http\Controllers\Api\Owner\Places\DistrictController;
use App\Http\Controllers\Api\Owner\Services\ServiceController;
use App\Http\Controllers\Api\Pages\PageController;
use App\Http\Controllers\Api\Roles\RoleController;
use App\Http\Controllers\Api\Rooms\AvailabilityController;
use App\Http\Controllers\Api\Rooms\RoomController;
use App\Http\Controllers\Api\Rooms\FacilityController;
use App\Http\Controllers\Api\Rooms\CommentController;
use App\Http\Controllers\Api\Rooms\ReviewController;
use App\Http\Controllers\Api\Rooms\RoomTypesController;
use App\Http\Controllers\Api\SearchEngine\SearchEngineController;
use App\Http\Controllers\Api\Testimonials\TestimonialsController;
use App\Http\Controllers\Api\User\Auth\LoginController;
use App\Http\Controllers\Api\User\Auth\ProfileController;
use App\Http\Controllers\Api\User\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('/user/register', [RegisterController::class, 'register']);
Route::post('/user/login', [LoginController::class, 'login']);
Route::post('/password/forgot', [LoginController::class, 'sendResetLinkEmail']);
Route::post('/password/reset', [LoginController::class, 'resetPassword']);
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/countries/getCode', [CountryController::class, 'getCode']);
Route::get('/partnerlogo', [\App\Http\Controllers\Api\Pages\SettingController::class, 'index']);
Route::post('/partnerlogo/store', [\App\Http\Controllers\Api\Pages\SettingController::class, 'store']);
Route::post('/owner/login', [OwnerAuthController::class, 'login']);
//start Testimonials
Route::post('testimonials/update-publish', [TestimonialsController::class, 'updatePublish']);
Route::post('testimonials/update-active', [TestimonialsController::class, 'updateActive']);
Route::post('testimonials/update-status', [TestimonialsController::class, 'updateStatus']);
Route::get('testimonials/get-publish', [TestimonialsController::class, 'getPublish']);
Route::get('testimonials/get-active', [TestimonialsController::class, 'getActive']);
Route::get('testimonials/get-status', [TestimonialsController::class, 'getStatus']);
Route::apiResource('testimonials', TestimonialsController::class);
//end Testimonials


Route::middleware('auth:api')
    ->group(function () {
        Route::get("booking/guest", [BookingController::class,'listGuest']);

        Route::get('/user/profile', [ProfileController::class, 'show']);
        Route::put('/user/update', [ProfileController::class, 'update']);
        Route::apiResource('countries', CountryController::class);
        Route::get('cities/{id}/districts', [CityController::class,'getDistrictsInCities']);
        Route::apiResource('cities', CityController::class);

        Route::apiResource('districts', DistrictController::class);
        Route::post('/chains/block', [ChainsController::class, 'block']);
        Route::post('chains/document/upload', [ChainsController::class, 'upload']);
        Route::post('chains/document/review', [ChainsController::class, 'review']);
        Route::delete('chains/document/delete', [ChainsController::class, 'deleteDocument']);
        Route::get('chains/document/list', [ChainsController::class, 'list']);
        Route::apiResource('chains', ChainsController::class);
        Route::get('chains/{id}/hotels', [ChainsController::class,'getHotelsInChain']);

        Route::post('addressHotel', [HotelsController::class, 'addressHotel']);
        Route::post('hotels/favourite', [HotelsController::class, 'addFavourite']);
        Route::post('hotels/block', [HotelsController::class, 'block']);
        Route::apiResource('hotels', HotelsController::class);
        Route::get('hotels/{id}/rooms', [HotelsController::class,'getRoomsInHotel']);

//Start Roles
        Route::apiResource('roles', RoleController::class);
//end Roles

        Route::post('/service/block', [ServiceController::class, 'block']);
        Route::apiResource('services', ServiceController::class);
        Route::post('/feature/block', [FeatureController::class, 'block']);
        Route::apiResource('features', FeatureController::class);
        Route::post('/page/block', [PageController::class, 'block']);
// Start api amenities && Amenitytypes
        Route::get('amenities-types/get-deleted', [AmenitiesTypeController::class, 'getDeleted']);
        Route::get('amenities-types/get-active', [AmenitiesTypeController::class, 'getActive']);
        Route::post('amenities-types/update-active', [AmenitiesTypeController::class, 'updateActive']);
        Route::apiResource('amenities-types', AmenitiesTypeController::class);
        Route::get('amenities/get-deleted', [AmenitiesController::class, 'getDeleted']);
        Route::get('amenities/get-active', [AmenitiesController::class, 'getActive']);
        Route::post('amenities/update-active', [AmenitiesController::class, 'updateActive']);
        Route::apiResource('amenities', AmenitiesController::class);
// End api amenities && Amenitytypes
// start as image-galleries
        Route::post('image-galleries/update-publish', [ImageGalleryController::class, 'updatePublish']);
        Route::post('image-galleries/update-active', [ImageGalleryController::class, 'updateActive']);
        Route::get('image-galleries/get-publish', [ImageGalleryController::class, 'getPublish']);
        Route::get('image-galleries/get-active', [ImageGalleryController::class, 'getActive']);
        Route::apiResource('image-galleries', ImageGalleryController::class);
//end as image-galleries
// start  all  rooms
        Route::post('search/availabilities', [AvailabilityController::class, 'searchAvailability']);

        Route::resource('availabilities', AvailabilityController::class);
        Route::get('rooms/get-active', [RoomController::class, 'getActive']);
        Route::post('rooms/update-active', [RoomController::class, 'updateActive']);
        Route::post('rooms/add-image', [RoomController::class, 'AddImage']);
        Route::post('rooms/favourite', [RoomController::class, 'addFavourite']);
        Route::get('rooms/show-image', [RoomController::class, 'ShowImage']);
        Route::apiResource('rooms', RoomController::class);
        Route::apiResource('comments', CommentController::class);
        Route::apiResource('reviews', ReviewController::class);
        Route::apiResource('facilities', FacilityController::class);



// end  all rooms
    });
//start Faq
Route::post('/faqs/block', [FaqController::class, 'block']);
Route::apiResource('faqs', FaqController::class);
//end Faq
Route::apiResource('room-types', RoomTypesController::class);

Route::get('countries/{id}/cities', [CountryController::class,'getCitiesInCountry']);

Route::get('city/hotels/{id}', [HotelsController::class,'getHotelInCity']);
Route::get('search', [SearchEngineController::class,'search']);
Route::get('/hotels/{hotel}/room-search', [SearchEngineController::class, 'getRooms']);
Route::apiResource("booking", BookingController::class);
Route::middleware(['auth:api', 'role:owner'])->group(function () {
    Route::get('/owner/test', function () {
        return auth()->user();
    });
});
Route::apiResource('pages', PageController::class);

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard']);
});

