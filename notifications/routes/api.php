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


//Notifications API
Route::post('/notifications', 'NotificationController@createNotifications');
Route::get('/notifications', 'NotificationController@retrieveAllNotifications');
Route::get('/notifications/{notificationid}', 'NotificationController@retrieveNotificationByNotificationId');



//Subscriptions API
Route::post('/subscriptions', 'SubscriptionController@createSubscription');
Route::get('/subscriptions', 'SubscriptionController@getAllSubscriptions');
Route::get('/subscriptions/{subscriptionid}', 'SubscriptionController@retrieveSubscriptionBySubscriptionId');



//Messages API
Route::post('/message/receivedapplication', 'MessageProcessorController@processReceivedApplicationRequestedMessageFromActivityAndProjectMgnt');
Route::post('/message/receiveduser', 'MessageProcessorController@registerReceivedUserFromIdentityAndAccess');


//Subscribers API
Route::post('/subscribers/{userid}/token', 'SubscriberController@updateSubscriberToken');
Route::get('/subscribers', 'SubscriberController@retrieveUserWithTheirContacts');
Route::get('/subscribers/{userid}/subscriptions', 'SubscriberController@retrieveSubscriptionsForUser');
Route::get('/subscribers/{userid}/not-subscribed-to-notifications', 'SubscriberController@retrieveAllNotificationUserHasNotSubscribedTo');

