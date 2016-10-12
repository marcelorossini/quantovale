<?php
use Illuminate\Http\Request;
use App\Http\Requests;

Route::get('/home','HomeController@index');

Route::post('/home/search/product', [
       'as' => 'postSearch', function (Request $request) {
          return redirect(route('getSearch',$request->product));
       }]);
Route::get('/home/search/product/{keyword?}','HomeController@search')->name('getSearch');
