<?php
require_once("initialise.php");
class MysqlDatabase{
	private $con;
	public function __construct(){
		$this->con = mysql_connect(DBHOST,DBUSER,DBPASS);
		mysql_select_db(DBNAME,$this->con);
	}
	public function close(){
		if(isset($this->con)){
			mysql_close($this->con);
		}
	}
	public function affected_rows(){
		return mysql_affected_rows()!=0 ? "true": "false";
	}
	public function escape_value($value){
		return mysql_real_escape_string($value);
	}
	public function query($sql){
		$result = mysql_query($sql);
		if(!$result){
			return false;
		}
		if(!is_resource($result)){
			return $result;
		}
		$rows = array();
		while($row = mysql_fetch_assoc($result)){
			array_push($rows,$row);
		}
		return $rows;
	} 
	public function insert($tableName,$key_val_pair){
		$fields = "";
		$values = "";
		foreach($key_val_pair as $key=>$val){
			$fields.=$key.",";
			$values.="'".$this->escape_value($val)."',";
		}
		$fields = rtrim($fields,",");
		$values =trim($values,",");
		$sql = "INSERT INTO ".$tableName." (".$fields.") VALUES (".$values.")";
		$result = false;
		$result = mysql_query($sql);
		return $result?true:false;
	}


	public function __destruct(){
		$this->close();
	}
}

