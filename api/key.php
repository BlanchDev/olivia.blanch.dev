<?php 

if ( !empty($_POST['api_key']) ) {

    setcookie("api_key", $_POST['api_key'], time() + (86400 * 365), "/");

    echo 'The key has been saved as a cookie. If you clear your browser, the key will be lost. <a style="font-weight: 600; color:greenyellow;" href="/chat" title="Chat Page">Start talking with Olivia.</a>';

}

?>