<?php
$accessToken = "";  // PLACE YOUR FANPAGE'S ACCESS TOKEN HERE


$conn = new mysqli('localhost', 'root', '', 'db_chatvoinguoila');
if (!$conn) {
	die("Cannot establish connection to database.");
}