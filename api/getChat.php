<?php 

$chatId = $_GET['chatid'] ?? '';

$list = $baglanti->prepare("SELECT * FROM chats WHERE userid=? AND id=? AND trash=? ORDER BY id DESC");
$list->execute(array($UserID, $chatId, "0"));
$getchat = $list->fetch(PDO::FETCH_ASSOC);

if (empty($chatId)) {

	?>

	<div class="gpt msg column jcc">
		<div class="msgCame row">
			<img src="/resources/photos/olivia.jpg" alt="Profile Picture">
			<div class="msgDetails column">
				<div class="msgHead row aic">
					<div class="username">Olivia</div>
					<div class="msgDate"></div>
				</div>
				<div class="msgContent"><a style="color: #1a73e8;" href="https://olivia.blanch.dev/" title="Home Page">https://olivia.blanch.dev</a> 💜</div>
			</div>
		</div>
	</div>


	<?php

}else{

	if ( empty($getchat["messages"]) ) {

		?>

		<div id="chatStartPromt" class="chatNameSettings column" style="gap: 10px;">
			<label for="chatNameChange">Olivia | Chat Start Prompt</label>
			<textarea style="height: 35px; background: #0B282F; padding: 5px 10px; width: calc(100% - 10px);" id="chatStartPromtInput" oninput="autoGrow(this)" class="textArea row aic jcc"
			placeholder="ex. You are a software expert and you will help me by guiding and giving me ideas on the questions I will ask you."></textarea>
			<button style="width: max-content;" class="rightSaveBtn" id="chatStartPromtSave" >Start</button>
		</div>
		<script>

			$("#chatStartPromtSave").click(function(){

				var chatpromtstart = $("#chatStartPromtInput").val();

				$("#chatStartPromtInput").prop("disabled", true);
				$("#chatStartPromtSave").prop("disabled", true);

				$("#chatStartPromtSave").css({"background":"lightgreen"});

				$(".writing").css({"display":"flex"});
				$("#msgArea").css({"height":"26px"});

				$("#msgArea").prop("disabled", true);
				$("#sendMsg").prop("disabled", true);

				$(".msgList").animate({ scrollTop: $('.msgList').prop("scrollHeight")}, 500);
				$("#msgArea").val("");

				$.post("/api/ChatStartPromt.php",
				{
					chatpromtstart: chatpromtstart,
					chatId: "<?php echo $GETchatid; ?>"
				},
				function(data, status){

					$("#chatStartPromtSave").css({"background":"#0C2926"});

					$("#chatStartPromtInput").prop("disabled", false);
					$("#chatStartPromtSave").prop("disabled", false);

					$('#chatStartPromt').css({"display":"none"});


					$.post("/api/gpt.php",
					{
						msg: "Olivia!",
						chatId: "<?php echo $GETchatid; ?>"
					},
					function(data, status){
						var msgList = $("#innermsgList").html();

						$(".writing").css({"display":"none"});

						$("#innermsgList").html(msgList + " " + data);

						$("#innermsgList").animate({ scrollTop: $('#innermsgList').prop("scrollHeight")}, 500);

						$("#msgArea").prop("disabled", false);
						$("#sendMsg").prop("disabled", false);

						location.reload()

					});

				});

			});

		</script>


		<?php

	}else{


		$data = json_decode($getchat["messages"], true);

		foreach ($data as $message) {

			if ($message['role'] == 'assistant') {

				$msg_time_ago = strtotime($message['datee']);

				?>
				<div class="gpt msg column jcc">
					<div class="msgCame row">
						<img src="/resources/photos/olivia.jpg" alt="Profile Picture">
						<div class="msgDetails column">
							<div class="msgHead row aic">
								<div class="username">Olivia</div>
								<div class="msgDate"><?php echo timeAgo($msg_time_ago); ?></div>
							</div>
							<div class="msgContent"><?php echo htmlentities($message['content']); ?></div>
						</div>
					</div>
				</div>
				<?php
			}

			if ($message['role'] == 'user') {

				$gpt_msg_time_ago = strtotime($message['datee']);
				?>
				<div class="msg column jcc">
					<div class="msgCame row">
						<img src="<?php echo $UserPP; ?>" alt="Profile Picture">
						<div class="msgDetails column">
							<div class="msgHead row aic">
								<div class="username"><?php echo $UserName; ?></div>
								<div class="msgDate"><?php echo timeAgo($gpt_msg_time_ago); ?></div>
							</div>
							<div class="msgContent"><?php echo htmlentities($message['content']); ?></div>
						</div>
					</div>
				</div>
				<?php
			}
		}

	}

}

/*$register_requestLog = $baglanti->prepare("INSERT INTO logs SET user_id=?, username=?, event=?, datee=?, ip=?");
$register_requestLog->execute(array( $UserID, $UserFullName, "Chat Get", $bugun, $ip));*/

?>