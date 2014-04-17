<?php
require_once("initialise.php");
if($session->is_logged_in()){
	redirect_to("home.php");
}
	if(isset($_POST['login'])){
		$user = trim($_POST['uname']);
		$password = md5(trim($_POST['pswd']));
		$user = User::authenticate($user,$password);
		if($user){
			$session->login($user);
			redirect_to('home.php');
		}
		else{
			redirect_to('index.php');
		}
		

	}
?>