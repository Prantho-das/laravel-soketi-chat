<?php

use App\Http\Controllers\GroupUserController;
use App\Http\Livewire\Auth\Authorization;
use App\Http\Livewire\ChatRoom;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\GroupChat;
use App\Http\Livewire\SingleMessage;
use App\Http\Livewire\User;
use App\Http\Livewire\Welcome;
use App\Models\ChatRoom as ModelsChatRoom;
use App\Models\GroupUser;
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

Route::get('/', Welcome::class);
Route::get('/login', Authorization::class)->middleware('guest')->name('login');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', Dashboard::class);
    Route::get('/rooms', ChatRoom::class);
    Route::get('/users', User::class);
    Route::get('/r/join/{roomId}', GroupUserController::class)->name('room.join');
    Route::get('/r/{roomId}', GroupChat::class);
    Route::get('/chat/{receiverId}', SingleMessage::class);
});
Route::get('/blog', Welcome::class);
Route::get('/about', Welcome::class);
Route::get('/career', Welcome::class);
