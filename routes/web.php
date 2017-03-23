<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => ['web']], function () {

    //注册前台
    Route::get('/reg', 'RegController@index');
    Route::post('/reg', 'RegController@reg');
    Route::get('/reg/back', 'RegController@back');
    Route::get('/send', 'RegController@send');

    //注册后台
    Route::get('/yun/user','YunController@index');
    Route::get('/yun/temp','YunController@temp');
    Route::get('/yun/tempdel/{id}','YunController@tempdel')->where('id', '[0-9]+');
    Route::get('/yun/tempadd','YunController@tempadd');
    Route::get('/yun/tempupd/{id}','YunController@tempupd')->where('id', '[0-9]+');
    Route::post('/yun/tempupd','YunController@tempupds');
    Route::post('/yun/tempadd','YunController@tempadds');
    Route::post('/yun/tempinfo','YunController@tempinfo');

    Route::get('/yun/{id}', 'RegController@media')->where('id', '[0-9]+'); //链接地址
});