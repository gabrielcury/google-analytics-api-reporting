<?php

function is_logged_in(){
	global $authenticator;
	if($_GET){
		$username = $_GET['username'];
		$password = $_GET['password'];
	}

	if($username && $password && $authenticator->verifyLoginCredentials($username, $password)){
		return true;
	}else{
		return false;
	}
}

function print_pretty($var){
   ?>
    <pre>
    <?php
    print_r($var);
    ?>
    </pre>
    <?php
}