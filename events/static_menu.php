<?php
$choice = $payload['choice'];
if ($choice == "show_menu") {
	if ($user['state'] == 0) {
		// currently have no action
		$firstButton = $builder->createButton("postback", "Tìm bạn", json_encode(array(
			"event" => "main_menu",
			"choice" => "find_friend"
		)));
	} elseif ($user['state'] == 1) {
		// currently waiting for other participant
		$firstButton = $builder->createButton("postback", "Hủy tìm bạn", json_encode(array(
			"event" => "main_menu",
			"choice" => "cancel_find_friend"
		)));
	} else {
		// currently in conversation
		$firstButton = $builder->createButton("postback", "Ngắt kết nối", json_encode(array(
			"event" => "main_menu",
			"choice" => "quit_conversation"
		)));
	}
	$menu = $builder->createButtonTemplate("Chào mừng bạn đến với Chat với người lạ, bạn muốn làm gì nào?", [
		$firstButton,
		$builder->createButton("web_url", "Trang chủ", "", "https://nstudio.vn"),
	]);
	$bot->sendMessage($userId, $menu);
} elseif ($choice == "show_about") {
	$bot->sendTextMessage($userId, "Bot Author: @MonokaiJs");
} else {
	
}
?>