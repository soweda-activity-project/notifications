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


       for($i=0; $i < $counter; $i++){

           //Creation des utilisateurs et souscriptions

           $aUser = new Subscriber(Uuid::generate()->string, $repInfos[$i]['fullName'], $repInfos[$i]['email'], $repInfos[$i]['phone'], 'EXTERNAL', '');
           $aUserSubscription = new Subscription(Uuid::generate()->string, $notification->notificationname, $aUser->userid, $aUser->type, 'EMAIL', $aUser->emailaddress);

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


       //return $internalMails;

       Mail::to($internalMails)->send(new MailNotificator($eventName, $notification->internalemailtemplate));
       Mail::to($externalMails)->send(new MailNotificator($eventName, $notification->externalemailtemplate));

       array_push($internalMails, $externalMails);

       return  $internalMails;
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
