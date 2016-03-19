<?php

class User{

	public $id;
	public $model;

	public function __construct($model){
		if (isset($_SESSION["user_id"])){
			$this->id = $_SESSION["user_id"];
		}else{
			$this->id = null;
		}

		$this->model = $model;
	}

	public function isLoggedIn(){
		return $this->id?true:false;
	}

	public function logout(){
		unset($_SESSION["user_id"]);
		$this->model->updateIsLoggedIn($id, 0);
	}

	public function login($id){
		$this->id = $id;
		$_SESSION["user_id"] = $id;
		$this->model->updateIsLoggedIn($id, 1);
	}
}