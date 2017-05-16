<?php

namespace App\Providers;

use Illuminate\Mail\MailServiceProvider;
use App\Customs\CustomTransportManager;
use App\Configuration;

class CustomMailServiceProvider extends MailServiceProvider{

    public function boot(){
        if( $configuration = Configuration::get()->first() ){

            $mailConfig = $this->app['config']['mail'];
            $mailConfig['host'] = $configuration->mail_host;
            $mailConfig['port'] = $configuration->mail_port;
            $mailConfig['username'] = $configuration->mail_username;
            $mailConfig['password'] = $configuration->mail_password;
            $mailConfig['from']['address'] = $configuration->mail_from_address;
            $mailConfig['from']['name'] = $configuration->mail_from_name;
            $this->app['config']['mail'] = $mailConfig;
       }
    }
}