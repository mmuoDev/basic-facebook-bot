<?php

class botClass{
    private $accessToken = null;
    function __construct() {
        //
    }

    public function setAccessToken($value){ //This method sets the access token
        $this->accessToken = $value;
    }
    public function readMessage($input) //This method reads message sent by the user
    {
        try {
            $senderId = $input['entry'][0]['messaging'][0]['sender']['id']; //sender facebook id
            $messageText = $input['entry'][0]['messaging'][0]['message']['text']; //text that user sent
            return ['senderId' => $senderId, 'message' => $messageText];
        }
        catch(Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function sendMessage($input){ // This method sends replies back to the user
        try{
                $message = $input['message'];
                $senderId = $input['senderId'];
                //var_dump($message);exit;
                $url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$this->accessToken;

                if ($message == "how do i know if i have stds?"){
                    $output = "The only way to know if you or a partner has an STD is to go for a test.";
                }
                else if ($message == "how do i know"){
                        $output = "hello";
                }else if ($message == "I am sorry"){
                        $output = "Fuck off and allow this bot rest";

                }else {
                        $output = "Fuck,what is you saying?";
                }
                    //Using curl to send messages

                    /*initialize curl*/
                    $ch = curl_init($url);
                    /*prepare response*/
                    $jsonData = '{
                    "recipient":{
                        "id":"' . $senderId . '"
                        },
                        "message":{
                            "text":"' . $output . '"
                        }
                    }';
                    //var_dump($output);exit;
                    /* curl setting to send a json post data */
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_exec($ch); // user will get the message

        }
        catch(Exception $ex) {
            return $ex->getMessage();
        }
    }

}


?>