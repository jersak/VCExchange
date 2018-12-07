<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


$router->group(['prefix' => 'notifications'], function () use ($router) {
    $router->post('read/{user_id}', 'NotificationController@markUserNotificationsAsRead');
    $router->get('/{user_id}', 'NotificationController@getNotifications');
});


$router->group(['prefix' => 'transfer'], function () use ($router) {
    $router->post('/', 'TransactionController@createTransaction');
    $router->post('/bulk', 'TransactionController@createBulkTransactions');
});

$router->group(['prefix' => 'user'], function () use ($router) {
    $router->get('/self', 'UserController@getLoggedUser');
    $router->get('/{id}', 'UserController@getUserById');
    $router->get('/search', 'UserController@getUserByEmail');
});
