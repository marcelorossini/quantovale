<?php
use Illuminate\Http\Request;
use App\Http\Requests;

Route::get('/','HomeController@index');

Route::post('/search/product', [
       'as' => 'postSearch', function (Request $request) {
          return redirect(route('getSearch',$request->product));
       }]);

Route::get('/search/product/{keyword?}','SearchController@index')->name('getSearch');

Route::get('/product/{id?}','ProductController@index')->name('getProduct');
