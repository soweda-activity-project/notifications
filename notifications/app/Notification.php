<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['notificationid', 'notificationtype', 'internalemailtemplate', 'internalsmstemplate', 'internalpushtemplate', 'externalemailtemplate', 'externalsmstemplate', 'externalpushtemplate', 'messagecontent', 'notificationname'];


        public function __construct($aNotificationId = null, $aNotificationType  = null,  $aNotificationName  = null,
                                    $anExtEmailTemplate  = null,  $anExtSmsTemplate  = null,  $aExtPushTemplate  = null,
                                    $anIntEmailTemplate  = null,  $anIntSmsTemplate  = null,  $aIntPushTemplate  = null,
                                    $aMessageContent  = null, $attributes= array()){

            parent::__construct($attributes);
            $this->notificationid = $aNotificationId;
            $this->notificationtype = $aNotificationType;
            $this->notificationname = $aNotificationName;
            $this->externalemailtemplate = $anExtEmailTemplate;
            $this->externalsmstemplate = $anExtSmsTemplate;
            $this->externalpushtemplate = $aExtPushTemplate;
            $this->internalemailtemplate = $anIntEmailTemplate;
            $this->internalsmstemplate = $anIntSmsTemplate;
            $this->internalpushtemplate = $aIntPushTemplate;
            $this->messagecontent = $aMessageContent;
        }


}
