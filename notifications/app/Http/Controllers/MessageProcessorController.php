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


       //return $notification;


       $counter = count($repInfos);


       for($i=0; $i < $counter; $i++){

           //Creation des utilisateurs et souscriptions

           $aUser = new Subscriber(Uuid::generate()->string, $repInfos[$i]['fullName'], $repInfos[$i]['email'], $repInfos[$i]['phone'], 'EXTERNAL', '');
           $aUserSubscription = new Subscription(Uuid::generate()->string, $notification->notificationname, $aUser->userid, $aUser->type, $aUser->emailaddress,'PUSH');

           //Persistance

           $aUser->save();
           $aUserSubscription->save();
       }



       ////Notification

       $allSubscription = Subscription::where('notificationname', '=', $notification->notificationname)->get();


       //return $allSubscription;


       $externalMails = [];
       $internalMails = [];

       $externalSms = [];
       $internalSms = [];

       $externalPush = [];
       $internalPush = [];



       for($i=0; $i < count($allSubscription); $i++){
           if( $allSubscription[$i]->notificationchannel === 'EMAIL'){

               if($allSubscription[$i]->usertype === 'INTERNAL'){
                   array_push($internalMails, $allSubscription[$i]-> contact);
               }elseif ($allSubscription[$i]->usertype === 'EXTERNAL'){
                   array_push($externalMails, $allSubscription[$i]-> contact);

               }
               else{

               }


           }elseif ($allSubscription[$i]->notificationchannel === 'SMS'){

               if($allSubscription[$i]->usertype === 'INTERNAL'){
                   array_push($internalSms, $allSubscription[$i]-> contact);

               }elseif ($allSubscription[$i]->usertype === 'EXTERNAL'){
                   array_push($externalSms, $allSubscription[$i]-> contact);

               }else{

               }
           }elseif ($allSubscription[$i]->notificationchannel === 'PUSH'){

               if($allSubscription[$i]->usertype === 'INTERNAL'){
                   array_push($internalPush, $allSubscription[$i]-> contact);

               }elseif ($allSubscription[$i]->usertype === 'EXTERNAL'){
                   array_push($externalPush, $allSubscription[$i]-> contact);

               }
               else{

               }

           }else{
               //niente
           }
       }


       //Send emails

       Mail::to($internalMails)->send(new MailNotificator($eventName, $notification->internalemailtemplate));
       Mail::to($externalMails)->send(new MailNotificator($eventName, $notification->externalemailtemplate));

       //Send push


       $url = 'https://fcm.googleapis.com/fcm/send';
       $data = array();
       $data['notification_title'] = "Actualités / News:";
       $data['message'] = array('message'=>'Hello test!');
       $fields = array(
           'registration_ids' =>  ['fYZbfUrDQ2Q:APA91bHoOv9Up8GB4nznIB4pYcrxredsKU220C3lnb0t6t7dcRcqt1nhhlbn3JS_dlOSkiz4TXctIiQb_wcNzE4NlOMjSItLd7wzvU2pNLmVn59VqmgZpCbiP5g2bAqKGXMwEPGt2lGi',
                                           'cBp0BQEFBOI:APA91bFwNjJIa5hQVr8X7Tp6K-C5_levlxs4TIsOirGnXgfd75FpQjYGp9o5ZiKw95Y9EWqIurHP7rXblYfhuhzJGDDPRIHPqz0lTKLFkeH2osdHeQEE4mdPhxmL125wj4s47Q2jjCtU' ],
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
