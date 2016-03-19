<?php

class Homepage extends MainClass{

	public $list;
	public $person;
	public $person_places;
	public $persons;
	public $id;
	public $ohs;
	public $umiestnenie;

	public function __construct($container){
		parent::__construct($container);
	}

	public function startup(){
		parent::startup();
	}

	public function doDeletePerson($params){
		$this->database->query("DELETE FROM osoba WHERE id = ".$params["id"]);
		$this->redirect($this->container->basePath);
	}

	public function doDeleteUmiestnenie($params){
		$this->database->query("DELETE FROM umiestnenie WHERE id = ".$params["id"]);
		$this->redirect($this->container->basePath . "/homepage/view/" . $this->person["id"]);
	}

	public function beforerenderView($args){
		$query_person = "SELECT * FROM osoba WHERE id = ".$args[2];
		$this->person = $this->database->query($query_person)->fetch_assoc();

		$query_person_places = "SELECT discipline, type, year, city, country, place, u.id AS uid
								FROM umiestnenie AS u 
								LEFT JOIN oh ON oh.id = u.oh
								WHERE person = $args[2] 
								ORDER BY year DESC";
		$this->person_places = $this->database->query($query_person_places);

		$query_ohs = "SELECT * FROM oh ORDER BY year DESC";
		$this->ohs = $this->database->query($query_ohs);
	}

	public function beforerenderDefault(){
		$query_main = "SELECT osoba.id AS 'id', name, surname, year, city, country, type, discipline, u.id AS 'uid' FROM osoba LEFT JOIN umiestnenie as u ON u.person = osoba.id LEFT JOIN oh ON oh.id = u.oh WHERE u.place = 1";
		
		if (isset($_GET["order"]))
			$query_main .= " ORDER BY " . $_GET["order"] . " ASC";
		$this->list = $this->database->query($query_main);
	}

	public function beforerenderEditUmiestnenie($args){
		$this->id = $args[2];

		$query_ohs = "SELECT * FROM oh ORDER BY year DESC";
		$this->ohs = $this->database->query($query_ohs);

		$query_persons = "SELECT * FROM osoba ORDER BY id DESC";
		$this->persons = $this->database->query($query_persons);

		$query_umiestnenie = "SELECT * FROM umiestnenie WHERE id = ".$args[2];
		$this->umiestnenie = $this->database->query($query_umiestnenie)->fetch_assoc();
	}

	public function beforerenderEditPerson($args){
		$this->id = $args[2];

		$query_person = "SELECT * FROM osoba WHERE id = ".$args[2];
		$this->person = $this->database->query($query_person)->fetch_assoc();
	}

	public function addPersonFormSubmit($values){
		
		$insert_values = array();
		$insert_columns = array();
		foreach ($values as $key => $value) {
			array_push($insert_columns, $key);
			array_push($insert_values, "'" . $value . "'");
		}

		$insert_query = "INSERT INTO osoba (".implode(",", $insert_columns).") VALUES (".implode(",", $insert_values).")";
		$qwe = $this->database->query($insert_query);
		$this->redirect($this->container->basePath . "/homepage/view/" . $this->database->insert_id);
	}

	public function addUmiestnenieFormSubmit($values){
		$insert_values = array();
		$insert_columns = array();
		foreach ($values as $key => $value) {
			array_push($insert_columns, $key);
			array_push($insert_values, "'" . $value . "'");
		}

		array_push($insert_columns, "person");
		array_push($insert_values, $this->person["id"]);
		
		$insert_query = "INSERT INTO umiestnenie (".implode(",", $insert_columns).") VALUES (".implode(",", $insert_values).")";
		$qwe = $this->database->query($insert_query);

		$this->redirect($this->container->basePath . "/homepage/view/" . $this->person["id"]);
	}

	public function editUmiestnenieFormSubmit($values){
		$set = array();
		foreach ($values as $key => $value) {
			array_push($set, $key . "='" . $value . "'");
		}
		
		$update_query = "UPDATE umiestnenie SET " . implode(",", $set) . " WHERE id=".$this->id;
		$this->database->query($update_query);

		$this->redirect($this->container->basePath . "/homepage/view/" . $this->person["id"]);
	}

	public function editPersonFormSubmit($values){
		$set = array();
		foreach ($values as $key => $value) {
			array_push($set, $key . "='" . $value . "'");
		}
		
		$update_query = "UPDATE osoba SET " . implode(",", $set) . " WHERE id=".$this->id;
		$this->database->query($update_query);

		$this->redirect($this->container->basePath . "/homepage/view/" . $this->person["id"]);
	}
}