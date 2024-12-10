<?php 

require ($_SERVER["DOCUMENT_ROOT"]."/api/dbFolder/includes.php");

$msg_time_ago_Visual = strtotime($bugun);

?>

<div class="msg column jcc">
  <div class="msgCame row">
    <img src="<?php echo $UserPP; ?>" alt="Profile Picture">
    <div class="msgDetails column">
      <div class="msgHead row aic">
        <div class="username"><?php echo $UserName; ?></div>
        <div class="msgDate"><?php echo timeAgo($msg_time_ago_Visual); ?></div>
      </div>
      <div class="msgContent"><?php echo htmlentities($_POST['msg']); ?></div>
    </div>
  </div>
</div>