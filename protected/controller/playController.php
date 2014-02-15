<?php

require_once("./protected/view/playView.php");
require_once("./protected/fbapi/facebook.php");

//Controller class for the page requests
class playController extends BaseController{

	private $view;
	private $viewData;
	private $data;


	public function init($data){

		$this->data = $data;
		$this->view  = new playView();
		//session_destroy();
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
								$myData = $facebook->api('/me?fields=id,name,location','GET');								
								$location = $facebook->api('/'.$myData["location"]["id"],'GET');
		
								//Get latitude and longitude
								//Extracting name and username from data
								
								$username = $myData["name"];
								
								$loc = array();
								$loc["LAT"] = $location["location"]["latitude"];
								$loc["LONG"] = $location["location"]["longitude"];
								$loc["CITY"] = $location["name"];							
								print json_encode($loc);
								break;
					case 'getFriendsLocation':

								//Get my current location here 								
								$mylat = $_GET["lat"];
								$mylong = $_GET["lng"];
								$friends = array();
								$myfriends = $facebook->api('/me/friends?fields=id,first_name,username,picture.width(200).height(200)&limit=100');								
								$myFriendsArr = $myfriends["data"];
								shuffle($myFriendsArr);
								//$this->prettyPrint($myFriendsArr);
								$mykey = 0;
								foreach ($myFriendsArr as $key => $value) {
									$friends[$mykey] = array();
									$randseed1 = rand(3000,10000);
									$randseed2 = rand($randseed1,$randseed1+3000);
									$rand1 = rand($randseed1,$randseed2);
									$rand2 = rand(1,10);
									if($rand2 >= 5){
										$friends[$mykey]["LAT"] = $mylat+$rand1/1000000;
									}else{
										$friends[$mykey]["LAT"] = $mylat-$rand1/1000000;
									}
									$randseed1 = rand(3000,10000);
									$randseed2 = rand($randseed1,$randseed1+3000);
									$rand1 = rand($randseed1,$randseed2);
									$rand2 = rand(1,10);
									if($rand2 >= 5){
										$friends[$mykey]["LONG"] = $mylong+$rand1/1000000;
									}else{
										$friends[$mykey]["LONG"] = $mylong-$rand1/1000000;
									}
									
									$friends[$mykey]["KEY"] = $mykey;
									$friends[$mykey]["NAME"] = $value["first_name"];
									$friends[$mykey]["URL"] = $value["picture"]["data"]["url"];								
									$mykey++;
								}
								//$this->prettyPrint($friends);
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