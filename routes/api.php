<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'user'], function($route){
    $route->post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name('api.post.login');
    $route->group(['prefix' => 'announcement', 'middleware' => 'auth:api'], function($route){
        $route->get('/', [\App\Http\Controllers\Api\AnnouncementController::class, 'listing'])->name('api.announcement.listing');
        $route->post('/', [\App\Http\Controllers\Api\AnnouncementController::class, 'postSave'])->name('api.save.announcement');
        $route->put('/', [\App\Http\Controllers\Api\AnnouncementController::class, 'postSave'])->name('api.save.announcement');
        $route->delete('/{id}', [\App\Http\Controllers\Api\AnnouncementController::class, 'delete'])->name('api.delete.announcement');
    });
});