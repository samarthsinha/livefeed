<?php
require_once("initialise.php");
if(!$session->is_logged_in()){
	redirect_to("index.php");
}
$session->logout();
redirect_to("index.php");
?>