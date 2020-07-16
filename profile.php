
<?php

//set bot profile
$token = 'YOUR_MESSENGER_BOT_TOKEN';
$url = 'https://graph.facebook.com/v2.6/me/messenger_profile?access_token=' . $token;

/*initialize curl*/
$ch = curl_init($url);
	
//message template button
$jsonData = '{
    "get_started": {"payload": "MENU_HOME"},
	"greeting": [
		{
			"locale":"default",
			"text":"Hello {{user_first_name}}, welcome to our beautiful bot! This bot allows you to have an overview on the different features that Messenger offers in relation to the creation of bots." 
		}
	],
	"persistent_menu": [
        {
			"locale": "default",
            "composer_input_disabled": false,
            "call_to_actions": [
                {
                    "type": "postback",
                    "title": "Home",
                    "payload": "MENU_HOME"
                },
                {
                    "type": "postback",
                    "title": "About",
                    "payload": "MENU_ABOUT"
                },
                {
                    "type": "postback",
                    "title": "Help",
                    "payload": "MENU_HELP"
                }
            ]
        }
    ]
    }';
	
/* curl setting to send a json post data */
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$result = curl_exec($ch); // user will get the message
var_dump($result);

?>