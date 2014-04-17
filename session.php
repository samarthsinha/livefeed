<?php
require_once("initialise.php");
class Session{
	protected $logged_in=false;
	public $user_id;
	public $user_uname;
	public $user_name;
	public $following_list;
	public function __construct(){
		session_start();
		$this->check_login();
		if($this->logged_in){

		}
		else{

		}
	}
	public function is_logged_in(){
		return $this->logged_in;
	}
	public function login($user){
		if($user){
			$this->user_id = $_SESSION['user_id'] = $user->id;
			$this->user_uname = $_SESSION['user_uname'] = $user->user;
			$this->user_name = $_SESSION['user_name'] = $user->name;
			$this->following_list = $_SESSION['following_list']=$user->following_list;
			$this->logged_in = true;
		}
	}
	public function logout(){
		unset($_SESSION['user_id']);
		unset($_SESSION['user_uname']);
		unset($_SESSION['user_name']);
		unset($_SESSION['following_list']);
		unset($this->user_id);
		unset($this->user_uname);
		unset($this->user_name);
		$this->logged_in = false;
	}
	private function check_login(){
		if(isset($_SESSION['user_id'])){
			$this->user_id = $_SESSION['user_id'];
			$this->logged_in = true;
		}
		else{
			unset($this->user_id);
			$this->logged_in=false;
		}
	}
	public function setMessage($type,$message){
		$_SESSION['message'] = array('type'=>$type,'message'=>$message);
	}
	public function getMessage(){
		if(isset($_SESSION['message'])) {
    		printf("<div class='message %s'>%s</div>", $_SESSION['message']['type'],
    		$_SESSION['message']['message']);
    		unset($_SESSION['message']);
		}
	}
	public function getUserUname(){
		if(isset($_SESSION['user_uname'])) {
    		return $_SESSION['user_uname'];
		}
		return null;
	}
	public function getUserName(){
		if(isset($_SESSION['user_name'])) {
    		return $_SESSION['user_name'];
		}
		return null;
	}
	public function getFollowingList(){
		if(isset($_SESSION['following_list'])){
			return $_SESSION['following_list'];
		}
		return "";
	}
	public function updateFollowingList($list){
		$_SESSION['following_list']=$list;
	}
}
$session = new Session();

