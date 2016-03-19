<?php

class UserManager{

	public $database;

	public function __construct($database){
		$this->database = $database;
	}

	public function getAll(){
		return $this->database->query("SELECT * FROM user");
	}

	public function byId($id){
		$res = $this->database->query("SELECT * FROM user WHERE id = '".$id."'");

		if ($res){
			return $res->fetch_assoc();
		}else{
			return null;
		}
	}

	public function byEmail($email){
		$res = $this->database->query("SELECT * FROM user WHERE email = '".$email."'");

		if ($res){
			return $res->fetch_assoc();
		}else{
			return null;
		}
	}

	public function byLdap($ldap){
		$res = $this->database->query("SELECT * FROM user WHERE ldap = '".$ldap."'");

		if ($res){
			return $res->fetch_assoc();
		}else{
			return null;
		}
	}

	public function byNick($nick){
		$res = $this->database->query("SELECT * FROM user WHERE nick='".$nick."'");
		if ($res){
			return $res->fetch_assoc();
		}else{
			return null;
		}
	}

	public function add($values){
		$insert_values = array();
		$insert_columns = array();

		foreach ($values as $key => $value) {
			array_push($insert_columns, $key);
			array_push($insert_values, "'" . $value . "'");
		}

		$this->database->query("INSERT INTO user (".implode(",", $insert_columns).") VALUES (".implode(",", $insert_values).")");

		return isset($this->database->insert_id)?$this->database->insert_id:null;
	}

	public function getLastLogin($id = null){
		if ($id){
			$query = "SELECT * FROM last_login WHERE user = $id ORDER BY time DESC";
		}else{
			$query = "SELECT * FROM last_login ORDER BY time DESC";
		}

		return $this->database->query($query);
	}

	public function addLastLogin($user_id, $type){
		$this->database->query("INSERT INTO last_login (type, user) VALUES ('".$type."', '".$user_id."')");
	}

	public function getStats(){
		return $this->database->query("SELECT type, COUNT(id) AS 'pocet' FROM last_login GROUP BY type");
	}

	public function updateIsLoggedIn($user_id, $login){

		$update_query = "UPDATE user SET login = " . $login . " WHERE id = " . $user_id;
		$this->database->query($update_query);
	}

	public function getOnline(){
		return $this->database->query("SELECT nick FROM user WHERE login = 1");
	}

}