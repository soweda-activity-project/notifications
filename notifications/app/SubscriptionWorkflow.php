<?php
/**
 * Created by PhpStorm.
 * User: felic
 * Date: 4/9/2018
 * Time: 2:09 PM
 */

    require_once('Domain.php');

     function subscribe($subcritionId, $aNotificationId, $aNotificationChannel, $aContactInfoList){

         return new Subscription($subcritionId, $aNotificationId, $aNotificationChannel, $aContactInfoList);
     }



    $subscription = subscribe(1, 1, "2", 3);

     var_dump($subscription);


?>