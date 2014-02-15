<?php

require_once("/protected/view/playView.php");
require_once("/protected/fbapi/facebook.php");

//Controller class for the page requests
class playController extends BaseController{

	private $view;
	private $viewData;
	private $data;


	public function init($data){
		$this->data = $data;
		$this->view  = new playView();

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
  			if(isset($this->data["REQUEST_DATA"])){
  				if(isset($_GET["info"])){
  					$info = $_GET["info"];  					
  				}else{
  					$info = "default";
  				}
				
				switch($info){

					case 'getLocation':
								//Get my current location here 
								$myData = $facebook->api('/me?fields=id,name,location,username','GET');
								$location = $facebook->api('/'.$myData["location"]["id"],'GET');
		
								//Get latitude and longitude
								//Extracting name and username from data
								$userlink = $myData["username"];
								$username = $myData["name"];
								
								$loc = array();
								$loc["LAT"] = $location["location"]["latitude"];
								$loc["LONG"] = $location["location"]["longitude"];
								$loc["CITY"] = $location["name"];							
								print json_encode($loc);
								break;
					case 'getFriendsLocation':
								$friends = array();

								$friends[0] = array();
								$friends[0]["KEY"] = 0;
								$friends[0]["NAME"] = "Naman";
								$friends[0]["LAT"] = "1.316100";
								$friends[0]["LONG"] = "103.847770";
								$friends[1] = array();
								$friends[1]["KEY"] = 1;
								$friends[1]["NAME"] = "Shantanu";
								$friends[1]["LAT"] = "1.317100";
								$friends[1]["LONG"] = "103.847770";
								$friends[2] = array();
								$friends[2]["KEY"] = 2;
								$friends[2]["NAME"] = "Ralston";
								$friends[2]["LAT"] = "1.318100";
								$friends[2]["LONG"] = "103.847770";
								$friends[3] = array();
								$friends[3]["KEY"] = 3;
								$friends[3]["NAME"] = "Anbarasan";
								$friends[3]["LAT"] = "1.317100";
								$friends[3]["LONG"] = "103.846770";
								print json_encode($friends);



								break;
					default:$this->view->init($this->viewData);
							break;
				}

  				
  			}else{
  				$this->view->init($this->viewData);
  			}
  		}else{
  			header("Location:".config::BASE_URL);
  		}

  		
  		
	}
}