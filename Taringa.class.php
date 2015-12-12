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
	//Added 12/12/15
	public function getComments($id){
		$result= $this->request->getRequest('https://api.taringa.net/shout/comment/view?object_id='.$id);
		return json_decode($result,true);
	}
	public function getShout($id){
		$result = $this->request->getRequest('https://api.taringa.net/shout/view/'.$id);
		return json_decode($result,true);
	}
	public function sendComment($sId,$body,$cId=null){

		$url= 'https://www.taringa.net/serv/comment/add/'.$sId;
		if($cId!==null){
			$url="https://www.taringa.net/serv/comment/addReply/".$sId.".".$cId;
		}

		$result = $this->request->postRequest($url,array(
			//'key'=>$this->user_key,
			'object_type'=>'shout',
			'body'=>$body
			));
		return $result;
	}
	public function sendShout($body,$attach=0,$attach_url='',$privacy=1){
		
		$result=$this->request->postRequest('https://www.taringa.net/ajax/shout/add',array('key'=>$this->user_key,'body'=>$body,'privacy'=>$privacy,'attachment_type'=>$attach,'attachment'=>$attach_url));

		return (startsWith($result,'0:'))?false:$result;
	}
		public function getNotify(){
		$res=$this->request->getRequest('https://www.taringa.net/clima'); //Hoy es un día gris
		preg_match_all("/new notifications\('[\w\d]+',\s*(.*?)\)/i", $res, $fndd);
		return json_decode($fndd[1][0],true);
	}
	public function getNewsFeed(){
		return $result=$this->request->postRequest('https://www.taringa.net/ajax/feed/fetch',array('key' => $this->user_key,'feedName'=>'newsfeed'));
	}
	public function voteShout($uid,$ownerid){
		return $this->request->postRequest('https://www.taringa.net/ajax/shout/vote',array('score'=>'1','key' => $this->user_key,'uuid'=>$uid,'owner'=>$ownerid));
	}
	public function getNotifications(){
		return json_decode($this->request->postRequest('https://www.taringa.net/notificaciones-ajax.php',array('key' => $this->user_key,'action'=>'last','template'=>'false','imageSize'=>'48')),true);
	}
}
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}
?>
