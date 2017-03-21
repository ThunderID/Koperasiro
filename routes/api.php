<?php

use Illuminate\Http\Request;

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
// Here lies credit controller all things started here
Route::get('pengajuan', 	['uses' => 'KreditController@index']);

Route::post('pengajuan', 	['uses' => 'KreditController@store']);

Route::post('upload/ktp/{nomor_kredit}', 	['uses' => 'KreditController@upload']);

Route::group(['middleware' => ['tapi']], function()
{
});
