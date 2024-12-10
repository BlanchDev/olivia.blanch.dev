<?php 

require ($_SERVER["DOCUMENT_ROOT"]."/api/dbFolder/includes.php");

$update_request = $baglanti->prepare("UPDATE chats SET chatpromtstart=? WHERE userid=? AND id=?");
$update_request->execute(array( $_POST['chatpromtstart'], $UserID, $_POST['chatId']));

/*$register_requestLog = $baglanti->prepare("INSERT INTO logs SET user_id=?, username=?, event=?, datee=?, ip=?");
$register_requestLog->execute(array( $UserID, $UserFullName, "chatId:".$_POST['chatId']." chatpromt:".$_POST['chatpromtstart'], $bugun, $ip));*/

?>