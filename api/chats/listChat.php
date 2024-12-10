<?php 


require ($_SERVER["DOCUMENT_ROOT"]."/api/dbFolder/includes.php");


$list = $baglanti->prepare("SELECT * FROM chats WHERE userid=? AND trash=? ORDER BY id DESC");
$list->execute(array($UserID, "0"));

while($chats = $list->fetch(PDO::FETCH_ASSOC)){

	if ($_POST['active'] == $chats["id"]) {
		$chatBtnActive = "chatBtnActive";
	}else{
		$chatBtnActive = "";
	}

	$chat_time_ago = strtotime($chats["datee"]);

	?>
	<a href="https://olivia.blanch.dev/chat/<?php echo $chats["id"]; ?>" id="chatBtn<?php echo $chats["id"] ?>" onclick="openChat(this.id)" class="row aic chatBtn <?php echo $chatBtnActive; ?>">
		<i style="font-size: 1.1rem; color: gray;" class="fa-solid fa-message"></i>
		<div class="chatDetails column">
			<span class="chatName"><?php echo htmlentities($chats["chatname"]); ?></span>
			<span class="chatBirth"><?php echo timeAgo($chat_time_ago); ?></span>
		</div>
	</a>
	<?php

}


/*$register_requestLog = $baglanti->prepare("INSERT INTO logs SET user_id=?, username=?, event=?, datee=?, ip=?");
$register_requestLog->execute(array( $UserID, $UserFullName, "Chat Listed", $bugun, $ip));*/




?>