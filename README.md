# AWS SES library for sending mail in Codeigniter 4

This libary uses SES APi to send mail 

## How to use it

Install AWS package using composer
```
composer install aws/aws-sdk-php
```

in Controller import the Mailman library

```
use App\Libraries\Mailman;
```

Then create object and use send method to send mail 

```
$mailman = new Mailman();
            $mailman->senderEmail = "your@email.com";
            $mailman->addRecipient("destination@email.com");
            $mailman->subject = "subject";
            $mailman->htmlBody = "<html><body>html content</body></html>;
            $mailman->plaintext = "";
            if($mailman->send() === false){
                log_message('error', $mailman->responseError);
            }
```


For more assistance and such code contact connect@zolute.consulting or visit https://www.zolute.consulting 
