<?php
use Illuminate\Http\Request;
use App\Http\Requests;
/*
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
*/
Auth::routes();

Route::get('/','HomeController@index')->name('getHome');

Route::post('/search/product', [
       'as' => 'postSearch', function (Request $request) {
          return redirect(route('getSearch',$request->product));
       }]);

Route::get('/search/{keyword?}','SearchController@index')->name('getSearch');

Route::get('/product/{idProduct?}-{nameProduct?}','ProductController@index')->name('getProduct');
Route::post('/product/{idProduct?}/result','ProductController@result')->name('postResult');
Route::post('/product/{idProduct?}/result/{idResult?}/save/{bTrueFalse?}','ProductController@resultSave')->name('postResultSave');
Route::post('/product/{idProduct?}/result/{idResult?}/shared','ProductController@resultShared')->name('postResultShared');

Route::get('/product/share/{id?}','ProductController@share')->name('getShare');

Route::get('product/{id?}/images/{filename?}','ImageController@index')->name('getProductImage');

Route::get('/category','CategoryController@update')->name('getCategory');

// facebook
Route::get('/facebook/redirect', 'SocialAuthController@redirect')->name('getFacebookRedirect');
Route::get('/facebook/callback', 'SocialAuthController@callback')->name('getFacebookCallback');

// Teste
Route::get('/product/atualizar/buscape', 'ProductController@atualizaBuscape')->name('getAtualizarBuscape');

// Telas do usuário
Route::get('/user/favorites', 'UserController@favorites')->middleware('auth')->name('getUsersFavorites');
Route::get('/user/shared', 'UserController@shared')->middleware('auth')->name('getUsersShared');

Route::get('teste', [function () {
          return view('facebook.teste');
       }]);
