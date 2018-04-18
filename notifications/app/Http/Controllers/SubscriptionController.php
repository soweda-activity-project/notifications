<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;


class SubscriptionController extends Controller
{
    public function createSubscription(Request $request){

        $subscriptionJsonBody = file_get_contents('php://input');
        $subscriptionArray =  json_decode($subscriptionJsonBody, true);

        $subscription = new Subscription(Uuid::generate()->string, $subscriptionArray['notificationname'], $subscriptionArray['userid'],$subscriptionArray['usertype'], $subscriptionArray['contact'],  $subscriptionArray['notificationchannel']);

        $subscription->save();

        return response($subscription, 200);

    }
    public function getAllSubscriptions(Request $request){

        return Subscription::all();
    }
    public function retrieveSubscriptionBySubscriptionId(Request $request, String $subscriptionid){

        return response(Subscription::where('subscriptionid', $subscriptionid)->first(), 200);

    }
    public function createUsersAndSubscriptions (Request $request){



    }

}
