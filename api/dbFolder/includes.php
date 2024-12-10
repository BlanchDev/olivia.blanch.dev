<?php 

ob_start();
session_start();
header("Access-Control-Allow-Origin: https://olivia.blanch.dev");
date_default_timezone_set('Europe/Istanbul');
$bugun = date("H:i:s d.m.Y"); 
$ip = $_SERVER['REMOTE_ADDR'];
$url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

require($_SERVER['DOCUMENT_ROOT']."/api/dbFolder/connect.php"); 
require($_SERVER['DOCUMENT_ROOT']."/api/dbFolder/functions.php"); 


if ( empty($_COOKIE['userId']) ) {

	if (strstr($url, "/chat")) {
		
		header("Location:https://olivia.blanch.dev/user?action=login");

	}

	if (strstr($url, "/token")) {
		
		header("Location:https://olivia.blanch.dev/user?action=login");

	}

}else{


	if ( empty($_COOKIE["api_key"]) ) {

		if (strstr($url, "/chat")) {

			header("Location:https://olivia.blanch.dev/token");

		}


	}else{



		$userCheckMain = $baglanti->prepare("SELECT * FROM users WHERE user_id=?");
		$userCheckMain->execute( array($_COOKIE['userId']) );
		$userMain = $userCheckMain->fetch(PDO::FETCH_ASSOC);

		if ( empty($userMain["id"]) ) {
			header("Location:https://olivia.blanch.dev/user?action=login");
		}else{

			$userJsonData = json_decode($userMain["json"]);

			$UserID = $userJsonData->id;
			$UserName = $userJsonData->username;
			$UserFullName = $userJsonData->username."#".$userJsonData->discriminator;
			$UserAdress = $userJsonData->discriminator;
			$UserPP = "https://cdn.discordapp.com/avatars/".$userJsonData->id."/".$userJsonData->avatar;
			


			global $UserID; 
			global $UserName;
			global $UserFullName;
			global $UserAdress;
			global $UserPP;

		}

	}

}

if (empty($_COOKIE['righttabSelect'])) {
	setcookie("righttabSelect", "userList", time() + (86400 * 365), "/");
}

?>