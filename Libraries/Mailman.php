<?php

namespace App\Libraries;
use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

class Mailman{

    protected $SesClient;
    var $senderEmail;
    protected $recipientEmails;
    public $messageID;
    public $responseError;
    protected $replytoAddress;
    var $subject;
    var $htmlBody;
    var $plaintext;
    var $charset;


    function __construct()
    {
        $this->SesClient = new SesClient([
            'version' => '2010-12-01',
            'region'  => 'us-east-1'
        ]);
        $this->messageID=0;
        $this->responseError=false;
        $this->recipientEmails=[];
        $this->replytoAddress=[];
        $this->subject = "";
        $this->plaintext = "";
        $this->htmlBody = "";
        $this->charset = "UTF-8";
        
    } 

    function addRecipient($recipientAddress){
        $this->recipientEmails[] = $recipientAddress;
    }

    function addReplyTo($replytoAddress){
        $this->replytoAddress = $replytoAddress;
    }

    private function prepareReplyTo(){
        if(empty($this->replytoAddress)){
            $this->replytoAddress[]=$this->senderEmail;
        }
    }


    function send(){
        $this->prepareReplyTo();
        try {
            $result = $this->SesClient->sendEmail([
                'Destination' => [
                    'ToAddresses' => $this->recipientEmails,
                ],
                'ReplyToAddresses' => $this->replytoAddress,
                'Source' => $this->senderEmail,
                'Message' => [
                    'Body' => [
                        'Html' => [
                            'Charset' => $this->charset,
                            'Data' => $this->htmlBody,
                        ],
                        'Text' => [
                            'Charset' => $this->charset,
                            'Data' => $this->plaintext,
                        ],
                    ],
                    'Subject' => [
                        'Charset' => $this->charset,
                        'Data' => $this->subject,
                    ],
                ],
                // If you aren't using a configuration set, comment or delete the
                // following line
                //'ConfigurationSetName' => $configuration_set,
            ]);
            $this->messageID = $result['MessageId'];
            return true;
        } catch (AwsException $e) {
            // output error message if fails
            $this->responseError = $e->getAwsErrorMessage();
            return false;
        }
    }

}
