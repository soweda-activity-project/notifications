<?php
/**
 * Created by PhpStorm.
 * User: felic
 * Date: 4/9/2018
 * Time: 1:15 PM
 */


class EmailAddress {

    private $emailAddress;

    public function __construct(String $anEmailAddress){
        $this->emailAddress = $anEmailAddress;
    }

    public function emailAddress(){
        return $this->emailAddress;
    }

}
class PhoneNumber {

    private $phoneNumber;

    public function __construct(String $aPhoneNumber){
        $this->phoneNumber = $aPhoneNumber;
    }

    public function phoneNumber(){
        return $this->phoneNumber;
    }

}
class ContactInfo {

    private $userId;
    private $emailAddress;
    private $phoneNumber;

    public function __construct(String $aUserId, EmailAddress $anEmailAddress, PhoneNumber $aPhoneNumber){

        $this->userId = $aUserId;
        $this->emailAddress = $anEmailAddress;
        $this->phoneNumber = $aPhoneNumber;
    }

    public function userdId(){
        return $this->userId;
    }
    public function emailAddress(){
        return $this->emailAddress;
    }
    public function phoneNumber(){
        return $this->phoneNumber;
    }

}
class InternalNotification {

    private $notificationId;
    private $notificationName;
    private $emailTemplate;
    private $smsTemplate;
    private $pushTemplate;
    private $mesageContent;

    public function __construct(String $aNotificationId, String $aNotificationName, String $anEmailTemplate, String $anSmsTemplate, String $aMesageContent){
        $this->notificationId = $aNotificationId;
        $this->emailTemplate = $anEmailTemplate;
        $this->smsTemplate = $anSmsTemplate;
        $this->mesageContent = $aMesageContent;
        $this->notificationName = $aNotificationName;
    }

    public function notificationId(): String
    {
        return $this->notificationId;
    }

    public function notificationName(): String
    {
        return $this->notificationName;
    }

    public function emailTemplate(): String
    {
        return $this->emailTemplate;
    }

    public function smsTemplate(): String
    {
        return $this->smsTemplate;
    }

    public function mesageContent(): String
    {
        return $this->mesageContent;
    }


}
class ExternalNotification {


    private $notificationId;
    private $notificationName;
    private $emailTemplate;
    private $smsTemplate;
    private $pushTemplate;
    private $mesageContent;


    public function __construct(String $aNotificationId, String $aNotificationName, String $anEmailTemplate, String $anSmsTemplate, String $aMesageContent){
        $this->notificationId = $aNotificationId;
        $this->emailTemplate = $anEmailTemplate;
        $this->smsTemplate = $anSmsTemplate;
        $this->mesageContent = $aMesageContent;
        $this->notificationName = $aNotificationName;
    }

    public function notificationId(): String
    {
        return $this->notificationId;
    }

    public function notificationName(): String
    {
        return $this->notificationName;
    }

    public function emailTemplate(): String
    {
        return $this->emailTemplate;
    }

    public function smsTemplate(): String
    {
        return $this->smsTemplate;
    }

    public function mesageContent(): String
    {
        return $this->mesageContent;
    }

}
abstract class NotificationChannel {
    Const EMAIL = "EMAIL";
    Const SMS = "SMS";
    Const PUSH = "PUSH";
}
class Subscription {

    private $subscriptionId;
    private $notificationId;
    private $notificationChannel;
    private $contactList;

    public function __construct(String $aSusbcriptionId, String $aNotificationId, String $aNotificationChannel, Array $aContactList){
        $this->subscriptionId = $aSusbcriptionId;
        $this->notificationId = $aNotificationId;
        $this->notificationChannel = $aNotificationChannel;
        $this->contactList = $aContactList;
    }

    public function subscriptionId()
    {
        return $this->subscritionId;
    }

    public function notificationId()
    {
        return $this->notificationId;
    }

    public function notificationChannel()
    {
        return $this->notificationChannel;
    }

    public function contactList()
    {
        return $this->contactList;
    }

}
class NotificationSentResult {
    private $senTResult;


}




$emailAddress = new EmailAddress("felicien.fotiomanfo@gmail.com");
$phoneNumber = new PhoneNumber("669262656");
$contactInfo = new ContactInfo("12345", $emailAddress, $phoneNumber);
$notification1 = new InternalNotification(1, "Activity Request Initiated","email Temp", "sms Temp", "message 1 Content");
$notification2 = new ExternalNotification(2, "Activity Aknowledgement Confirmed","email Temp", "sms Temp", "message 2 Content" );
$notificationChanelType = NotificationChannel::EMAIL;
$subscription = new Subscription(1, 2, $notificationChanelType, ["felicien.fotiomanfo@gmail.com", "pat.fotiomanfo@gmail.com"]);
$notificationResult = new NotificationSentResult();


if (filter_var($emailAddress->emailAddress(), FILTER_VALIDATE_EMAIL)) {
    echo "Email address is considered valid.\n";
}
else{
    echo "Email address is considered not valid.\n";
}


var_dump($subscription);
?>