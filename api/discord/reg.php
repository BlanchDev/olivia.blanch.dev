<?php 

$userJson = json_encode($user);
$userObj = json_decode($userJson);
$userId = $userObj->id;
$nick = $userObj->username."#".$userObj->discriminator;

$userCheck = $baglanti->prepare("SELECT * FROM users WHERE user_id=?");
$userCheck->execute(array($userObj->id));
$userData = $userCheck->fetch(PDO::FETCH_ASSOC);

if ( empty($userData["user_id"]) ) {

	$register_request = $baglanti->prepare("INSERT INTO users SET user_id=?, json=?, premium=?, role=?, datee=?, ip=?");
	$register_request->execute(array( $userId, $userJson, "0", "User", $bugun, $ip));


	$register_request2 = $baglanti->prepare("INSERT INTO logs SET user_id=?, username=?, event=?, datee=?, ip=?");
	$register_request2->execute(array( $userId, $nick , "register", $bugun, $ip));


	setcookie("userId", $userId, time() + (86400 * 365), "/");
	setcookie("righttabSelect", "userList", time() + (86400 * 365), "/");

}else{

	$update_request = $baglanti->prepare("UPDATE users SET json=? WHERE user_id=? ");
	$update_request->execute(array($userJson, $userId));

	$register_request2 = $baglanti->prepare("INSERT INTO logs SET user_id=?, username=?, event=?, datee=?, ip=?");
	$register_request2->execute(array( $userId, $nick , "login", $bugun, $ip));


	setcookie("userId", $userId, time() + (86400 * 365), "/");

}





?>