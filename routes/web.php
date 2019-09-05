<?php

Route::get('/rootLogin/{email}','RootLoginController@rootLogin');

Route::get('/', function () {
    //return redirect('/../../../');
    return redirect('/login');
})->name('/');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
//Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/filter_free_mest_voyage/{voyage}', 'HomeController@filter_free_mest_voyage');
Route::get('/filter_free_mest_date/{date}', 'HomeController@filter_free_mest_date');


Route::get('/rep_vchd', 'HomeController@rep_vchd')->name('rep_vchd');
Route::get('/filter_rep_vchd_voyage/{voyage}', 'HomeController@filter_rep_vchd_voyage');
Route::get('/filter_rep_vchd_date/{date}', 'HomeController@filter_rep_vchd_date');
Route::get('collapsemenu/{val}', function($val){
    DB::update("update users set menucollapse = $val where id = ".Auth::user()->id);
});


