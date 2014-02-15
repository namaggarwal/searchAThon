<?php

require_once("/protected/view/shantanuView.php");

//Controller class for the home page requests
class shantanuController {

	private $view;
	private $viewData;
	private $data;


	public function init($data){
		$this->data = $data;
		$this->view  = new shantanuView();
		$this->view->init($this->viewData);
	}
}