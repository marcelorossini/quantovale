<?php
use Illuminate\Http\Request;
use App\Http\Requests;

Route::group(['middleware' => ['web']], function() {

// Login Routes...
    Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
    Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

// Registration Routes...
    Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
    Route::post('register', ['as' => 'register.post', 'uses' => 'Auth\RegisterController@register']);

// Password Reset Routes...
    Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset']);
});

Route::get('/','HomeController@index');

Route::post('/search/product', [
       'as' => 'postSearch', function (Request $request) {
          return redirect(route('getSearch',$request->product));
       }]);

Route::get('/search/product/{keyword?}','SearchController@index')->name('getSearch');

Route::get('/product/{id?}','ProductController@index')->name('getProduct');
Route::post('/product/{category?}/{id?}/calcula','ProductController@calcula')->name('postProduct');

Route::get('product/{id?}/images/{filename?}','ImageController@index')->name('getProductImage');

Route::get('/category','CategoryController@update')->name('getCategory');
