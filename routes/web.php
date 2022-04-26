<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;

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


Route::resource('posts', PostController::class);
Route::group(['middleware' => 'auth'], function () {


    // Route::get('users/pagination', [UserController::class, 'fetch'])->prefix('admin');
    // Route::resource('users', UserController::class);
});

Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
   

    Route::get('users/pagination', [UserController::class, 'fetch']);
    Route::resource('users', UserController::class, ['as' => 'admin']);

    Route::post('posts/approve', [PostController::class, 'approve'])->name('admin.posts.approve')->middleware('authorization');

    Route::get('posts/pagination', [PostController::class, 'fetch_data']);
    Route::resource('posts', PostController::class, ['as' => 'admin']);
});

Route::middleware('admin.redirect')->group(function(){
    Route::get('admin/login', [AuthenticatedSessionController::class, 'admin_create'])
    ->name('admin.login');
    Route::post('admin/login', [AuthenticatedSessionController::class, 'admin_store']);
});



Route::post('ckeditor/image_upload', [CKEditorController::class, 'upload'])->name('upload');
Route::get('changeLanguage/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

Route::post('verify-email', [RegistrationController::class, '__invoke'])->name('register.verify');
Route::get('verify-email/verify/{confirmationCode}', [
    'as' => 'register.verify.email',
    'uses' => 'App\Http\Controllers\RegistrationController@register'
]);



require __DIR__ . '/auth.php';
