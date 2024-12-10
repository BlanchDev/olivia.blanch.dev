<?php 

require ($_SERVER["DOCUMENT_ROOT"]."/api/dbFolder/includes.php");

$update_request = $baglanti->prepare("UPDATE chats SET chatname=? WHERE userid=? AND id=?");
$update_request->execute(array( $_POST['chatname'], $UserID, $_POST['chatId']));

/*$register_requestLog = $baglanti->prepare("INSERT INTO logs SET user_id=?, username=?, event=?, datee=?, ip=?");
$register_requestLog->execute(array( $UserID, $UserFullName, "chatId:".$_POST['chatId']." chatName:".$_POST['chatname'], $bugun, $ip));*/

?>