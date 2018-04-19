<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['notificationid', 'notificationtype', 'internalemailtemplate', 'internalsmstemplate',
        'internalpushtemplate', 'externalemailtemplate', 'externalsmstemplate', 'externalpushtemplate',
        'messagecontent', 'notificationname', 'title', 'internalmessagecontent', 'externalmessagecontent'];


        public function __construct($aNotificationId = null, $aNotificationType  = null,  $aNotificationName  = null, $title =null,
                                    $anExtEmailTemplate  = null,  $anExtSmsTemplate  = null,  $aExtPushTemplate  = null,
                                    $anIntEmailTemplate  = null,  $anIntSmsTemplate  = null,  $aIntPushTemplate  = null,
                                    $internalmessagecontent  = null, $externalmessagecontent = null, $attributes= array()){

            parent::__construct($attributes);
            $this->notificationid = $aNotificationId;
            $this->notificationtype = $aNotificationType;
            $this->notificationname = $aNotificationName;
            $this->title = $title;
            $this->externalemailtemplate = $anExtEmailTemplate;
            $this->externalsmstemplate = $anExtSmsTemplate;
            $this->externalpushtemplate = $aExtPushTemplate;
            $this->internalemailtemplate = $anIntEmailTemplate;
            $this->internalsmstemplate = $anIntSmsTemplate;
            $this->internalpushtemplate = $aIntPushTemplate;
            $this->internalmessagecontent = $internalmessagecontent;
            $this->externalmessagecontent = $externalmessagecontent;
        }


}
