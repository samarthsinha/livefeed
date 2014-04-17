<?php
	require_once("initialise.php");
	reload(5);
	if($session->is_logged_in()){
			$following_list=$session->getFollowingList();
			// if(!empty($following_list)){
			// 	$following_list=explode(",",$session->getFollowingList());
			// }
			$sql = "SELECT id,username FROM users";
			$id_user_pair=array();
			$rows = $db->query($sql);

			foreach($rows as $row){
				$id_user_pair[$row['id']]=$row['username'];
			}
			$sql = "SELECT * FROM feeds WHERE user_id IN (".$following_list.") ORDER BY id DESC";
			$rows = $db->query($sql); 
			echo "<ul style='margin:0 auto;'>";
			foreach($rows as $row){
				echo "<li class='shouts' style='list-style:none; margin:0 auto;'>".$row['feed'].", @".$id_user_pair[$row['user_id']]."<hr></li>";
			}
			echo "</ul>";


	}