<?php

class Crypter{
	private $Key;
	private $Algo;

	public function __construct($Key, $Algo = MCRYPT_BLOWFISH){
		$this->Key = substr($Key, 0, mcrypt_get_key_size($Algo, MCRYPT_MODE_ECB));
		$this->Algo = $Algo;
	}

	public function Encrypt($data){
		if(!$data){
			return false;
		}
		
		//Optional Part, only necessary if you use other encryption mode than ECB
		$iv_size = mcrypt_get_iv_size($this->Algo, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		
		$crypt = mcrypt_encrypt($this->Algo, $this->Key, $data, MCRYPT_MODE_ECB, $iv);
		return trim(base64_encode($crypt));
	}
	
	public function Decrypt($data){
		if(!$data){
			return false;
		}
		
		$crypt = base64_decode($data);
		
		//Optional Part, only necessary if you use other encryption mode than ECB
		$iv_size = mcrypt_get_iv_size($this->Algo, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		
		$decrypt = mcrypt_decrypt($this->Algo, $this->Key, $crypt, MCRYPT_MODE_ECB, $iv);
		return trim($decrypt);
	
	}
}

?>