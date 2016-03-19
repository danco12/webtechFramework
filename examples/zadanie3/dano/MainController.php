<?php
require_once __DIR__."/FlashMessages.php";

/*modely*/
require_once __DIR__."/../app/models/UserManager.php";

abstract class MainClass{

	/**
	 * $database premenna na uchovanie pristupu k databaze
	 * @var mysqli
	 */
	public $database;

	/**
	 * $basePath cesta k index.php
	 * @var string
	*/
	public $basePath;

	public $container;

	/*modely*/
	public $user_manager;

	/**
	 * [$Flash_messages sprava flashmessage-ov]
	 * @var [flashMessages]
	 */
	public $flash_messages;

	/**
	 * [$user uchovava informacie o prihlasenom uzivatelovy]
	 * @var [User]
	 */
	public $user;

	public function __construct($container){
		$this->container = $container;
		$this->database = self::initDatabase();
		$this->basePath = $container->basePath;

		$this->flash_messages = new FlashMessages();

		/**
		 * modely
		 */
		$this->user_manager = new UserManager($this->database);

		$this->user = new User($this->user_manager);
	}

	/**
	 * startup funkcia, ktora treba spustit vzdy po vytvoreni instancie kvôli spravnemu chodu aplikacie
	 * @return null nic
	 */
	public function startup(){
		// if (substr_count("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", "nip.io") > 0)
		// 	$this->redirect(str_replace("nip.io", "", "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"), 1);
		$args = $this->container->url_request["call_parts"];
		unset($args[0]);
		unset($args[1]);
		
		$function = "beforerender".ucfirst($this->container->template);

		if (is_callable(array($this, $function)))
			call_user_func(array($this, $function), $args);

		if (isset($_POST) && !empty($_POST)){
			$args = array();
			foreach ($_POST as $key => $value) {
				if ($key != "password")
					$args[$key] = self::clean_input($value);
				else
					$args[$key] = $value;
			}

			$form = array_search("Send", $args);
			unset($args[$form]);

			$formFunction = $form . "Submit";
			if (is_callable(array($this, $formFunction)))
				call_user_func(array($this, $formFunction), $args);
		}elseif( isset($_GET["action"])){

			$action = "do".$_GET["action"];
			unset($_GET["action"]);

			if (is_callable(array($this, $action)))
				call_user_func(array($this, "do".ucfirst($action)), $_GET);
		}
	}

	/**
		* initDatabase inicializuje databazu
		* @return database objekt, ktory umoznuje pristup k databaze
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

	/**
	 * clean_input ocisti formularove inputy od zbytocnych medzier, html tagov, lomitiek
	 * @param  string $data [hodnota inputu]
	 * @return string       [ocistena hodnota]
	 */
	function clean_input($data) {
		$data = strip_tags($data);
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	/**
	 * [redirect presmerovanie]
	 * @param  string $url [Cesta kam sa ma presmerovat. Je to vsetko okrem domeny]
	 * @return [type]      [nic]
	 */
	function redirect($url = "", $fullPath = 0){
		if ($fullPath)
	   		header('Location: ' . $url, true);
		else
	   		header('Location: ' . $this->basePath . $url, true);
		
		die();
	}
}