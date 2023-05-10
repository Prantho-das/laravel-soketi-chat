<?php

use App\Http\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

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

Route::post('/send-message', function () {
    $message = request()->message ?? "Hello World";
    event(new App\Events\SendMessage($message));
    return response()->json(['status' => 'success', 'status' => 200]);
});
Route::get('/', Welcome::class);
Route::get('/blog', Welcome::class);
Route::get('/about', Welcome::class);
Route::get('/career', Welcome::class);
Route::get('/login', Welcome::class);
