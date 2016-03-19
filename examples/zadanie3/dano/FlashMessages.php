<?php

class FlashMessages{

	public $messages = array();

	public function __construct(){
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
		
		if (isset($_SESSION["messages"])){
			$this->messages = $_SESSION["messages"];
		}
	}

	public function addMessage($message, $class){
		array_push( $this->messages, array(
					"message" => $message,
					"type" => $class
			));

		$_SESSION["messages"] = $this->messages;
	}

	public function getMessages(){
		$_SESSION["messages"] = array();
		return $this->messages;
	}

	public function exist(){
		return empty($this->messages)?false:true;
	}

	// public function clean(){
	// 	$this->messages = array();
	// 	$_SESSION["messages"] = array();
	// }
}