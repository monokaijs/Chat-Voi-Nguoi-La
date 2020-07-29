<?php
include "ChatFramework/autoload.php";
include "config.php";

$bot = new \NorthStudio\ChatFramework($accessToken, $isHubChallenge);
$builder = new \NorthStudio\MessageBuilder();

echo $bot->setupGettingStarted(json_encode(array(
	"event" => "start"
)));

echo $bot->setupGreetingMessage("Chào mừng bạn đã đến với Chat với người lạ!!!");

echo $bot->setupPersistentMenu(array(
	$builder->createButton("postback", "Menu", json_encode(array(
		"event" => "static_menu",
		"choice" => "show_menu"
	))),
	$builder->createButton("postback", "About", json_encode(array(
		"event" => "static_menu",
		"choice" => "show_about"
	))),
));



?>