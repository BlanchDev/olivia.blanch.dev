<?php 

require ($_SERVER["DOCUMENT_ROOT"]."/api/dbFolder/includes.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require($_SERVER["DOCUMENT_ROOT"]."/head.php"); ?>

  <title>Token - Olivia</title>
</head>
<body>


  <div id="settingsArea" class="column aic" style="gap: 25px; z-index: 99999; width: 500px; height: 550px; background: linear-gradient(27deg, rgba(11,43,41,1) 0%, rgba(11,29,43,1) 20%, rgba(6,8,38,1) 95%); border-radius: 20px; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); padding: 50px;">

    <p class="column" style="padding: 20px; background: rgba(35, 155, 85, 0.1); border-radius: 2px 10px 20px 2px; border-left: 3px solid #43bd84;" >We store your API key as a cookie and do not save it in our database. We have no intention of learning your key. Therefore, please ensure that you have saved your key in a secure location as we cannot assist you if you forget it. <a style="color: orangered;" href="https://platform.openai.com/account/api-keys" target="_blank" title="OpenAI Api Key Page">Account API Keys - OpenAI API</a></p>

    <div class="tokenSettings column aic" style="width: 100%; gap: 10px;">
      <label for="chatNameChange">Your GPT Token</label>
      <input style="width: 100%;" id="APITokenInput" type="password" placeholder="Key">
      <button class="rightSaveBtn" id="APITokenSaveBtn" >Save</button>
      <span id="APITokenRespLine" class="column jcc" style="display: none; border-bottom: 3px solid #43bd84; padding: 10px; background: rgba(35, 155, 65, 0.1); border-radius: 5px;"></span>
    </div>

  </div>

  <script>

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

</body>
</html>