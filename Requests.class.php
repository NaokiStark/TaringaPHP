<?php

class Requests{

	public $cookies;
	var $c;
	public function Requests(){
		$this->cookies=  getcwd() . '/cookie_';
		
	}

	public function postRequest($url,$params){
		$this->c = curl_init();
		$toSend='';
		foreach ($params as $key => $value) {
			$toSend.=$key.'='.$value.'&';
		}
		$toSend=rtrim($toSend);

		curl_setopt($this->c, CURLOPT_COOKIEJAR, $this->cookies);
		curl_setopt($this->c, CURLOPT_COOKIEFILE, $this->cookies);
		curl_setopt($this->c,CURLOPT_URL, $url);
		curl_setopt($this->c,CURLOPT_POST , 1);
		curl_setopt($this->c,CURLOPT_POSTFIELDS, $toSend);
		curl_setopt($this->c, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($this->c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->c, CURLOPT_USERAGENT, 'No soy un bot/1.1');
		curl_setopt($this->c, CURLOPT_SSL_VERIFYPEER , false);
		$result = curl_exec($this->c);

		
		if(!curl_exec($this->c))
			return curl_error($this->c);
		curl_close($this->c);
		return $result;
	}
	public function getRequest($url){
		$this->c = curl_init();
		curl_setopt($this->c, CURLOPT_COOKIEJAR, $this->cookies);
		curl_setopt($this->c, CURLOPT_COOKIEFILE, $this->cookies);
		curl_setopt($this->c, CURLOPT_URL, $url);
		curl_setopt($this->c, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($this->c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->c, CURLOPT_USERAGENT, 'No soy un bot/1.1');
		curl_setopt($this->c, CURLOPT_SSL_VERIFYPEER , false);
		$result = curl_exec($this->c);
		if(!curl_exec($this->c))
			return curl_error($this->c);
		curl_close($this->c);
		return $result;
	}
}

?>