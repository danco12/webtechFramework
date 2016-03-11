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
		 * [$class trieda ktora sa ma pouzit]
		 * @var [string]
		*/ 
		public $class;
		
		/**
		 * [$url_request rozparsovana url]
		 * @var [array]
		 */
		public $url_request;

		/**
		 * [$template sablona ktora sa ma pouzit]
		 * @var [string]
		*/
		public $template;

		/**
		 * [$title nadpis stranky, zobrazi sa pri zdielani, alebo v tabe prehliadaca]
		 * @var [string]
		 */
		public $title;

		/**
		 * [$config objekt, ktory obsahuje udaje zo suboru config.neon]
		 * @var [array]
		 */
		public $config;

		/**
		 * [init inicializacna funkcia danoFrameworku]
		 * @return [none] [nič]
		 */
		public function init(){
			$this->basePath = "http://" . $_SERVER["HTTP_HOST"];
			$this->requested_file = isset($_GET["file"]) ? $_GET["file"] : null;
			
			$this->url_request = self::parse_path();

			$this->title = self::getTitle();

			$this->config = self::parseNeon(__DIR__."/../app/config/config.neon");		
		}

		/**
		 * [getTitle rozparsuje titles.neon a vrati string zodpovedajuci aktualnej stranke]
		 * @return [string] [Title aktualnej stranky]
		 */
		public function getTitle(){
			
			$titles = self::parseNeon(__DIR__."/../app/config/titles.neon");
			return isset($titles[$this->class][$this->template]) ? $titles[$this->class][$this->template] : null;
		}

		/**
		 * [parse_path vytvori objekt z url, aby sa s tym dalo jednoduchsie pracovat]
		 * @return [array] [rozparsovana url]
		 */
		public function parse_path() {
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
			if (isset($path["call_parts"][0]) && $path["call_parts"][0] != "")
				$this->class = $path["call_parts"][0];
			else
				$this->class = "homepage";

			if (isset($path["call_parts"][1]) && $path["call_parts"][1] != "")
				$this->template = $path["call_parts"][1];
			else
				$this->template = "default";
			return $path;
		}

		/**
		 * [parseNeon rozparsuje neon]
		 * @param  [type] $path [adresa suboru (.neon)]
		 * @return [type]       [pole informacii zo suboru]
		 */
		public function parseNeon($path){
			require_once __DIR__. "/libraries/Decoder.php";
			$neon_decoder = new Decoder();
			$array = $neon_decoder->decode(file_get_contents($path));

			return $array;
		}
	}

?>