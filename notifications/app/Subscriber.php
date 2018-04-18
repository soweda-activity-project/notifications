<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Subscriber extends Model
{

    protected $table = 'subscribers';
    protected $fillable = ['userid', 'name', 'emailaddress', 'phone', 'token', 'type'];


    public function __construct($anUserId = null, $name = null, $emailaddress = null, $phone = null, String $type = null, $token = null, $attributes = array()){

        parent::__construct($attributes);
        $this->userid = $anUserId;
        $this->name = $name;
        $this->phone = $phone;
        $this->emailaddress = $emailaddress;
        $this->type = $type;
        $this->token = $token;
    }
}
