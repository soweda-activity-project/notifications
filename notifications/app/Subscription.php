<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Subscription extends Model
{


    protected $table = 'subscriptions';
    protected $fillable = ['subscriptionid', 'notificationname', 'userid', 'usertype', 'contact', 'notificationchannel'];


    public function __construct($subscriptionid = null,  $notificationname = null, $userid = null, $usertype = null, $contact = null, $notificationchannel = null, $attributes = array())
    {
        parent::__construct($attributes);
        $this->subscriptionid = $subscriptionid;
        $this->notificationname = $notificationname;
        $this->userid = $userid;
        $this->usertype = $usertype;
        $this->contact = $contact;
        $this->notificationchannel = $notificationchannel;
    }


}





?>