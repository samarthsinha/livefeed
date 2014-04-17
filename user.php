<?php
require_once("initialise.php");
class User {
	public $id;
	public $user;
	public $name;
	private $passwd;
	public $created_at;
	public $following_list;
	private $access_rights=0;
	public function __construct(){

	}
	private function setPassword($p){
		$this->passwd=$p;
	}
	public function getAccessRights(){
		return $access_rights;
	}
	public static function authenticate($user,$pass){
		global $db;
		global $session;
		$sql = "SELECT * FROM users WHERE username='".$user."' AND passwd ='".$pass."' LIMIT 1";
		$rows = $db->query($sql);
		if($db->affected_rows()!='false'){
			$userObj = new User();
			$userObj->id = $rows[0]['id'];
			$userObj->user =  $rows[0]['username'];
			$userObj->name = $rows[0]['name'];
			$userObj->setPassword($rows[0]['passwd']);
			$userObj->following_list=!empty($rows[0]['following_id'])? $rows[0]['following_id']:"";
			return $userObj;
		}
		return false;
	}
} 

?>
