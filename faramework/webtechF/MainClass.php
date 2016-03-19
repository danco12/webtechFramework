<?php

abstract class MainClass{

	/**
	 * [$database premenna na uchovanie pristupu k databaze]
	 * @var [mysqli]
	 */
	public $database;

	/**
	 * [$basePath description]
	 * @var [type]
	*/
	public $basePath;

	public $container;

	public function __construct($container){
		$this->container = $container;
		$this->database = self::initDatabase();
		$this->basePath = $container->basePath;
	}

	public function startup(){
		$args = $this->container->url_request["call_parts"];
		unset($args[0]);
		unset($args[1]);
		
		$function = "beforerender".ucfirst($this->container->template);
		call_user_func(array($this, $function), $args);

		if (isset($_POST) && !empty($_POST)){
			$args = array();
			foreach ($_POST as $key => $value) {
				$args[$key] = self::clean_input($value);
			}
			$form = array_search("Send", $args);
			unset($args[$form]);
			call_user_func(array($this, $form."Submit"), $args);
		}elseif( isset($_GET["action"])){

			$action = $_GET["action"];
			unset($_GET["action"]);
			call_user_func(array($this, "do".ucfirst($action)), $_GET);
		}
	}

	/**
		* [initDatabase inicializuje databazu]
		* @return [database] [objekt, ktory umoznuje pristup k databaze]
	*/
	public function initDatabase(){
		$db_info = $this->container->config["database"];

		$connection = new mysqli($db_info["host"], $db_info["name"], $db_info["password"], $db_info["database_name"]);
		$connection->set_charset("utf8");
		
		if ($connection->connect_error) {
			die("Connection failed: " . $connection->connect_error);
		}else{
			return $connection;
		}
	}

	function clean_input($data) {
		$data = strip_tags($data);
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	function redirect($url){
	   header('Location: ' . $url, true);
	   die();
	}
}