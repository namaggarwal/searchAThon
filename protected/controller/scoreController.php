<?php

require_once("./protected/view/scoreView.php");
require_once("./protected/fbapi/facebook.php");

//Controller class for the page requests
class scoreController extends BaseController{

	private $view;
	private $viewData;
	private $data;


	public function init($data){
		$this->data = $data;
		$this->view  = new scoreView();
		//session_destroy();
		//Facebook Test

		$config = array(
		      'appId' => '225709324284498',
		      'secret' => 'c4e2f152db4d1e6ca5b752dd9203fede',
		      'fileUpload' => false, // optional
		      'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps,
		      'redirect_uri' => config::BASE_URL
		);

  		$facebook = new Facebook($config);
  		$user_id = $facebook->getUser();
  		if($user_id){
  			if(isset($_POST["myScore"])){
  				
  				$myScore = $_POST["myScore"];
  				$myPlace = $_POST["myPlace"];
  				$this->viewData["SCORE"] = $myScore;
  				$this->viewData["PLACE"] = $myPlace;
  				$this->viewData["LOGOUT_URL"] = config::BASE_URL."/logout";
				$this->view->init($this->viewData);
				$args = array(
  				  	'message'   => 'I just scored '.$myScore. ' on SearchAThon! at '.$myPlace,
    				'link'      => 'http://namanagg.kd.io/searchAthon',
    				'caption'   => 'Can you beat that score? Play hide and seek with your friends online!'
				);
  				$isPosted = $facebook->api('/'.$user_id.'/feed','POST',$args);
  			}else{
  				header("Location:".config::BASE_URL);	
  			}
  		}else{
  			header("Location:".config::BASE_URL);
  		}

  		
  		
	}
}