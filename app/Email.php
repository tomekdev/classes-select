<?php

namespace App;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Configuration;

class Email
{
    protected static $_configSet = false;
    
    public $template;
    public $to;
    public $title = "";
    public $data = [];
    
    public function  __construct($template) {
        $this->template = $template;
    }
    
    /*
     * Alternatywna statyczna metoda wysyłania
     *
     *  Przykład użycia:
     *  $mail = new Email('emails.termRemind');
     *  $mail->to = 'kokodzambo2014@gmail.com';
     *   $mail->title = 'TestMail';
     *   $mail->data = [
     *       'dateString' => 'someFancyDate',
     *       'url' => 'http://www.google.com'
     *   ];
     *   $mail->commit();
     */
    public function commit()
    {
        if (!self::$_configSet) {
            self::setConfig();
        }
        Mail::send($this->template, $this->data, function($message) {
            $message->to($this->to);
            $message->subject($this->title);
        });
    }
    
    /*
     * Alternatywna statyczna metoda wysyłania
     *
     *
     * Przykład użycia:
     * Email::send('emails.termRemind', 'kokodzambo2014@gmail.com', 'TestMail', [
     *      'dateString' => 'someFancyDate',
     *      'url' => 'http://www.google.com'
     *  ]);
     */
    public static function send($template, $to, $title, $data)
    {
        if (!self::$_configSet) {
            self::setConfig();
        }
        Mail::send($template, $data, function($message) use ($to, $title){
            $message->to($to);
            $message->subject($title);
        });
    }
    
    public static function setConfig($configuration = null)
    {
        if( $configuration = $configuration?: Configuration::get()->first() ){
            $mailConfig = app()['config']['mail'];
            $mailConfig['host'] = $configuration->mail_host;
            $mailConfig['port'] = $configuration->mail_port;
            $mailConfig['username'] = $configuration->mail_username;
            $mailConfig['password'] = Crypt::decrypt($configuration->mail_password);
            $mailConfig['encryption'] = $configuration->mail_encryption;
            $mailConfig['from']['name'] = $configuration->mail_from_name;
            app()['config']['mail'] = $mailConfig;
       }
    }
}
