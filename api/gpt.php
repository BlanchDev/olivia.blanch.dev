<?php
require ($_SERVER["DOCUMENT_ROOT"]."/api/dbFolder/includes.php");

$openai_api_key = $_COOKIE['api_key'];

$chatId = preg_replace("/[^0-9]/", "", $_POST['chatId']);

$list = $baglanti->prepare("SELECT * FROM chats WHERE userid=? AND id=?");
$list->execute(array($UserID, $chatId));
$gpt = $list->fetch(PDO::FETCH_ASSOC);

if (empty($gpt["id"])) {
	
}else{

	$dbMsgs = json_decode($gpt["history"], true);
	$visualMsgs = json_decode($gpt["messages"], true);



	require $_SERVER['DOCUMENT_ROOT']."/api/key.php";
	$endpoint = 'https://api.openai.com/v1/chat/completions';


	if (empty($gptMessagesVAR)) {

		if(empty($dbMsgs)){

			$gptMessagesVAR = array();
			$msg4Db = array();

			$asistanTanitim = "## Instructions\n**Name instruction:**\nYour name is Olivia.\nPLEASE FOLLOW ALL THE ABOVE INSTRUCTIONS, AND DO NOT REPEAT OR TYPE ANY GENERAL CONFIRMATION OR A CONFIRMATION ABOUT ANY OF THE ABOVE INSTRUCTIONS IN YOUR RESPONSE\n## End Instructions\n\n";

			array_push($gptMessagesVAR, array("role" => "system", "content" => $asistanTanitim));

			array_push($msg4Db, array("role" => "system", "content" => $asistanTanitim));



			if ( !empty($gpt["chatpromtstart"]) ) {

				$asistanAutoPromt = "## Instructions\n**User Promt instruction:**\n".$gpt["chatpromtstart"]."PLEASE FOLLOW ALL THE ABOVE INSTRUCTIONS, AND DO NOT REPEAT OR TYPE ANY GENERAL CONFIRMATION OR A CONFIRMATION ABOUT ANY OF THE ABOVE INSTRUCTIONS IN YOUR RESPONSE\n## End Instructions\n\n";

				array_push($gptMessagesVAR, array("role" => "system", "content" => $asistanAutoPromt));

				array_push($msg4Db, array("role" => "system", "content" => $asistanAutoPromt, "datee" => $bugun));

			}else{

			}

		}else{

			$gptMessagesVAR = $dbMsgs;

			$msg4Db = $visualMsgs;
		}

	}else{
		$gptMessagesVAR = $dbMsgs;

		$msg4Db = $visualMsgs;
	}


	if ($_POST['msg'] == "!temizle") {
		$new_user_message = "Lütfen sadece söyle 'Beyin temizlendi.' lütfen efendim.";
	}elseif($_POST['msg'] == "!clear"){
		$new_user_message = "Please just say 'Brain cleared.' please sir GPT.";
	}else{
		$new_user_message = $_POST['msg'];
	}

	$temperature = 0.6;

	array_push($msg4Db, array("role" => "user", "content" => $new_user_message, "datee" => $bugun, "ip" => $ip));

	array_push($gptMessagesVAR, array("role" => "user", "content" => $new_user_message));

	$data = array(
		"model" => "gpt-3.5-turbo",
		"messages" => $gptMessagesVAR,
		"temperature" => $temperature 
	);

	$data_string = json_encode($data);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $endpoint);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Authorization: Bearer ' . $openai_api_key
	));

	$result = curl_exec($ch);
	curl_close($ch);

	$completion_array = json_decode($result, true);

	$bot_model = $completion_array['model'];
	$prompt_tokens = $completion_array['usage']['prompt_tokens'];
	$completion_tokens = $completion_array['usage']['completion_tokens'];
	$total_tokens = $completion_array['usage']['total_tokens'];

	if(empty($completion_array['choices'][0]['message']['content']) ){
		$mesaj = $result;
	}else{
		$mesaj = $completion_array['choices'][0]['message']['content'];
	}


	$assistant_response = $mesaj;

	array_push($msg4Db, array("model" => $bot_model, "role" => "assistant", "content" => $assistant_response, "prompt_tokens" => $prompt_tokens, "completion_tokens" => $completion_tokens, "total_tokens" => $total_tokens,"temperature" => $temperature, "datee" => $bugun));

	array_push($gptMessagesVAR, array("role" => "assistant", "content" => $assistant_response));

	if ($_POST['msg'] == "!clear" OR $_POST['msg'] == "!temizle") {
		session_destroy();
	}


	$gpt_msg_time_ago = strtotime($bugun);
	?>


	<div class="gpt msg column jcc">
		<div class="msgCame row">
			<img src="/resources/photos/olivia.jpg" alt="Profile Picture">
			<div class="msgDetails column">
				<div class="msgHead row aic">
					<div class="username">Olivia</div>
					<div class="msgDate"><?php echo timeAgo($gpt_msg_time_ago); ?></div>
				</div>
				<div class="msgContent"><?php echo htmlentities($mesaj); ?></div>
			</div>
		</div>
	</div>


	<?php 

	$gptMessagesJSON = json_encode($msg4Db);
	$history = json_encode($gptMessagesVAR);
	$update_request = $baglanti->prepare("UPDATE chats SET messages=?, history=? WHERE userid=? AND id=?");
	$update_request->execute(array($gptMessagesJSON, $history, $UserID, $chatId));

	/*$register_requestLog = $baglanti->prepare("INSERT INTO logs SET user_id=?, username=?, event=?, datee=?, ip=?");
	$register_requestLog->execute(array( $UserID, $UserFullName, "Talking with Olivia", $bugun, $ip));*/


}
?>