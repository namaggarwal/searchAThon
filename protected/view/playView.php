<?php

require_once("baseView.php");

class playView extends baseView{

	private $html = "";
	private $data ;

	public function init($data){
		
		$this->renderPage($data);
	}

	function getPageSpecificHead($params){


		$html  = "<link type='text/css' rel='stylesheet' href='".config::BASE_URL."/public/css/home.css' />";
		$html .= '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAoneia3VEK0X3I8KJBZWbqzOn2DgF2WS0&sensor=true"></script>';
		
		
		return $html;
	}

	function getPageSpecificBody($params){		
		$base_url = config::BASE_URL;
		$html  = "<div class='container'>";
		$html .= "<div class='page-header'>";
		$html .= "<div class='head-links'>";
		$html .= "</div>";
		$html .= "</div>";
		$html .= "<div class='page-body'>";
		$html .= "<div class='head-text'>";
		$html .= "<div id='map-canvas' style='width:100%;height:600px'></div>";
		$html .= "<input type='hidden' id='base-url' value='".config::BASE_URL."' />";	
		$html .= "</div>";
		$html .= "</div>";
		$html .= "</div>";
		$html .= "<script type='text/javascript' src='".config::BASE_URL."/public/js/play.js'></script>";

		return $html;

	}

};