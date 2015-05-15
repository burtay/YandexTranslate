<?php


class curl
{

public $cookie_file	=	'';
	
	public function get($site)
	{
		$curl		=	curl_init();							
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);				
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);				
		curl_setopt($curl,CURLOPT_URL,$site);						
		curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');	
		curl_setopt($curl,CURLOPT_COOKIEFILE,$this->cookie_file);	
		curl_setopt($curl,CURLOPT_COOKIEJAR,$this->cookie_file);	
		curl_setopt($curl,CURLOPT_FOLLOWLOCATION,1);			
		$calis		=	curl_exec($curl);
		return $calis;	
	}

}
?>
