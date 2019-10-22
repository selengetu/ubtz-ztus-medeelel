<?php

Route::get('/rootLogin/{email}','RootLoginController@rootLogin');

Route::get('/', function () {
    //return redirect('/../../../');
    return redirect('/login');
})->name('/');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/filter_free_mest_voyage/{voyage}', 'HomeController@filter_free_mest_voyage');
Route::get('/filter_free_mest_date/{date}', 'HomeController@filter_free_mest_date');
Route::get('/filter_tr_voyage/{voyage}/{fvstop_id}/{tvstop_id}', 'HomeController@filter_tr_voyage');
Route::get('/filter_tr_date/{date}', 'HomeController@filter_tr_date');
Route::get('/filter_tr_frstcode/{st}', 'HomeController@filter_tr_frstcode');
Route::get('/filter_tr_tostcode/{st}', 'HomeController@filter_tr_tostcode');
Route::get('/rep_vchd', 'HomeController@rep_vchd')->name('rep_vchd');
Route::get('/filter_rep_vchd_voyage/{voyage}', 'HomeController@filter_rep_vchd_voyage');
Route::get('/filter_rep_vchd_date/{date}', 'HomeController@filter_rep_vchd_date');
Route::get('/filter_rep_vchd_wagon/{wagon}', 'HomeController@filter_rep_vchd_wagon');
Route::get('collapsemenu/{val}', function($val){
    DB::update("update users set menucollapse = $val where id = ".Auth::user()->id);
});
Route::get('/getwagonmests/{wid}/{stop1}/{stop2}/{voyagesaleid}', function($wid,$stop1,$stop2,$voyagesaleid){
    Session::put('wid', $wid);
    $bindings = [
        'p_uid'  => Auth::id(),
        'p_pos'  => Auth::user()->pos_id,
        'p_saleid'  => $voyagesaleid,
        'p_wid'  => $wid,
        'p_stid1'  => $stop1,
        'p_stid2'  => $stop2,
        'p_mestno'  => 0,
    ];
    return $dt = DB::executeProcedureWithCursor('proc_get_wagon_mests_casher', $bindings);
});