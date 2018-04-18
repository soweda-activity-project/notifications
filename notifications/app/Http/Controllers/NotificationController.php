<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;
use  App\Notification;
use Webpatser\Uuid\Uuid;


class NotificationController extends Controller
{
    public function createNotifications(Request $request){

        $notificationJsonString = file_get_contents('php://input');
        $notificationArray =  json_decode($notificationJsonString, true);


        $notification = new Notification(Uuid::generate()->string, $notificationArray['notificationtype'], $notificationArray['notificationname'],
            $notificationArray['externalemailtemplate'], $notificationArray['externalsmstemplate'],  $notificationArray['externalpushtemplate'],
            $notificationArray['internalemailtemplate'], $notificationArray['internalpushtemplate'], $notificationArray['internalpushtemplate'],
            $notificationArray['messagecontent']);


         $notification->save();

        return response($notification, 200);


    }

    public function retrieveAllNotifications(Request $request){

        return Notification::all();
    }

    public function retrieveNotificationByNotificationId(Request $request, String $notificationid){

        return response(Notification::where('notificationid', $notificationid)->first(), 200);

    }
    //
}
