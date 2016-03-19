<?php
require_once(__DIR__."/../../dano/libraries/GoogleLogin.php");
class Sign extends MainClass{

	public $authUrl;

	public function __construct($container){
		parent::__construct($container);
	}

	public function startup(){
		parent::startup();
		if ($this->user->isLoggedIn()){
			$this->redirect("/dashboard");
		}
	}

	public function loginFormSubmit($values){
		$data = $this->user_manager->byNick($values["nick"]);

		if (password_verify($values["password"], $data["password"]) ){
			$this->user->login($data["id"]);
			$this->user_manager->addLastLogin($this->user->id,"databaza");
			$this->flash_messages->addMessage("Úspešne si sa prihlásil", "success");
			$this->redirect("/dashboard");
		}else{
			$this->flash_messages->addMessage("Zlé prihlasovacie meno alebo heslo", "danger");
			$this->redirect("/sign/in");
		}
	}

	public function loginLdapFormSubmit($values){

		$ldapconfig['host'] = 'ldap.stuba.sk';

		$ldapconfig['port'] = '389';

		$ldaprdn  = "uid=".$values["nick"].", ou=People, DC=stuba, DC=sk";
		$password = $values["password"];

		if (!($ldapconn=ldap_connect($ldapconfig['host'], $ldapconfig['port']))) {    

			$this->flash_messages->addMessage("Nepodarilo sa pripojiť k LDAP-u", "danger");
			$this->redirect();

		} 

		ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

		if ($bind=ldap_bind($ldapconn, $ldaprdn, $password)) {

			$sr = ldap_search($ldapconn, $ldaprdn, "uid=".$values["nick"]);

			$entry = ldap_first_entry($ldapconn, $sr);

			$meno = ldap_get_values($ldapconn, $entry, "givenname")[0];
			$priezvisko = ldap_get_values($ldapconn, $entry, "sn")[0];
			$email = ldap_get_values($ldapconn, $entry, "mail")[0];
			$nick = strtolower($meno . "-" . $priezvisko . "-ldap-" . rand ( 1 , 999 ));
			$password = password_hash($nick, PASSWORD_DEFAULT );
			$uid = ldap_get_values($ldapconn, $entry, "uisid")[0];

			$row = $this->user_manager->byLdap($uid);
			$id = $row["id"];
			if (!$row)
				$id = $this->user_manager->add(array(
					"email" => $email,
					"name" => $meno,
					"surname" => $priezvisko,
					"nick" => $nick,
					"password" => password_hash($nick, PASSWORD_DEFAULT ),
					"ldap" => $uid
				));

			$this->user->login($id);

			$this->user_manager->addLastLogin($this->user->id,"ldap");
			$this->flash_messages->addMessage("Úspešne si sa prihlásil", "success");
			$this->redirect("/dashboard");
		} else {
			echo "<pre>";
			var_dump($bind);
			exit;
			$this->flash_messages->addMessage("Nepodaril sa bind na LDAP", "danger");
			$this->redirect("/sign/ldap");

		}
	}

	public function registerFormSubmit($values){
		if (!$this->user_manager->byEmail($values["email"])){
			$values["password"] = password_hash($values["password"], PASSWORD_DEFAULT );
			$this->user_manager->add($values);
			$this->flash_messages->addMessage("Úspešne si sa zaregistroval, môžeš sa prihlásiť", "success");
			$this->redirect("/sign/in");
		}else{
			$this->flash_messages->addMessage("Niekde nastala chyba", "danger");
			$this->redirect("/sign/up");
		}

	}

	public function beforerenderIn($args){
		$google = new GoogleLogin();
	
		$this->authUrl = $google->createAuthUrl();

		if ($args[2] == "google"){
			if (isset($_GET['logout']))
				$google->logout();

			if (isset($_GET['code']))
				$google->code();

			if (isset($_SESSION['access_token_googl']) && $_SESSION['access_token_googl'])
				$google->setAccessToken();
			else
				$this->authUrl = $google->createAuthUrl();

			if ($google->getAccessToken()){
				$guser = $google->getInfo();
				$google->setAccessToken();

				$row = $this->user_manager->byEmail($guser["email"]);
				$id = $row["id"];

				if (!$row){
					$nick = urldecode( strtolower($guser["givenName"] . "-" . $guser["familyName"] . "-google-" . rand ( 1 , 999 )));
					$id = $this->user_manager->add(array(
							"email" => $guser["email"],
							"name" => $guser["givenName"],
							"surname" => $guser["familyName"],
							"gender" => $guser["gender"]=="male"?"muž":"žena",
							"nick" => $nick,
							"password" => password_hash($nick, PASSWORD_DEFAULT )
						));
				}

				$this->user->login($id);

				$this->user_manager->addLastLogin($this->user->id,"google");
				$this->flash_messages->addMessage("Úspešne si sa prihlásil", "success");
				$this->redirect("/dashboard");

			}
		}
	}

	public function beforerenderOut(){
		$google = new GoogleLogin();
		$google->logout();
		$this->user->logout();
		$this->flash_messages->addMessage("Bol si úspešne odhlásený", "success");
		$this->redirect();
	}
}