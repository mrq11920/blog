<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

// use 

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

// Route::get('/login2',function(){
//     return view('auth.login2');
// });


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');


// Route::resource('posts', PostController::class);
Route::group(['middleware' => 'auth'], function () {
    Route::get('posts/pending', [PostController::class, 'pending'])->name('posts.pending');
    Route::get('posts/cancel', [PostController::class, 'cancel'])->name('posts.cancel');
    Route::post('posts/approve', [PostController::class, 'approve'])->name('posts.approve')->middleware('authorization');

    Route::get('posts/pagination', [PostController::class, 'fetch_data']);
    Route::resource('posts', PostController::class);
    
    Route::get('users/pagination', [UserController::class, 'fetch']);
    Route::resource('users', UserController::class);
});


Route::post('ckeditor/image_upload', [CKEditorController::class, 'upload'])->name('upload');
Route::get('changeLanguage/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

Route::post('verify-email', [RegistrationController::class, '__invoke'])->name('register.verify');
Route::get('verify-email/verify/{confirmationCode}', [
    'as' => 'register.verify.email',
    'uses' => 'App\Http\Controllers\RegistrationController@register'
]);
// Route::get('verify-email/verify/{confirmationCode}', [
//     'as' => 'register.verify.email',
//     'uses' => 'App\Http\Controllers\RegistrationController@confirm'
// ]);


require __DIR__ . '/auth.php';
