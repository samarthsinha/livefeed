<?php
require_once("initialise.php");
if(!$session->is_logged_in()){
	redirect_to("index.php");
}
$id=$session->user_id;
$following_list=$session->getFollowingList();
if(!empty($following_list)){
	$following_list=explode(",",$session->getFollowingList());
}
else{
	$following_list=array();
}
if(isset($_GET['id']) && !empty($_GET['id'])){
	if(!in_array($_GET['id'], $following_list)){
		array_push($following_list,$_GET['id'] );
		$following_list = implode(",", $following_list);
		$sql = "UPDATE users SET following_id = '".$following_list."' WHERE id=".$id;
		if(!$db->query($sql)){
			$session->setMessage('error',"Follow Failed");
		}
		else{
			$session->updateFollowingList($following_list);
			$session->setMessage('success',"Started Following");
		}

	}
	else{
		$session->setMessage('info',"Already Following ");
	}
	
}
else{
	$session->setMessage('error',"Missing Parameter");
}
redirect_to('home.php');
