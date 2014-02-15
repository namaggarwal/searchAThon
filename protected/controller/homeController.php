<?php

require_once("/protected/view/homeView.php");

//Controller class for the home page requests
class homeController {

	private $view;
	private $viewData;
	private $data;


	public function init($data){
		$this->data = $data;
		$this->view  = new homeView();

		$config = array(
		      'appId' => '225709324284498',
		      'secret' => 'c4e2f152db4d1e6ca5b752dd9203fede',
		      'fileUpload' => false, // optional
		      'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
		);

  		$facebook = new Facebook($config);
  		$user_id = $facebook->getUser();

  		if($user_id){
  			
  			 header('Location:'.config::BASE_URL."/play") ;

  		}else{

  			$this->viewData["LOGIN_URL"] = $facebook->getLoginUrl();
  		}
 


		$this->view->init($this->viewData);
	}
}