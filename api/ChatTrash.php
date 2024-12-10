<?php 

require ($_SERVER["DOCUMENT_ROOT"]."/api/dbFolder/includes.php");

$update_request = $baglanti->prepare("UPDATE chats SET trash=? WHERE userid=? AND id=?");
$update_request->execute(array( "1", $UserID, $_POST['chatId']));

/*$register_requestLog = $baglanti->prepare("INSERT INTO logs SET user_id=?, username=?, event=?, datee=?, ip=?");
$register_requestLog->execute(array( $UserID, $UserFullName, "chatId:".$_POST['chatId']." Chat Trash", $bugun, $ip));*/


$listCheck1 = $baglanti->prepare("SELECT * FROM chats WHERE userid=? AND trash=? ORDER BY id DESC");
$listCheck1->execute(array($UserID, "0"));
$last = $listCheck1->fetch(PDO::FETCH_ASSOC);

echo $last["id"] ?? "";

?>