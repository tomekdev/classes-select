<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [
      'mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_from_address', 'mail_from_name'
    ];

}
