<?php

require ($_SERVER["DOCUMENT_ROOT"]."/api/dbFolder/includes.php");

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)
error_reporting(E_ALL);*/

define('OAUTH2_CLIENT_ID', 'asdasdsadas'); //Your client Id
define('OAUTH2_CLIENT_SECRET', 'asdasdsadas'); //Your secret client code

$authorizeURL = 'https://discordapp.com/api/oauth2/authorize';
$tokenURL = 'https://discordapp.com/api/oauth2/token';
$apiURLBase = 'https://discordapp.com/api/users/@me';


// Start the login process by sending the user to Discord's authorization page
if(get('action') == 'login') {

	$params = array(
		'client_id' => OAUTH2_CLIENT_ID,
		'redirect_uri' => 'https://olivia.blanch.dev/user',
		'response_type' => 'code',
		'scope' => 'email identify'
	);

  // Redirect the user to Discord's authorization page
	header('Location: https://discordapp.com/api/oauth2/authorize' . '?' . http_build_query($params));
	die();
}


// When Discord redirects the user back here, there will be a "code" and "state" parameter in the query string
if(get('code')) {

  // Exchange the auth code for a token
	$token = apiRequest($tokenURL, array(
		"grant_type" => "authorization_code",
		'client_id' => OAUTH2_CLIENT_ID,
		'client_secret' => OAUTH2_CLIENT_SECRET,
		'redirect_uri' => 'https://olivia.blanch.dev/user',
		'code' => get('code')
	));
	$logout_token = $token->access_token;
	$_SESSION['access_token'] = $token->access_token;

	header('Location: https://olivia.blanch.dev/user');
}

if(!empty($_SESSION['access_token']) ) {
	$user = apiRequest($apiURLBase);

	require ($_SERVER["DOCUMENT_ROOT"]."/api/discord/reg.php");

	header("Location:https://olivia.blanch.dev/chat");

}else{

	header("Location:https://olivia.blanch.dev/user?action=user");

	echo '<h3>Not logged in</h3>';
	echo '<p><a href="?action=login">Log In</a></p>';
}


if(get('action') == 'logout') {
  // This must to logout you, but it didn't worked(

	$params = array(
		'access_token' => $logout_token
	);

  // Redirect the user to Discord's revoke page
	header('Location: https://discordapp.com/api/oauth2/token/revoke' . '?' . http_build_query($params));
	die();
}

function apiRequest($url, $post=FALSE, $headers=array()) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	$response = curl_exec($ch);


	if($post)
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

	$headers[] = 'Accept: application/json';

	if(session('access_token'))
		$headers[] = 'Authorization: Bearer ' . session('access_token');

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$response = curl_exec($ch);
	return json_decode($response);
}

function get($key, $default=NULL) {
	return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

function session($key, $default=NULL) {
	return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}

?>