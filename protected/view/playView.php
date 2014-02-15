<?php

require_once("baseView.php");

class playView extends baseView{

	private $html = "";
	private $data ;

	public function init($data){
		
		$this->renderPage($data);
	}

	function getPageSpecificHead($params){


		$html  = "<link type='text/css' rel='stylesheet' href='".config::BASE_URL."/public/css/play.css' />";
		$html .= '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAoneia3VEK0X3I8KJBZWbqzOn2DgF2WS0&libraries=places&sensor=true"></script>';		
		
		
		return $html;
	}

	function getPageSpecificBody($params){		
		$base_url = config::BASE_URL;
		$html  = "<div id='mask'>";
		$html .= "</div>";
		$html .= "<div id='messageBox'>";
		$html .= "<div id='message'>";
		$html .= "Select a place";
		$html .= "</div>";
		$html .= "<div id='init_loc'>";		
		$html .= "<input type='text' id='init_search' placeholder='Select a place to start'>";
		$html .= "</div>";
		$html .= "</div>";		
		$html .= "<div class='container'>";
		$html .= "<div class='page-head'>";
		$html .= "<div id='time-board'>";
		$html .= "<span id='min'></span>:<span id='sec'></span>";
		$html .= "</div>";
		$html .= "<div id='score-card'>";
		$html .= "0";
		$html .= "</div>";
		$html .= "</div>";
		$html .= "<div class='page-body'>";
		$html .= '<div id="left-panel">';
		$html .= "<input type='text' id='search_place' placeholder='Search a place' style='width:70%' />";
		$html .= "<div type='button' id='hint_button' title='Click here to see the markers for 2 seconds'>Hint</div>";
		$html .= "<div id='map-small' style='width:100%;height:300px'></div>";		
		$html .= '<br/>';
		$html .= "<div id='name-data'></div>";
		$html .= '</div>';
		$html .= '<div id="right-panel">';
		$html .= "<div id='map-canvas' style='width:100%;height:500px'></div>";
		$html .= '</div>';
		$html .= "<input type='hidden' id='base-url' value='".config::BASE_URL."' />";	
		
		$html .= "</div>";
		$html .= "</div>";
		$html .= "<form id='submitScore' method='POST' action='".config::BASE_URL."/score'>";
		$html .= "<input type='hidden' id='myPlace' name='myPlace' />";			
		$html .= "<input type='hidden' id='myScore' name='myScore' />";			
		$html .= "</form>";
		$html .= "<script type='text/javascript' src='".config::BASE_URL."/public/js/play.js'></script>";

		return $html;

	}

};