<?php
include "ChatFramework/autoload.php";
include "config.php";

$isHubChallenge = true;
$bot = new \NorthStudio\ChatFramework($accessToken, $isHubChallenge);
$builder = new \NorthStudio\MessageBuilder();



// now we will get the sender's id
$userId = $bot->getSenderId();

$user = array(
	"name" => "",
	"messenger_id" => "",
	"state" => "0",
	"joined_pair" => "0"
);

$checkUserQuery = $conn->query("SELECT * FROM `users` WHERE `messenger_id` = '$userId'");
if ($checkUserQuery->num_rows == 0) {
	$userInfo = $bot->getUserData($userId);
	$addUserQuery = $conn->query("INSERT INTO `users` (`name`, `messenger_id`, `state`) VALUES ('{$userInfo['name']}', '$userId', '0')");
	if ($addUserQuery) {
		// first message when user come to chatbot
		$bot->sendTextMessage($userId, "Chào mừng bạn đã đến với Chatbot Chat với người lạ!");
	} else {
		$bot->sendTextMessage($userId, "Lỗi trong quá trình thêm tài khoản vào hệ thống!");
	}
} else {
	$user = $checkUserQuery->fetch_assoc();
}

if ($bot->isPostBack) {
	$payload = json_decode($bot->getPayload(), true);
	if ($payload['event'] == "static_menu") {
		include "./events/static_menu.php";
	} elseif ($payload['event'] == "main_menu") {
		include "./events/main_menu.php";
	} else {
		// invalid event
	}
} else {
	// $bot->sendTextMessage($userId, "Not a Postback!");
	if ($user['state'] == '2') {
		$pairQuery = $conn->query("SELECT * FROM `pairs` WHERE `id` = {$user['joined_pair']}");
		if ($pairQuery && $pairQuery->num_rows == 1) {
			$pair = $pairQuery->fetch_assoc();
			$otherParticipant = $pair['p1'] == $userId ? $pair['p2'] : $pair['p1'];
			
			$bot->sendTextMessage($otherParticipant, $bot->getMessageText());
		}
	}
}






