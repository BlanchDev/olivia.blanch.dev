<?php 

require ($_SERVER["DOCUMENT_ROOT"]."/api/dbFolder/includes.php");

if ($_POST['righttabSelect'] == "userList") {
  setcookie("righttabSelect", "userList", time() + (86400 * 365), "/");
}

if ($_POST['righttabSelect'] == "chatSettings") {
  setcookie("righttabSelect", "chatSettings", time() + (86400 * 365), "/");
}


?>