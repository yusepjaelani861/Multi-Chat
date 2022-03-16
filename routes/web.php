<?php

use App\Http\Controllers\BotManController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramController;
use Illuminate\Http\Request;
use App\Events\Message;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Api;

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
Route::get('/user-get', [TelegramController::class, 'getUser']);
Route::get('/send-chat', [TelegramController::class, 'sendChat']);
Route::get('/start-chat', [TelegramController::class, 'startChat']);
Route::post('message', [TelegramController::class, 'sendChat']);
Route::post('/store', [TelegramController::class, 'store']);

Route::get('/get-db', [TelegramController::class, 'getDB']);
Route::get('/list', [TelegramController::class, 'getAll']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::get('/chat', function () {
    return view('chat');
})->middleware(['auth'])->name('chat');

Route::get('/pesan', [TelegramController::class, 'getChat'])->middleware(['auth'])->name('pesan');

require __DIR__.'/auth.php';
