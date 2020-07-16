<?php

include 'MessengerResponse.php';

/* receive and send messages */
$input = json_decode(file_get_contents('php://input'), true);
if (isset($input['entry'][0]['messaging'][0]['sender']['id'])) {

    $sender = $input['entry'][0]['messaging'][0]['sender']['id']; 
	//mark as typing on
	MessengerResponse::typingOn($sender);
	//message type postback
	if (isset($input['entry'][0]['messaging'][0]['postback'])) {
		$payload = $input['entry'][0]['messaging'][0]['postback']['payload'];
		if ($payload === 'MENU_HOME') {
			sendQuickReplyMenu($sender);
		}
		else if ($payload === 'MENU_ABOUT') {
			$urlImg = "http://lyabs243.notifygroup.org/messenger/cover.jpg";
			MessengerResponse::sendPictureMessage($sender, $urlImg);
			
			$message = "This bot is a tool that allows you to have an overview on the different features that Messenger offers in relation to the creation of bots.";
			MessengerResponse::sendSimpleMessage($sender, $message);
			
		}
		else if ($payload === 'MENU_HELP') {
			$message = "This bot is a tool that allows you to have an overview on Messenger bot.";
			MessengerResponse::sendSimpleMessage($sender, $message);
			$message = "To start, click on the Home button which will display the different options on the functions of the botm then you can click on one of the buttons to see what it gives in message.";
			MessengerResponse::sendSimpleMessage($sender, $message);
		}
		else if ($payload === 'BUTTON_POSTBACK') {
			$message = "Click on Button postback 👍";
			MessengerResponse::sendSimpleMessage($sender, $message);
			sendQuickReplyMenu($sender);
		}
	}
	else if (isset($input['entry'][0]['messaging'][0]['message']['quick_reply'])) {
		$payload = $input['entry'][0]['messaging'][0]['message']['quick_reply']['payload'];
		
		if (substr($payload, 0, 6) === 'ACTION') { //show specific messenger model
			if ($payload === 'ACTION_SIMPLE_MESSAGE') {
				$message = "This is a simple message.";
				MessengerResponse::sendSimpleMessage($sender, $message);
			}
			else if ($payload === 'ACTION_IMAGE') {
				$urlImg = "http://lyabs243.notifygroup.org/messenger/foot_cover.jpg";
				MessengerResponse::sendPictureMessage($sender, $urlImg);
			}
			else if ($payload === 'ACTION_QUICK_REPLY') {
				$message = "The menu with the different buttons you see, it's already a quick reply";
				MessengerResponse::sendSimpleMessage($sender, $message);
			}
			else if ($payload === 'ACTION_GENERIC_TEMPLATE') {
				$elements = '[
				{
					"title":"Notify Afro Foot",
					"image_url":"http://lyabs243.notifygroup.org/messenger/afro_foot.png",
					"subtitle":"Score en direct du foot africain",
					"default_action": {
						"type": "web_url",
						"url": "https://play.google.com/store/apps/details?id=org.notifygroup.afrofoot",
						"messenger_extensions": false,
						"webview_height_ratio": "tall"
					},
					"buttons":[
					{
						"type":"web_url",
						"url":"https://play.google.com/store/apps/details?id=org.notifygroup.afrofoot",
						"title":"Install"
					}              
					]      
				},
				{
					"title":"Lubum RdcM Infos",
					"image_url":"http://lyabs243.notifygroup.org/messenger/lubum.png",
					"subtitle":"Let be inform!",
					"default_action": {
						"type": "web_url",
						"url": "https://play.google.com/store/apps/details?id=org.notifygroup.lubuminfos",
						"messenger_extensions": false,
						"webview_height_ratio": "tall"
					},
					"buttons":[
					{
						"type":"web_url",
						"url":"https://play.google.com/store/apps/details?id=org.notifygroup.lubuminfos",
						"title":"Install"
					}              
					]      
				}
				]';
				
				MessengerResponse::sendGenericTemplateMessage($sender, $elements);
			}
			else if ($payload === 'ACTION_BUTTON_TEMPLATE') {
				$buttons = '[
				{
					"type":"web_url",
					"url":"https://www.messenger.com",
					"title":"Messenger"
				},
				{
					"type":"postback",
					"payload":"BUTTON_POSTBACK",
					"title":"Button Postback"
				}
				]';
				$message = 'Templat button example!';
				
				MessengerResponse::sendButtonTemplateMessage($sender, $message, $buttons);
			}
			sendQuickReplyMenu($sender);
		}
		else if ($payload === 'NOTHING') {
			$message = "Thank you for using our bot, it was a real pleasure to chat with you😊; we hope to see you again soon, be well. Goodbye✋";
			MessengerResponse::sendSimpleMessage($sender, $message);
		}
	}
    
	//mark as typing on
	MessengerResponse::typingOff($sender);
}

function sendQuickReplyMenu($sender) {
	$quickReplies = '[
				{
					"content_type":"text",
					"title":"☺️ Simple Message",
					"payload":"ACTION_SIMPLE_MESSAGE"
				},
				{
					"content_type":"text",
					"title":"🖼️ Image",
					"payload":"ACTION_IMAGE"
				},
				{
					"content_type":"text",
					"title":"🔜 Quick Reply",
					"payload":"ACTION_QUICK_REPLY"
				},
				{
					"content_type":"text",
					"title":"😉 Generic Template",
					"payload":"ACTION_GENERIC_TEMPLATE"
				},
				{
					"content_type":"text",
					"title":"🔘 Button Template",
					"payload":"ACTION_BUTTON_TEMPLATE"
				},
				{
					"content_type":"text",
					"title":"😤 Nothing",
					"payload":"NOTHING"
				}
			]';
			$message = 'Choose the type of button you want to see';
			
			MessengerResponse::sendQuickReply($sender, $message, $quickReplies);
}

?>