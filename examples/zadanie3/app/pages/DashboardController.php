<?php

class Dashboard extends MainClass{

	public function __construct($container){
		parent::__construct($container);
	}

	public function startup(){
		parent::startup();
	}

	public function beforerenderDefault(){
		if (!$this->user->isLoggedIn()){
			$this->redirect("/sign/in");
		}
	}

	public function formatTimestamp($timestamp){
		/**
		 * $timeanddate 0-date, 1-time
		 * @var array
		 */
		$timeanddate = explode(" ", $timestamp);

		$date = explode("-", $timeanddate[0]);

		return $timeanddate[1] . " " . $date[2] . "." . $date[1] . "." . $date[0];

	}
}