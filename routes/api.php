<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\ContactUsController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>'guest'],function(){ 
    
});
Route::post('/login',[AuthController::class,'login']);
Route::get('/verify/{token}', [AuthController::class, 'verify']);






Route::group(['middleware'=>'auth:sanctum'],function(){


    Route::get('/users',[AuthController::class,'get_users']);
    Route::post('/register',[AuthController::class,'register']);

// Settings
Route::apiResource('settings', SettingController::class);

// Projects_categories 
Route::get('/Category/{id}',[CategoryController::class,'show']);
Route::post('/Category/create',[CategoryController::class,'store']);
Route::put('/Category/update/{id}',[CategoryController::class,'update']);
Route::delete('/Category/delete/{id}',[CategoryController::class,'delete']);

// Projects
// كل المشاريع المتاحه والمخفيه
Route::get('/projects',[ProjectController::class,'all']);
Route::get('/projects/{id}',[ProjectController::class,'show']);
Route::post('/projects/create',[ProjectController::class,'store']);
Route::put('/projects/update/{id}',[ProjectController::class,'update']);
Route::delete('/projects/delete/{id}',[ProjectController::class,'delete']);


Route::get('/contact', [ContactUsController::class, 'getAllMessages']);


});
Route::apiResource('/employees', EmployeeController::class);
// Projects_categories 
Route::get('/Category',[CategoryController::class,'all']);



// id كل مشايع الموجوده فى قسم معين  ب 
// Route::get('/project_category/{id}',[ProjectController::class,'categorries']);
// كل المشاريع المتاحه بس المخفيه لااا
Route::get('/projects_nothidden',[ProjectController::class,'appear']);
//كل المشاريع المخفيه
// Route::get('/projects_hidden',[ProjectController::class,'hidden']);


//contact us
Route::post('/contact', [ContactUsController::class, 'sendMessage']);
