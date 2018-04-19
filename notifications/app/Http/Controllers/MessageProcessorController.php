<?php

namespace App\Http\Controllers;

use App\Mail\MailNotificator;
use App\Notification;
use App\Subscriber;
use App\Subscription;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Mail;

class MessageProcessorController extends Controller
{
   public function processReceivedApplicationRequestedMessageFromActivityAndProjectMgnt(Request $request){

       $anApplicationJsonString = file_get_contents('php://input');
       $anApplicationArray =  json_decode($anApplicationJsonString, true );

       $eventName = $anApplicationArray['eventName'];
       $repInfos = $anApplicationArray['repInfos'];

       $notification = Notification::where('notificationname', '=', $eventName)->get()[0];


       $counter = count($repInfos);

       //Supporting variables

       $url = 'https://fcm.googleapis.com/fcm/send';

       $applicationRequestRepsToCreate = [];
       $subscriptionsForapplicationRequestToCreate = [];

       $externalMails = [];
       $internalMails = [];

       $externalSms = [];
       $internalSms = [];

       $externalPush = [];
       $internalPush = [];



       //To be removed at the boundaries
       for($i=0; $i < $counter; $i++){

           //Creation des utilisateurs et souscriptions

           $aUser = new Subscriber(Uuid::generate()->string, $repInfos[$i]['fullName'], $repInfos[$i]['email'], $repInfos[$i]['phone'], 'EXTERNAL', '');
           array_push($applicationRequestRepsToCreate, $aUser);

           $aUserSubscription = new Subscription(Uuid::generate()->string, $notification->notificationname, $aUser->userid, $aUser->type, $aUser->emailaddress,'PUSH');
           array_push($subscriptionsForapplicationRequestToCreate, $aUserSubscription);


           //Persistance

       }


       ////Notification
       $allSubscriptions = Subscription::where('notificationname', '=', $notification->notificationname)->get();


       //return $allSubscription;
       for($i=0; $i < count($allSubscriptions); $i++){
           if( $allSubscriptions[$i]->notificationchannel === 'EMAIL'){

               if($allSubscriptions[$i]->usertype === 'INTERNAL'){
                   array_push($internalMails, $allSubscriptions[$i]-> contact);
               }elseif ($allSubscriptions[$i]->usertype === 'EXTERNAL'){
                   array_push($externalMails, $allSubscriptions[$i]-> contact);

               }
               else{

               }


           }elseif ($allSubscriptions[$i]->notificationchannel === 'SMS'){

               if($allSubscriptions[$i]->usertype === 'INTERNAL'){
                   array_push($internalSms, $allSubscriptions[$i]-> contact);

               }elseif ($allSubscriptions[$i]->usertype === 'EXTERNAL'){
                   array_push($externalSms, $allSubscriptions[$i]-> contact);

               }else{

               }
           }elseif ($allSubscriptions[$i]->notificationchannel === 'PUSH'){

               if($allSubscriptions[$i]->usertype === 'INTERNAL'){
                   array_push($internalPush, $allSubscriptions[$i]-> contact);

               }elseif ($allSubscriptions[$i]->usertype === 'EXTERNAL'){
                   array_push($externalPush, $allSubscriptions[$i]-> contact);

               }
               else{

               }

           }else{
               //niente
           }
       }


       //Persist representatives and their subscriptions
       for ($i = 0; $i < $counter; $i++){
            $applicationRequestRepsToCreate[$i]->save();
            $subscriptionsForapplicationRequestToCreate[$i]->save();
        }

       //Send emails notifications
       Mail::to($internalMails)->send(new MailNotificator($eventName, $notification->internalemailtemplate));
       Mail::to($externalMails)->send(new MailNotificator($eventName, $notification->externalemailtemplate));

       //Send push notifications
       if(count($internalPush) > 0){
           $data = array();
           $data['notification_title'] = $notification->title;
           $data['message'] = array('message'=>$notification->internalmessagecontent);
           $fields = array(
               'registration_ids' => $internalPush,
               'priority' => "high",
               'data' => compact('data'),
           );

           $headers = array(
               'Authorization:key =AAAAWAJ5b9Y:APA91bG7Niyy-qAXnGip7KOwgJFCnwV1ULiljonFDf1suX8aHp5Frip6kZM19fIF6ha2ryLB_ARFfbAWvSuwcicfdFj6S2i6tTwlsQyRLqC3HvUCqOlysncrPnp3KxDQQ8oB4LgODXFu',
               'Content-Type: application/json'
           );
           $ch = curl_init();
           curl_setopt($ch, CURLOPT_URL, $url);
           curl_setopt($ch, CURLOPT_POST, true);
           curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
           $result = curl_exec($ch);
           if ($result === FALSE) {
               die('Curl failed: ' . curl_error($ch));
           }
           curl_close($ch);
       }
       if(count($externalPush) > 0){

           $data = array();
           $data['notification_title'] = $notification->title;
           $data['message'] = array('message'=>$notification->externalmessagecontent);
           $fields = array(
               'registration_ids' => $externalPush,
               'priority' => "high",
               'data' => compact('data'),
           );

           $headers = array(
               'Authorization:key =AAAAWAJ5b9Y:APA91bG7Niyy-qAXnGip7KOwgJFCnwV1ULiljonFDf1suX8aHp5Frip6kZM19fIF6ha2ryLB_ARFfbAWvSuwcicfdFj6S2i6tTwlsQyRLqC3HvUCqOlysncrPnp3KxDQQ8oB4LgODXFu',
               'Content-Type: application/json'
           );
           $ch = curl_init();
           curl_setopt($ch, CURLOPT_URL, $url);
           curl_setopt($ch, CURLOPT_POST, true);
           curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
           $result = curl_exec($ch);
           if ($result === FALSE) {
               die('Curl failed: ' . curl_error($ch));
           }
           curl_close($ch);
       }
       //NEED TO HANDLE ERRORS
       return "OK";
   }


   public function registerReceivedUserFromIdentityAndAccess(Request $request){

       $aUserJsonString = file_get_contents('php://input');
       $aUserJArray =  json_decode($aUserJsonString, true);

       $userId = $aUserJArray['userId'];
       $name = $aUserJArray['name'];
       $email = $aUserJArray['email'];
       $phone = $aUserJArray['phone'];

       $aUser = new Subscriber($userId, $name, $email,$phone, 'INTERNAL');

       $aUser->save();

       return $aUser;

   }
}
