<?php

error_reporting(~E_NOTICE);
	class Init{
		/**
		 * [$basePath cesta k priecinku www]
		 * @var [string]
		 */
		public $basePath;

		/**
		 * [$requested_file nazov suboru, ktory pozadoval uzivatel]
		 * @var [string]
		 */
		public $requested_file;

		/**
		 * [$file subor, ktory sa realne zobrazi]
		 * @var [string]
		 */
		public $file;

		/**
		 * [$path cesta k suboru $file]
		 * @var [string]
		 */
		public $path;

		/**
		 * [$title nadpis stranky, zobrazi sa pri zdielani, alebo v tabe prehliadaca]
		 * @var [string]
		 */
		public $title;

		/**
		 * [$database premenna na uchovanie pristupu k databaze]
		 * @var [mysqli]
		 */
		public $database;


		public function init(){

			$this->basePath = "http://" . $_SERVER["HTTP_HOST"] . "/zadanie2/www";
			$this->requested_file = isset($_GET["file"]) ? $_GET["file"] : null;
			
			self::setPathAndFile();
			
			$this->title = self::getTitle();
			$this->database = self::initDatabase();
		}

		/**
		 * [getTitle rozparsuje titles.neon a vrati string zodpovedajuci aktualnej stranke]
		 * @return [string] [Title aktualnej stranky]
		 */
		public function getTitle(){
			
			$titles = self::parseNeon($this->basePath."/../app/config/titles.neon");
			return isset($titles[$this->file]) ? $titles[$this->file] : null;
		}

		function parse_path() {
			$path = array();
			if (isset($_SERVER['REQUEST_URI'])) {
				$request_path = explode('?', $_SERVER['REQUEST_URI']);

				$path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');

				$path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
				$path['call'] = utf8_decode($path['call_utf8']);

				if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
					$path['call'] = '';
				}

				$path['call_parts'] = explode('/', $path['call']);
				
				$path['query_utf8'] = urldecode($request_path[1]);

				$path['query'] = utf8_decode(urldecode($request_path[1]));
				$vars = explode('&', $path['query']);

				foreach ($vars as $var) {
					$t = explode('=', $var);
					$path['query_vars'][$t[0]] = $t[1];
				}
			}
			return $path;
		}

		/**
		 * [setPathAndFile nastavi premennu $file a $path]
		 */
		public function setPathAndFile(){
			if ( $this->requested_file && $this->requested_file != "index" && $this->requested_file != "homepage")
				if (file_exists('../app/pages/' . $this->requested_file . ".php")){
					$this->file = $this->requested_file;
					$this->path = '../app/pages/' . $this->requested_file . ".php";
				}else{
					$this->file = "404";
					$this->path = '../app/pages/404.html';
				}
			else{
				if ($this->requested_file)
					header('Location: ' . $this->basePath);
				$this->file = "homepage";
				$this->path = '../app/pages/homepage.php';
			}
		}

		/**
		 * [parseNeon rozparsuje jednoduchy neon]
		 * @param  [type] $path [adresa suboru (.neon)]
		 * @return [type]       [pole informacii zo suboru]
		 */
		public function parseNeon($path){
			require_once __DIR__. "/libraries/Decoder.php";

			$neon_decoder = new Decoder();

			$array = $neon_decoder->decode(file_get_contents($path));

			return $array;
		}


		/**
		 * [initDatabase inicializuje databazu]
		 * @return [database] [objekt, ktory umoznuje pristup k databaze]
		 */
		public function initDatabase(){
			$db_info = self::parseNeon($this->basePath."/../app/config/config.neon")["databse"];

			$connection = new mysqli($db_info["host"], $db_info["name"], $db_info["password"], $db_info["database_name"]);

			if ($connection->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}else{
				return $connection;
			}
		}
	}

?>