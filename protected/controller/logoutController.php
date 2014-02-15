<?php

//Controller class for the home page requests
class logoutController {

	private $view;
	private $viewData;
	private $data;


	public function init($data){
		$this->data = $data;
		
		$config = array(
		      'appId' => '225709324284498',
		      'secret' => 'c4e2f152db4d1e6ca5b752dd9203fede',
		      'fileUpload' => false, // optional
		      'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
		);

  		$facebook = new Facebook($config);  		
  		//$facebook->destroySession();
  		header("Location :".config::BASE_URL);
	}
}