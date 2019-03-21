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
    // return view('welcome');
    return redirect('/admin');
})->name("home");


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/settings', 'SettingsController@index')->name('settings');
Route::middleware('cors')->get('/categories', 'CategoriesController@getCategories')->name('categories');
Route::middleware('cors')->get('/subcategories/{id}', 'CategoriesController@getSubCategories')->name('subcategories');
Route::get('/callback', 'CategoriesController@callback')->name('callback');
Route::get('/departements', 'ArticlesController@getDepartements')->name('departements');
Route::get('/cities/{departements}', 'ArticlesController@getCities')->name('cities');
Route::get('/articles/{keywords}', 'ArticlesController@getArticles')->name('articles');
// Route::middleware('auth:api')->get('/todos', function (Request $request) {
//     return $request->user()->todos;
// });