<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\Mailman;


class ExampleController extends ResourceController{
  public function __construct()
    {
    }
  
  public sendMail(){
    $parser = service('parser');
            $data = [
                'text'   => "some interesting text"
            ];

            $htmlRendered = $parser->setData($data)
                ->render('emails/sampletext');
            $mailman = new Mailman();
            $mailman->senderEmail = "you@somewhere.com";
            $mailman->addRecipient("someone@somewhere.com");
            $mailman->subject = "A good subject";
            $mailman->htmlBody = $htmlRendered;
            $mailman->plaintext = "";
            if($mailman->send() === false){
                log_message('error', $mailman->responseError);
            }
  }
}
