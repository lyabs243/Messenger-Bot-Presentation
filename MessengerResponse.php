<?php 
	class MessengerResponse {
		
		static $token = 'YOUR_MESSENGER_BOT_TOKEN';
		static $urlMessages = 'https://graph.facebook.com/v2.6/me/messages?access_token=';
		
		static public function sendSimpleMessage($sender, $message) {
			$jsonData = '{
			"recipient":{
				"id":"' . $sender . '"
				},
				"message":{
					"text":"' . $message . '"
				}
			}';
			
			self::sendPostRequest(self::$urlMessages, $jsonData);
		}
		
		static public function sendQuickReply($sender, $message, $quickReplies) {
			$jsonData = '{
			"recipient":{
				"id":"' . $sender . '"
				},
				"messaging_type": "RESPONSE",
				"message":{
					"text": "' . $message . '",
					"quick_replies":' . $quickReplies . '
			  }
			}';
			
			self::sendPostRequest(self::$urlMessages, $jsonData);
		}
		
		static public function sendPictureMessage($sender, $urlImage) {
			$jsonData = '{
			"recipient":{
				"id":"' . $sender . '"
				},
				"message":{  
				"attachment":{
				  "type":"image", 
				  "payload":{
					"url":"' . $urlImage . '", 
					"is_reusable":true
				  }
				}
			  }
			}';
			
			self::sendPostRequest(self::$urlMessages, $jsonData);
		}
		
		static public function sendGenericTemplateMessage($sender, $elements) {
			$jsonData = '{
			"recipient":{
				"id":"' . $sender . '"
				},
				"message":{
					"attachment":{
					"type":"template",
					"payload":{
					"template_type":"generic",
					"elements":' . $elements . '
					}
					}
				}
			}';
			self::sendPostRequest(self::$urlMessages, $jsonData);
		}
		
		static public function sendButtonTemplateMessage($sender, $message, $buttons) {
			$jsonData = '{
			"recipient":{
				"id":"' . $sender . '"
				},
				"message":{
				"attachment":{
					"type":"template",
					"payload":{
						"template_type":"button",
						"text":"' . $message . '",
						"buttons":' . $buttons . '
					}
					}
				}
			}';
			self::sendPostRequest(self::$urlMessages, $jsonData);
		}
		
		static public function typingOn($sender) {
			//sender action typing on
			$jsonData = '{
			"recipient":{
				"id":"' . $sender . '"
				},
				"sender_action":"typing_on"
			}';
			
			self::sendPostRequest(self::$urlMessages, $jsonData);
		}
		
		static public function typingOff($sender) {
			//sender action typing on
			$jsonData = '{
			"recipient":{
				"id":"' . $sender . '"
				},
				"sender_action":"typing_off"
			}';
			
			self::sendPostRequest(self::$urlMessages, $jsonData);
		}
		
		static private function sendPostRequest($url, $jsonData) {
			/*initialize curl*/
			$ch = curl_init($url . self::$token);
			
			/* curl setting to send a json post data */
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			$result = curl_exec($ch); // user will get the message
			
			return $result;
		}
	}