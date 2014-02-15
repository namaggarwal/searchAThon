<?php

require_once("baseView.php");

class homeView extends baseView{

	private $html = "";
	private $data ;

	public function init($data){		
		$this->renderPage($data);
	}

	function getPageSpecificHead($params){

		$html  = "<title>Searchathon</title>";
		$html .= "<link type='text/css' rel='stylesheet' href='".config::BASE_URL."/public/css/home.css' />";
		$html .= "<link rel='stylesheet' href='".config::BASE_URL."/public/css/supersized.css'>";
        $html .= "<link rel='stylesheet' href='".config::BASE_URL."/public/css/style.css'>";


		return $html;
	}

	function getPageSpecificBody($params){

		$html ='';
		$html .= '<h2> Welcome To SearchAthon</h2>';
        $html .= '<div class="page-container">';
        $html .= '<h1>So What you are waiting for ???? Click to Proceed</h1>';       
        $html .= '<button><a class="loginButton" href="'.$params["LOGIN_URL"].'" type="submit">Login with my Facebook Account</a></button>';        
        $html .= '</div>';
        $html .= '<script src="'.config::BASE_URL.'/public/js/supersized.3.2.7.min.js"></script>';
        $html .= '<script src="'.config::BASE_URL.'/public/js/supersized-init.js"></script>';
        

		return $html;

	}
};