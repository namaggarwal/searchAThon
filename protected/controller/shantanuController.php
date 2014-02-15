<?php

require_once("/protected/view/shantanuView.php");
require_once("/protected/fbapi/facebook.php");

//Controller class for the page requests
class shantanuController extends BaseController{

	private $view;
	private $viewData;
	private $data;


	public function init($data){
		$this->data = $data;
		$this->view  = new shantanuView();
		$this->view->init($this->viewData);

		//Facebook Test

		$config = array(
		      'appId' => '225709324284498',
		      'secret' => 'c4e2f152db4d1e6ca5b752dd9203fede',
		      'fileUpload' => false, // optional
		      'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
		);

  		$facebook = new Facebook($config);
  		$user_id = $facebook->getUser();
  		if($user_id){
  			print $user_id;
  		}else{
  			print  "<a href=". $facebook->getLoginUrl().">Login</a>";	
  		}
  		
	}
}