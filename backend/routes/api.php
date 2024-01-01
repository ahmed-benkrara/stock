<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RecipeController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/product')->group(function(){
    Route::post('/create', [ProductController::class, 'store']);
    Route::get('/instock', [ProductController::class, 'inStock']);
});

Route::prefix('/recipe')->group(function(){
    Route::post('/create', [RecipeController::class, 'store']);
    Route::get('/all', [RecipeController::class, 'recipes']);
    Route::post('/validate', [RecipeController::class, 'validateRecipe']);
});