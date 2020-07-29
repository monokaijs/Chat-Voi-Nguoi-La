<?php
$choice = $payload['choice'];
if ($choice == "find_friend") {
	$checkingQuery = $conn->query("SELECT * FROM `pairs` WHERE `p1` = '' OR `p2` = '' AND NOT (`p1` = '$userId' OR `p2` = '$userId')");
	if (!$checkingQuery) {
		$bot->sendTextMessage($userId, "Lỗi!");
	}
	if ($user['state'] == '0') {
		if ($checkingQuery->num_rows == 0) {
			// create new pair
			if ($conn->query("INSERT INTO `pairs` (`p1`) VALUE ('$userId')")) {
				$pairId = $conn->insert_id;
				$bot->sendTextMessage($userId, "Đã tạo nhóm, vui lòng chờ người khác gia nhập vào nhé!");
				$conn->query("UPDATE `users` SET `state`='1', `joined_pair`=$pairId WHERE `messenger_id` = '$userId'");
			} else {
				// failed to create new pair
			}
		} else {
			$pair = $checkingQuery->fetch_assoc();
			$oldParticipant = $pair['p1'] !== "" ? $pair['p1'] : $pair['p2'];
			if ($conn->query("UPDATE `pairs` SET `p1` = '$oldParticipant', `p2` = '$userId' WHERE `id` = '{$pair['id']}'")) {
				$bot->sendTextMessage($userId, "Đã gia nhập nhóm " . $pair['id']);
				$conn->query("UPDATE `users` SET `state`='2', `joined_pair`={$pair['id']} WHERE `messenger_id` = '$userId'");
				$conn->query("UPDATE `users` SET `state`='2' WHERE `messenger_id` = '$oldParticipant'");
				$bot->sendTextMessage($oldParticipant, "Đã có người gia nhập nhóm, nói lời chào nhau đi nào!!");
			}
			
		}
	} elseif ($user['state'] == '1') {
		$bot->sendTextMessage($userId, "Bạn đang trong hàng chờ tìm kiếm, vui lòng đợi...");
	}
} else {
	
}
?>