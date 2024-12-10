<?php


$dbuser = "USER";
$dbpass = "PASS";

try {
	$baglanti = new PDO('mysql:host=localhost;dbname=DBNAME', $dbuser, $dbpass);
	$baglanti -> exec("set names utf8");
	$baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo "Error!: " . $e->getMessage();
}



?>