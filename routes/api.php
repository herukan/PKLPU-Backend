<?php

use Illuminate\Http\Request;

//FIX CORS
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('siswa','SiswaController@index');
// Route::post('siswa','SiswaController@create');
// Route::get('siswa/{id}','SiswaController@select');
// Route::put('/siswa/{id}','SiswaController@update');
// Route::delete('/siswa/{id}','SiswaController@delete');

// Route::post('login', 'API\UserController@login');
// Route::post('login', 'API\UserController@register');

//CRUD SISWAS
Route::get('siswa', array('middleware' => 'cors', 'uses' => 'SiswaController@index'));
Route::post('siswa',array('middleware' => 'cors', 'uses' => 'SiswaController@create'));
Route::get('siswa/{id}',array('middleware' => 'cors', 'uses' => 'SiswaController@select'));
Route::put('/siswa/{id}',array('middleware' => 'cors', 'uses' => 'SiswaController@update'));
Route::delete('/siswa/{id}',array('middleware' => 'cors', 'uses' => 'SiswaController@delete'));
Route::post('page',array('middleware' => 'cors', 'uses' => 'SiswaController@allPosts'));

//CRUD PEMELIHARAAN
Route::get('pemeliharaan', array('middleware' => 'cors', 'uses' => 'PemeliharaanController@index'));
Route::get('pemeliharaan/{id}',array('middleware' => 'cors', 'uses' => 'PemeliharaanController@select'));
Route::get('pemeliharaan/plat/{id}',array('middleware' => 'cors', 'uses' => 'PemeliharaanController@selectplat'));
Route::post('pemeliharaan',array('middleware' => 'cors', 'uses' => 'PemeliharaanController@create'));
Route::delete('/pemeliharaan/{id}',array('middleware' => 'cors', 'uses' => 'PemeliharaanController@delete'));
Route::put('/pemeliharaan/{id}',array('middleware' => 'cors', 'uses' => 'PemeliharaanController@update'));
Route::post('pemeliharaanpage',array('middleware' => 'cors', 'uses' => 'PemeliharaanController@allPosts'));


// CRUD PEMINJAMAN
Route::get('peminjaman', array('middleware' => 'cors', 'uses' => 'PeminjamanController@index'));
Route::get('peminjaman/{id}',array('middleware' => 'cors', 'uses' => 'PeminjamanController@select'));
Route::post('peminjaman',array('middleware' => 'cors', 'uses' => 'PeminjamanController@create'));
Route::delete('/peminjaman/{id}',array('middleware' => 'cors', 'uses' => 'PeminjamanController@delete'));
Route::put('/peminjaman/{id}',array('middleware' => 'cors', 'uses' => 'PeminjamanController@update'));
Route::post('peminjamanpage',array('middleware' => 'cors', 'uses' => 'PeminjamanController@allPosts'));

// CRUD KENDARAAN
Route::get('kendaraan', array('middleware' => 'cors', 'uses' => 'KendaraanController@index'));
Route::get('kendaraan/plat', array('middleware' => 'cors', 'uses' => 'KendaraanController@platku'));
Route::get('kendaraan/jenis/{id}', array('middleware' => 'cors', 'uses' => 'KendaraanController@jenis'));
Route::get('kendaraan/{id}',array('middleware' => 'cors', 'uses' => 'KendaraanController@select'));
Route::post('kendaraan',array('middleware' => 'cors', 'uses' => 'KendaraanController@create'));
Route::delete('/kendaraan/{id}',array('middleware' => 'cors', 'uses' => 'KendaraanController@delete'));
Route::put('/kendaraan/{id}',array('middleware' => 'cors', 'uses' => 'KendaraanController@update'));
Route::post('kendaraanpage',array('middleware' => 'cors', 'uses' => 'KendaraanController@allPosts'));


// CRUD PEMINJAM
Route::get('peminjam', array('middleware' => 'cors', 'uses' => 'PeminjamController@index'));
Route::post('peminjam',array('middleware' => 'cors', 'uses' => 'PeminjamController@create'));
Route::delete('/peminjam/{id}',array('middleware' => 'cors', 'uses' => 'PeminjamController@delete'));
Route::put('/peminjam/{id}',array('middleware' => 'cors', 'uses' => 'PeminjamController@update'));
Route::get('peminjam/{id}',array('middleware' => 'cors', 'uses' => 'PeminjamController@select'));

//AUTENTIKASI
// Route::post('login', array('middleware' => 'cors', 'uses' => 'API\UserController@login'));
// Route::post('login', array('middleware' => 'cors', 'uses' => 'API\UserController@register'));

// Route::group(['middleware' => 'auth:api'], function(){
// Route::post('details', 'API\UserController@details');
// });


// JWT AUTH
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/User',array('middleware' => 'cors', 'uses' => 'UserController@User'));


Route::group(['middleware' => ['jwt.auth','api-header']], function () {
  
    // all routes to protected resources are registered here  
    // Route::get('users/list', function(){
    //     $users = App\User::all();
        
    //     $response = ['success'=>true, 'data'=>$users];
    //     return response()->json($response, 201);
    // });



});
Route::group(['middleware' => 'api-header'], function () {
  
    // The registration and login requests doesn't come with tokens 
    // as users at that point have not been authenticated yet
    // Therefore the jwtMiddleware will be exclusive of them
    
    // Route::post('user/login', 'UserController@login');
    // Route::post('user/register', 'UserController@register');


});

    //BYPAS CORS
    Route::post('user/login',array('middleware' => 'cors', 'uses' => 'UserController@login'));
    Route::post('user/register',array('middleware' => 'cors', 'uses' => 'UserController@register'));
    Route::get('users/list',array('middleware' => 'cors', 'uses' => 'UserController@Userlist'));
    Route::delete('users/list/{id}',array('middleware' => 'cors', 'uses' => 'UserController@deleteuser'));
    Route::get('total',array('middleware' => 'cors', 'uses' => 'UserController@total'));
    Route::get('chart',array('middleware' => 'cors', 'uses' => 'UserController@chart'));