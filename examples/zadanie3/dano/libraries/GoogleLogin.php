<?php
require_once __DIR__.'/google/vendor/autoload.php';
require_once __DIR__.'/google/vendor/google/apiclient/src/Google/Service/Oauth2.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GoogleLogin{
	//const REDIRECT_URI = "http://147.175.99.84.nip.io/zadanie3/www/sign/in/google";
	const REDIRECT_URI = "http://webtech.com/zadanie3/www/sign/in/google";

	public $plus = null;
	public $client;
	public $service;

	public function __construct(){
		if (session_status() == PHP_SESSION_NONE) {
		    session_start();
		}
		if (isset($_GET['logout'])) {
			unset($_SESSION['access_token_googl']);
		}
		$this->client = new Google_Client();
		$this->client->setAuthConfigFile(__DIR__.'/client_secret_649875641118-nbu44jjd8kcdkqmf3gc8gashegkuegll.apps.googleusercontent.com.json');
		$this->client->setRedirectUri(self::REDIRECT_URI);
		$this->client->setScopes(array('https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile'));

		$this->service = new Google_Service_Oauth2($this->client);
	}

	public function code(){
		$this->client->authenticate($_GET['code']);
		$_SESSION['access_token_googl'] = $this->client->getAccessToken();
		header('Location: ' . filter_var(self::REDIRECT_URI, FILTER_SANITIZE_URL));
		exit;
	}

	public function setAccessToken(){
		$this->client->setAccessToken($_SESSION['access_token_googl']);
	}

	public function getAccessToken(){
		return $this->client->getAccessToken();
	}

	public function createAuthUrl(){
		return $this->client->createAuthUrl();
	}

	public function logout(){
		unset($_SESSION['access_token_googl']);
	}

	public function getInfo(){
		return $this->service->userinfo->get();
	}

}