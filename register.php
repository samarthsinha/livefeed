<?php
	require_once("initialise.php");
	if(isset($_POST['register'])){
		$name = trim($_POST['name']);
		$user = trim($_POST['uname']);
		$password = md5(trim($_POST['pswd']));
		if(!$db->insert('users',array('username'=>$user,
								  'passwd'=>$password,
								  'name'=>$name,
								  'created_at'=>date("Y-m-d H:i:s"),
								  'ts_update'=>date("Y-m-d H:i:s")))){
			die("ERROR"+mysql_error());
			$session->setMessage('error',"Unable to register");
		}
		else
		{
			$session->setMessage('success', "Registered Successfully. Login to start ShoutOutLoud :)");
		}
		redirect_to('index.php');
		

	}
?>