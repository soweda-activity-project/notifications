<?php

namespace App\Http\Controllers;

use App\Notification;
use App\Subscriber;
use App\Subscription;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function updateSubscriberToken(Request $request, $userid){

        $userTokenInfoJsonString = file_get_contents('php://input');
        $userTokenInfoArray =  json_decode($userTokenInfoJsonString, true);

        $subscriber = null;

        $subscriberArray = Subscriber::where('userid', '=', $userid)->get();

        if (count($subscriberArray)){
            $subscriber = $subscriberArray[0];
        }

        $subscriber->token = $userTokenInfoArray['token'];
        $subscriber->save();

        return $subscriber;



    }
    public  function retrieveUserWithTheirContacts(Request $request){
        return Subscriber::all();
    }
    public function retrieveSubscriptionsForUser(Request $request, $userid){

        return Subscription::where('userid', '=', $userid)->get();

    }
    public function retrieveAllNotificationUserHasNotSubscribedTo(Request $request, $userid){

        $usersRegisterdNotifications  = Subscription::where('userid', '=', $userid)->get(['notificationname']);

        $usersNotRegisterdNotifications = Notification::whereNotIn('notificationname', $usersRegisterdNotifications)->get();

        return $usersNotRegisterdNotifications;
    }
}
