<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CKEditorController;
// use 
// use App\Http\Controllers\Auth;
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




// Route::get('/page', function(){
//     return view('page');
// });

Route::get("/posts/pagination",[PostController::class,'fetch_data']);

Route::resource("posts",PostController::class);


Route::post('ckeditor/image_upload', [CKEditorController::class,'upload'])->name('upload');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('changeLanguage/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

// Route::get('changeLanguage/{locale}', function ($locale = null) {
//     if (isset($locale) && in_array($locale, config('app.available_locales'))) {
//         app()->setLocale($locale);
        
//     }
    
//     redirect()->back();
// });


Route::get('/convert-to-json', function () {
    return App\Models\Post::paginate(3);
});

// Route::get('/pagination', [PaginationController::class,'index']);
// Route::get('pagination/fetch_data', [PaginationController::class,'fetch_data']);

Route::get('user/(:any)', function($name){
    return "Xin chào " . $name;
  });