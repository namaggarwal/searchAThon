<?php
require_once("config.php");
require_once("router.php");
require_once("/protected/controller/baseController.php");
require_once("/protected/controller/homeController.php");
require_once("/protected/controller/shantanuController.php");
require_once("/protected/controller/playController.php");

class searchAThon extends baseController{

	private $req_method;
	private $req_url;
	private $cont;
	private $contData = array();



	private function setRequestParams(){


		$this->req_method = strtoupper($_SERVER["REQUEST_METHOD"]);
		$this->req_url = str_replace(config::BASE_URL,"",$_SERVER['REQUEST_URI']);			
		$payloadPos = strpos($this->req_url,"?");
		if($payloadPos){
			$this->req_data = substr($this->req_url,$payloadPos+1);
			$this->req_url = substr($this->req_url,0,$payloadPos);			
			$this->contData["REQUEST_DATA"] = $this->req_data;
			
		}
		$this->contData["REQUEST_METHOD"] = $this->req_method;
		$this->contData["REQUEST_URL"] = $this->req_url;

		
	

	}

	public function init(){

		$this->setRequestParams();
		
		$rout = new router($this->contData);
		$contName = $rout->getController();			
		$this->cont = new $contName();
		$this->cont->init($this->contData);
	
	}


}


$app = new searchAThon();

try{
	$app->init();
}catch(Exception $exp){	
	$exp_code = $exp->getCode();
	if($exp_code == 404){
		header("HTTP/1.0 404 Not Found");
	}
	print($exp->getMessage());
}
