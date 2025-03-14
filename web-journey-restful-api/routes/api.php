<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserApiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// get api for fetch users
Route::get('/users/{id?}', [UserApiController::class, 'getUser']);
// post api for add users
Route::post('/add-users', [UserApiController::class, 'addUser']);
// post api for add multiple users
Route::post('/add-multiple-users', [UserApiController::class, 'addMultipleUsers']);
// put api for update users details
Route::put('/update-users-details/{id}', [UserApiController::class, 'updateUser']);
// patch api for update single user record
Route::patch('/update-single-record/{id}', [UserApiController::class, 'updateSingleUser']);
// delete API for delete single user
Route::delete('/delete-single-user/{id}', [UserApiController::class, 'deleteSingleUser']);
// delete API for delete single user with JSON
Route::delete('/delete-single-user-json', [UserApiController::class, 'deleteSingleJsonUser']);
// delete API for delete multiple users
Route::delete('/delete-multiple-user/{ids}', [UserApiController::class, 'deleteMultipleUser']);
// delete API for delete multiple users with JSON
Route::delete('/delete-multiple-user-json', [UserApiController::class, 'deleteMultipleJsonUser']);
// passport route for register
Route::post('/register-user-using-passport', [UserApiController::class, 'registerUserUsingPassport']);
// passport route for login
Route::post('/login-user-using-passport', [UserApiController::class, 'loginUserUsingPassport']);
