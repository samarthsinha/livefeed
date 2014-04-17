<?php
	require_once("initialise.php");
	if(!$session->is_logged_in()){
		redirect_to("index.php");
	}
	$id=$session->user_id;
	if($_POST['submit']){
		$feed = trim($_POST['feed']);
		if(!$db->insert("feeds",array("user_id"=>$id,"feed"=>$feed))){
			$session->setMessage("error","Shouting Failed");
		}
		else{
			$redis = new Predis\Client(array(
	            "scheme" => "tcp",
	            "host" => "127.0.0.1",
	            "port" => 6379
	        ));
	        $content = "{\"content\": \"".$feed.", *<b>".$session->getUserUname."</b>\"}";
	        $redis->rpush("news",$content);
	        $redis->disconnect();
			// $session->setMessage("success","Successfully Shouted");
		}
		redirect_to("home.php");
	}
