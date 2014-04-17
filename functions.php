<?php
	
	function redirect_to($url){
 		header("Location: ".$url);
 	}
 	function reload($time)
	{		
			header('refresh:'.$time);
	}
	function __autoload($class_name){
		if(file_exists(lcfirst($class_name).".php")){
			require_once(lcfirst($class_name).".php");
		}
		else{
			die("Failed to find {$class_name} class");
		}
	}
	$db = new MysqlDatabase();
?>