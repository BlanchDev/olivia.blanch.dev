<?php 
require ($_SERVER["DOCUMENT_ROOT"]."/api/dbFolder/includes.php");

$listCheck1 = $baglanti->prepare("SELECT * FROM chats WHERE userid=? AND trash=? ORDER BY id DESC");
$listCheck1->execute(array($UserID, "0"));
$last = $listCheck1->fetch(PDO::FETCH_ASSOC);


$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url_parts = explode('/', $url_path);
$GETchatid = $url_parts[2] ?? "";


if ( empty($GETchatid) ) {
  $list = $baglanti->prepare("SELECT * FROM chats WHERE userid=? AND trash=? ORDER BY id DESC");
  $list->execute(array($UserID, "0"));
  $chat = $list->fetch(PDO::FETCH_ASSOC);
}else{
  $list = $baglanti->prepare("SELECT * FROM chats WHERE userid=? AND id=? AND trash=? ORDER BY id DESC");
  $list->execute(array($UserID, $GETchatid, "0"));
  $chat = $list->fetch(PDO::FETCH_ASSOC);
}

$dbChatid = $chat["id"] ?? "-1";

if ( $dbChatid == $GETchatid ) {
  $checkGet = "true";
}else{
 $checkGet = "false";
}

if ( $checkGet == "false" ) {

  if ($url == "olivia.blanch.dev/chat") {

  }else{
   header("Location:https://olivia.blanch.dev/chat");
 }

}


if ($checkGet == "true") {

  $chatNameTop = htmlentities($chat["chatname"]);

}else{

  $chatNameTop = "Welcome!";

}


?>
<!DOCTYPE html>
<html lang="en">
<head>

  <?php require($_SERVER["DOCUMENT_ROOT"]."/head.php"); ?>

  <title><?php echo $chatNameTop ?? "Welcome!"; ?> - Olivia</title>

</head>

<body>

  <div id="leftBar" class="leftBar column aic jcsb" style="user-select: none !important;">

    <div class="chatSettings column aic jcc" style="width: 100%; height: max-content;">

      <div class="barTitles" style="width: 100%;">
        <a href="/chat" class="row aic jcc bigBtn" style="width: 100%; gap: 10px;">HOME PAGE</a>
      </div>

      <div class="chats column" style="overflow-y: auto; gap: 10px; padding: 10px; width: 100%;">

        <div class="column aic jcc" style="gap: 10px; margin: 15px 0px; width: 100%;">

          <button id="createNewChat" style="gap: 10px; width: 90%;" class="leftBarGreenBtn row aic jcc">
            <i class="fa-solid fa-plus"></i> New chat
          </button>

        </div>

        <script>

          $("#createNewChat").click(function(){

           $.post("/api/chats/createChat.php",
           {
            info: "create"
          },
          function(data, status){

            location.href = 'https://olivia.blanch.dev/chat/'+data;

          });

         });

       </script>


       <?php 
       $listChats = $baglanti->prepare("SELECT * FROM chats WHERE userid=? AND trash=? ORDER BY id DESC");
       $listChats->execute(array($UserID, "0"));
       while($chatBtn = $listChats->fetch(PDO::FETCH_ASSOC)){

        if ($GETchatid == $chatBtn["id"]) {
          $chatBtnActive = "chatBtnActive";
        }else{
          $chatBtnActive = "";
        }

        $chat_time_ago = strtotime($chatBtn['datee']);

        ?>
        <a href="https://olivia.blanch.dev/chat/<?php echo $chatBtn["id"]; ?>" id="chatBtn<?php echo $chatBtn["id"] ?>" onclick="openChat(this.id)" class="row aic chatBtn <?php echo $chatBtnActive ?? ""; ?>">
          <i style="font-size: 1.1rem; color: gray;" class="fa-solid fa-message"></i>
          <div class="chatDetails column">
            <span id="<?php echo $chatBtnActive ?? ""; ?>" class="chatName"><?php echo htmlentities($chatBtn["chatname"]); ?></span>
            <span class="chatBirth"><?php echo timeAgo($chat_time_ago); ?></span>
          </div>
        </a>
        <?php

      }
      ?>

    </div>
    <script>

      function openChat(id){

        $(".chatBtn").removeClass("chatBtnActive");

        $("#"+id).addClass("chatBtnActive");

      }

    </script>
  </div>


  <div class="userSettings row aic jcsb" style="background: #030513; width: 100%; padding: 10px 15px;">

    <div class="user row aic" style="gap: 10px;">
      <img style="width: 35px; height:35px; border-radius: 50%" src="<?php echo $UserPP; ?>" alt="Profile Picture">
      <div class="userRole" >
        <div class="Name" style="font-size: 0.8rem; font-weight: 600;"><?php echo $UserName; ?></div>
      </div>
    </div>

    <i id="openSettingsScreen" style="font-size: 1.05rem; color:B5BAC1; cursor: pointer; padding: 5px;" class="fa-solid fa-gear"></i>

  </div>

</div>

<div id="centerBar" class="centerBar column aic">

  <div id="phoneSideBarSaver" style="z-index: 9999; display: none; position: absolute; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.7);">
  </div>

  <div id="userSettingsScreen" style="z-index: 999999; display: none; position: absolute; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);">

    <div id="settingsArea" class="column aic" style="gap: 25px; z-index: 99999; width: 500px; height: 550px; background: linear-gradient(27deg, rgba(11,43,41,1) 0%, rgba(11,29,43,1) 20%, rgba(6,8,38,1) 95%); border-radius: 20px; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); padding: 50px;">

      <i id="closeSettingsScreen" style=" z-index: 99999; position: absolute; right: 25px; top: 15px; color: mediumaquamarine; padding: 10px; font-size: 1.1rem; cursor: pointer;" class="fa-solid fa-xmark"></i>

      <p class="column jcc" style="padding: 20px; background: rgba(35, 155, 85, 0.1); border-radius: 2px 10px 20px 2px; border-left: 3px solid #43bd84;" >We store your API key as a cookie and do not save it in our database. We have no intention of learning your key. Therefore, please ensure that you have saved your key in a secure location as we cannot assist you if you forget it. <a style="color: orangered;" href="https://platform.openai.com/account/api-keys" target="_blank" title="OpenAI Api Key Page">Account API Keys - OpenAI API</a></p>

      <div class="tokenSettings column aic" style="width: 100%; gap: 10px;">
        <label for="chatNameChange">Your GPT Token</label>
        <input style="width: 100%;" id="APITokenInput" type="password" placeholder="Key">
        <button class="rightSaveBtn" id="APITokenSaveBtn" >Save</button>
        <span id="APITokenRespLine" class="column jcc" style="display: none; border-bottom: 3px solid #43bd84; padding: 10px; background: rgba(35, 155, 65, 0.1); border-radius: 5px;"></span>
      </div>

    </div>

    <script>

      $("#openSettingsScreen").click(function(){

        $('#userSettingsScreen').css({'display':'flex'});

      });

      $("#closeSettingsScreen").click(function(){

        $('#userSettingsScreen').css({'display':'none'});

      });

      $("#APITokenSaveBtn").click(function(){

        $.post("/api/key.php",
        {
          api_key: $("#APITokenInput").val(),
        },
        function(data, status){

          $("#APITokenInput").val("");

          $("#APITokenRespLine").css({"display":"flex"});
          $("#APITokenRespLine").html(data);

        });

      });
    </script>

  </div>

  <?php 


  ?>
  <div class="barTitles chatTopBar row aic jcsb">
    <div class="row aic" style="gap: 30px;" >

      <i id="openLeftBar" class="showMobile fa-solid fa-bars"></i>

      <div class="chatTitle row aic jcc" style="gap: 10px;"><i class="fa-solid fa-hashtag"></i> <span id="chatTitle"><?php echo $chatNameTop ?? "Welcome!"; ?> </span></div>
    </div>
    <div class="row aic">
      <?php if($checkGet == "true"){?>

        <i id="openRightBar" class="showMobile fa-solid fa-users-gear"></i>

      <?php } ?>

    </div>
  </div>

  <div id="chatArea" class="chatArea column aic jcsb">

    <div id="msgList" class="msgList column">


      <?php 

      if ( !isset($GETchatid) AND $checkGet == "true" ) {

        ?>

        <div class="gpt msg column jcc">
          <div class="msgCame row">
            <img src="/resources/photos/olivia.jpg" alt="Profile Picture">
            <div class="msgDetails column">
              <div class="msgHead row aic">
                <div class="username">Olivia</div>
                <div class="msgDate">🟢</div>
              </div>
              <div class="msgContent">You need create "New Chat".</div>
            </div>
          </div>
        </div>

        <?php

      }else{
        require ($_SERVER["DOCUMENT_ROOT"]."/api/getChat.php");
      }

      ?>


    </div>

    <div class="chatBox column aic" style="width: 100%; gap: 10px;">

      <div id="writing" class="row aic writing" style="display:none;">
        <i class="fa-solid fa-pen fa-shake"></i>
        <div><span style="color:#00ff8c !important; background: linear-gradient(to right, #00ff8c) !important; -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important; font-weight:bold;" >Olivia</span> writing...</div>
      </div>

      <?php if( $checkGet == "true") { ?>
        <div class="writeMsg row aic" style="position: relative; z-index: 99;">
          <textarea required id="msgArea" oninput="autoGrow(this)" class="textArea row aic jcc"
          placeholder="Send a message to Olivia."></textarea>
          <button id="sendMsg" data-id="" class="row aic jcc chatSendBtn">
            <i class="fa-solid fa-paper-plane"></i>
          </button>
          <span style="display: none;" id="chatID" ><?php echo $_GET['chatid'] ?? ''; ?></span>
          <script>
            function autoGrow(element) {
              element.style.height = "0px";
              element.style.height = (element.scrollHeight) + "px";
            }

            $('#msgArea').keypress(function(event) {
              if (event.keyCode == 13 && !event.shiftKey) { 
                $('#sendMsg').click(); 
                autoGrow(element); 
              }
            });

            $("#sendMsg").click(function(){

             var msgArea = $("#msgArea").val();
             var msgList = $("#msgList").html();
             var chatId = $("#chatID").html();

             $(".writing").css({"display":"flex"});
             $("#msgArea").css({"height":"26px"});

             $("#msgArea").prop("disabled", true);
             $("#sendMsg").prop("disabled", true);

             $("#msgList").animate({ scrollTop: $('#msgList').prop("scrollHeight")}, 500);
             $("#msgArea").val("");

             $.post("/api/visual.php",
             {
              msg: msgArea
            },
            function(data, status){

              $("#msgList").html(msgList + " " + data);
              $('#chatStartPromt').css({"display":"none"});


           /* -----------*/
              $.post("/api/gpt.php",
              {
                msg: msgArea,
                chatId: chatId
              },
              function(data, status){
                var msgList = $("#msgList").html();

                $(".writing").css({"display":"none"});

                $("#msgList").html(msgList + data);

                $("#msgList").animate({ scrollTop: $('#msgList').prop("scrollHeight")}, 500);

                $("#msgArea").prop("disabled", false);
                $("#sendMsg").prop("disabled", false);

          /*alert("Data: " + data + "\nStatus: " + status);*/
              });






            });

           }); 
         </script>
       </div>
     <?php } ?>
   </div>

 </div>

</div>

<?php  

if ($checkGet == "true") {

  ?>

  <div id="rightBar" class="rightBar column">

    <div class="barTitles row aic jcc chatSettings">

      <button id="usersTab" class="rightBarTabBtn row aic jcc">Users</button>
      <button id="chatSettingsTab" class="rightBarTabBtn row aic jcc">Settings</button>

    </div>

    <div class="rightBarDetails column aic" style="padding: 10px;">


      <style type="text/css" media="screen">
        <?php 

        if ($_COOKIE['righttabSelect'] == "userList") {
          ?>
          #usersTab{
            border-bottom: 1px solid mediumaquamarine;
          }

          #userList{
            display: flex;
          }
          #chatsettings{
            display: none;
          }
          <?php
        }

        if ($_COOKIE['righttabSelect'] == "chatSettings") {
          ?>
          #chatSettingsTab{
            border-bottom: 1px solid mediumaquamarine;
          }

          #userList{
            display: none;
          }
          #chatsettings{
            display: flex;
          }
          <?php
        }

        ?>
      </style>  

      <div id="userList" class="userlist column aic" style="width: 100%; gap: 5px;">

        <?php 
        $userListCheck = $baglanti->prepare("SELECT * FROM users ORDER BY role ASC");
        $userListCheck->execute( );
        while ($userList = $userListCheck->fetch(PDO::FETCH_ASSOC)) {

          $usersData = json_decode($userList["json"]);

          if($userList["role"] == "User"){
            ?>
            <div class="user row aic">
              <img src="<?php echo "https://cdn.discordapp.com/avatars/".$usersData->id."/".$usersData->avatar; ?>" alt="Profile Picture" onerror="this.src='https://olivia.blanch.dev/resources/photos/discordPP.jpg'">
              <div class="userRole">
                <div class="Name">Anonymous User</div>
                <div class="Role"><?php echo $userList["role"]; ?></div>
              </div>
            </div>
            <?php 
          }else{
            ?>
            <div class="user row aic">
              <img src="<?php echo "https://cdn.discordapp.com/avatars/".$usersData->id."/".$usersData->avatar; ?>" alt="Profile Picture" onerror="this.src='https://olivia.blanch.dev/resources/photos/discordPP.jpg'">
              <div class="userRole">
                <?php if ($usersData->discriminator == "0"){ ?>
                <div class="Name"><?php echo $usersData->username; ?></div>
              <?php }else{ ?>
              <div class="Name"><?php echo $usersData->username."#".$usersData->discriminator; ?></div>
            <?php } ?>
                <div class="Role"><?php echo $userList["role"]; ?></div>
              </div>
            </div>
            <?php 
          }

        }

        ?>

      </div>


      <div id="chatsettings" class="chatsettings column aic" style="width: 100%; gap: 20px; padding: 10px;">



        <button id="ChatTrash" style="gap: 10px; width: 90%;"  href="/chat" class="leftBarGreenBtn row aic jcc">
          <i class="fa-solid fa-trash"></i> Trash Chat<br>(Double Click)
        </button>

        <script>

          $("#ChatTrash").dblclick(function(){

            $.post("/api/ChatTrash.php",
            {
              chatId: "<?php echo $GETchatid; ?>"
            },
            function(data, status){

              location.href = 'https://olivia.blanch.dev/chat/'+data;

            });

          });

        </script>

        <div class="chatNameSettings column aic" style="gap: 5px;">
          <label for="chatNameChange">Chat Name</label>
          <input style="width: 100%;" id="chatNameChange" type="text" placeholder="Chat Name" value="<?php echo htmlentities($chat["chatname"]); ?>">
          <button class="rightSaveBtn" id="chatNameSaveBtn" >Save</button>
        </div>
        <script>

          $("#chatNameSaveBtn").click(function(){

            var chatname = $("#chatNameChange").val();

            $("#chatNameChange").prop("disabled", true);
            $("#chatNameSaveBtn").prop("disabled", true);

            $("#chatNameSaveBtn").css({"background":"lightgreen"});

            $.post("/api/ChatName.php",
            {
              chatname: chatname,
              chatId: "<?php echo $GETchatid; ?>"
            },
            function(data, status){

              $("#chatBtnActive").html(chatname);
              $("#chatTitle").html(chatname);
              $("title").text(chatname + " - Olivia");

              $("#chatNameSaveBtn").css({"background":"#0C2926"});

              $("#chatNameChange").prop("disabled", false);
              $("#chatNameSaveBtn").prop("disabled", false);

            });

          });

        </script>


      </div>

    </div>

    <script>

      $("#usersTab").click(function(){

       $.post("/api/rightBarCookie.php",
       {
        righttabSelect: "userList"
      },
      function(data, status){

        $(".rightBarTabBtn").css({"border":"none"});
        $("#usersTab").css({"border-bottom":"1px solid mediumaquamarine"});

        $("#userList").css({"display":"flex"});
        $("#chatsettings").css({"display":"none"});

      });

     });

      $("#chatSettingsTab").click(function(){

       $.post("/api/rightBarCookie.php",
       {
        righttabSelect: "chatSettings"
      },
      function(data, status){

        $(".rightBarTabBtn").css({"border":"none"});
        $("#chatSettingsTab").css({"border-bottom":"1px solid mediumaquamarine"});

        $("#userList").css({"display":"none"});
        $("#chatsettings").css({"display":"flex"});

      });

     });

   </script>

 </div>

 <?php 

}else{

}

?>

<div style="position: fixed; bottom: 10px; right: 10px;" >
  💜
</div>

<script>

  $("#msgList").animate({ scrollTop: $('#msgList').prop("scrollHeight")}, 10);


  $("#phoneSideBarSaver").click(function(){

    $('#leftBar').css({'display':'none'});
    $('#rightBar').css({'display':'none'});
    $('#phoneSideBarSaver').css({'display':'none'});

  });

  $("#openLeftBar").click(function(){

    if ($('#leftBar').css('display') == "none" ) {

      $('#leftBar').css({'display':'flex'});
      $('#rightBar').css({'display':'none'});
      $('#phoneSideBarSaver').css({'display':'flex'});

    }else{

      $('#leftBar').css({'display':'none'});
      $('#rightBar').css({'display':'none'});
      $('#phoneSideBarSaver').css({'display':'none'});

    }

  }); 

  $("#openRightBar").click(function(){

    if ($('#rightBar').css('display') == "none" ) {

      $('#rightBar').css({'display':'flex'});
      $('#leftBar').css({'display':'none'});
      $('#phoneSideBarSaver').css({'display':'flex'});

    }else{

      $('#rightBar').css({'display':'none'});
      $('#leftBar').css({'display':'none'});
      $('#phoneSideBarSaver').css({'display':'none'});

    }

  }); 


</script>
</body>

</html>