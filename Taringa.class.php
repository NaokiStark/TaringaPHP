<?php

/**
* aaaaa
*/
require 'Requests.class.php';
class Taringa{
	
	public $isLogged=false;
	var $User;
	var $Pass;
	var $user_id;
	var $user_key;
	var $request;
	public function Taringa($user, $pass){
		$this->request= new Requests();
		$this->User=$user;
		$this->Pass=$pass;
		$this->request->cookies.=$user;
		if(!file_exists($this->request->cookies)){
			$this->login();	
		} 
		else{
			$this->getKeys();
			$this->isLogged=true;
		}
	}

	public function login(){
		$result=$this->request->postRequest('https://www.taringa.net/registro/login-submit.php',array('nick' => $this->User,'pass'=>$this->Pass,'redirect'=>'/','connect'=>''));
		$rParsed= json_decode($result,true);
		switch ($rParsed['status']) {
			case 0:
			//Datos incorrectos
				die('Datos incorrectos.');
				unlink($this->request->cookies);
				break;

			case 1:
			//Datos correctos, logueado
				$this->getKeys();
				$this->isLogged=true;
				break;

			case 2:
			//Ban hammer
				die('Cuenta suspendida.');
				unlink($this->request->cookies);
				break;
		}
	}
	function getKeys(){
		$result=$this->request->getRequest('http://www.taringa.net/mi');
		$uid = "/user:\\s*'(\\d+)'\\s*,/i"; 
		$ukey="/user_key:\\s*'(\\d*\\w*)'\\s*,/i"; 
		preg_match_all($uid, $result, $matches);
		$this->user_id=$matches[1][0];
		preg_match_all($ukey, $result, $matches);
		$this->user_key=$matches[1][0];
	}

	public function sendShout($body,$attach=0,$attach_url='',$privacy=1){
		$result=$this->request->postRequest('https://www.taringa.net/ajax/shout/add',array('key'=>$this->user_key,'body'=>$body,'privacy'=>$privacy,'attachment_type'=>$attach,'attachment'=>$attach_url));

		return (startsWith($result,'0:'))?false:$result;
	}
}
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}
?>
