<?php 

require ($_SERVER["DOCUMENT_ROOT"]."/api/dbFolder/includes.php");


if ($_POST["info"] == "create") {

	$register_request = $baglanti->prepare("INSERT INTO chats SET userid=?, chatname=?, messages=?, history=?, chatsettings=?, datee=?, ip=?, trash=?");
	$register_request->execute(array( $UserID, "New Chat", "", "", "Ayarlar", $bugun, $ip, "0" ));

	/*$register_requestLog = $baglanti->prepare("INSERT INTO logs SET user_id=?, username=?, event=?, datee=?, ip=?");
	$register_requestLog->execute(array( $UserID, $UserFullName, "Chat Created", $bugun, $ip));*/


	$listCheck1 = $baglanti->prepare("SELECT * FROM chats WHERE userid=? AND trash=? ORDER BY id DESC");
	$listCheck1->execute(array($UserID, "0"));
	$last = $listCheck1->fetch(PDO::FETCH_ASSOC);

	echo $last["id"] ?? "";

}



?>