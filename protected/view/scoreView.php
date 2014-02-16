<?php

require_once("baseView.php");

class scoreView extends baseView{

	private $html = "";
	private $data ;

	public function init($data){		
		$this->renderPage($data);
	}

	function getPageSpecificHead($params){

		$html  = "<title>Searchathon</title>";
		$html .= "<link type='text/css' rel='stylesheet' href='".config::BASE_URL."/public/css/style_score.css' />";		

		return $html;
	}

	function getPageSpecificBody($params){

		$html  ='';
		$html .= '<a href="'.$params["LOGOUT_URL"].'">Logout</a>';
		$html .= '<p>Thanks for Playing!!!</p>';
		$html .= '<br/>';
		$html .= '<p>Your Score is '.$params["SCORE"].' at '.$params["PLACE"].'</p>';

                

		return $html;

	}
};