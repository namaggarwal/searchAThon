<?php

require_once("baseView.php");

class shantanuView extends baseView{

	private $html = "";

	public function init($data){

		$this->renderPage($data);
	}

	function getPageSpecificHead($params){

		$html = "<link type='text/css' rel='stylesheet' href='".config::BASE_URL."/public/css/home.css' />";

		return $html;
	}

	function getPageSpecificBody($params){

		$html  = "<div class='container'>";
		$html .= "<div class='page-header'>";
		$html .= "<div class='head-links'>";
		$html .= "<a href='".config::BASE_URL."/aboutus'>ABOUT</a>";
		$html .= "</div>";
		$html .= "</div>";
		$html .= "<div class='page-body'>";
		$html .= "<div class='head-text'>";
		$html .= "<h1>Shananu's page-body</h1>";
		$html .= "</div>";
		$html .= "</div>";
		$html .= "</div>";

		return $html;

	}
};