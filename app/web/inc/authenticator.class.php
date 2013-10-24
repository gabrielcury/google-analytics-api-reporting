<?php

class Authenticator{
	public $configuration;

	function __construct($configuration){
		$this->configuration = $configuration;
	}

	public function verifyLoginCredentials($username, $password){
		if($this->verifyUsername($username) &&
			$this->verifyPassword($password)){
			return true;
		}else{
			return false;
			
		}
	}

	private function verifyUsername($username){
		if($username == $this->configuration['auth']['username']){
			return true;
		}else{
			return false;
		}
	}

	private function verifyPassword($password){
		if($password == $this->configuration['auth']['password']){
			return true;
		}else{
			return false;
		}
	}

}