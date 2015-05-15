<?php

/*
*	Yandex Translate API Class
*	@author Burtay
*	Website : http://www.burtay.org
*	Mail : admin{at}burtay.org 
*	Twitter : @HaciBurtay
*	Github : @Burtay
*/

class YandexTranslate
{
	/* Your API Key taken from Yandex*/
	private $key;
	/* Source and Target Language (ru-en) */
	private $translateLangs ;
	private $autoDedect 	=	1;
	private $errors			=	array(
										401=>'Invalid API key.',
										402=>'This API key has been blocked.',
										403=>'You have reached the daily limit for requests (including calls of the detect method).',
										404=>'You have reached the daily limit for the volume of translated text (including calls of the detect method).',
										413=>'The text size exceeds the maximum.',
										422=>'The text could not be translated. ',
										501=>'The specified translation direction is not supported.'
										);
	private $socket;
	
	public $all_langs		=	array("ar","az","be","bg","bs","ca","cs","da","de","el","en","es","et","fi","fr","he","hr","hu","hy","id","is","it","ja","ka","ko","lt","lv","mk","ms","mt","nl","no","pl","pt","ro","ru","sk","sl","sq","sr","sv","th","tr","uk","vi","zh");
	
	public $all_langs_details	= array('ar'=>'Arabic','az'=>'Azerbaijani','be'=>'Belarusian','bg'=>'Bulgarian','bs'=>'Bosnian','ca'=>'Catalan','cs'=>'Czech','da'=>'Danish','de'=>'German','el'=>'Greek','en'=>'English','es'=>'Spanish','et'=>'Estonian','fi'=>'Finnish','fr'=>'French','he'=>'Hebrew','hr'=>'Croatian','hu'=>'Hungarian','hy'=>'Armenian','id'=>'Indonesian','is'=>'Icelandic','it'=>'Italian','ja'=>'Japanese','ka'=>'Georgian','ko'=>'Korean','lt'=>'Lithuanian','lv'=>'Latvian','mk'=>'Macedonian','ms'=>'Malay','mt'=>'Maltese','nl'=>'Dutch','no'=>'Norwegian','pl'=>'Polish','pt'=>'Portuguese','ro'=>'Romanian','ru'=>'Russian','sk'=>'Slovak','sl'=>'Slovenian','sq'=>'Albanian','sr'=>'Serbian','sv'=>'Swedish','th'=>'Thai','tr'=>'Turkish','uk'=>'Ukrainian','vi'=>'Vietnamese','zh'=>'Chinese');
	
	/* For Turkish Developer */
	public $all_langs_details_tr = array('ar'=>'Arapça','az'=>'Azerice','be'=>'Belarusça','bg'=>'Bulgarca','bs'=>'Boşnakça','ca'=>'Katalanca','cs'=>'Çekçe','da'=>'Danca','de'=>'Almanca','el'=>'Yunanca','en'=>'İngilizce','es'=>'İspanyolca','et'=>'Estonca','fi'=>'Fince','fr'=>'Fransızca','he'=>'İbranice','hr'=>'Hırvatça','hu'=>'Macarca','hy'=>'Ermenice','id'=>'Endonezce','is'=>'İzlandaca','it'=>'İtalyanca','ja'=>'Japonca','ka'=>'Gürcüce','ko'=>'Korece','lt'=>'Litvanca','lv'=>'Letonca','mk'=>'Makedonca','ms'=>'Malayca','mt'=>'Maltaca','nl'=>'Felemenkçe','no'=>'Norveççe','pl'=>'Lehçe','pt'=>'Portekizce','ro'=>'Romence','ru'=>'Rusça','sk'=>'Slovakça','sl'=>'Slovence','sq'=>'Arnavutça','sr'=>'Sırpça','sv'=>'İsveçce','th'=>'Taylandça','tr'=>'Türkçe','uk'=>'Ukraynaca','vi'=>'Vietnamca','zh'=>'Çince',);
	
	public $is_error		= false;
	
	public function __construct()
	{
		require_once('class.Curl.php');
		$this->socket = new curl();		
	}
	

	public function setApiKey($ApiKey)
	{
		$this->key = $ApiKey;
	}

		
	public function setTranslateLangs($langs)
	{
		$this->translateLangs = $langs;
	}

	public function dedectSource($text)
	{
		$kaynak	=	$this->socket->get("https://translate.yandex.net/api/v1.5/tr.json/detect?key=".$this->key."&text=".urlencode($text));
		$kaynak	=	json_decode($kaynak);
		return $kaynak->lang;
	}
	
	public function translate($texts = array())
	{
		foreach($texts as $t)
		{
			$text .= "&text=".urlencode($t);
		}

		$result = 	$this->socket->get("https://translate.yandex.net/api/v1.5/tr.json/translate?key=".$this->key."&lang=".$this->translateLangs.$text."&options=".$this->autoDedect);
		$result =	json_decode($result);
		// print_r($result);die();
		if($result->code == 200)
		{
			$sonuc = array();
			foreach($result->text as $translatedText)
			{
				array_push($sonuc,$translatedText);
			}			
			return $sonuc;
		}
		else
		{
			$this->is_error = true;
			return $this->errorHandling($result->code);
		}
		
	}

	private function errorHandling($error)
	{
		switch($error)
		{
			case 401:
			return $this->errors[401];
			break;
			case 402:
			return $this->errors[402];
			break;
			case 403:
			return $this->errors[403];
			break;
			case 404:
			return $this->errors[404];
			break;
			case 413:
			return $this->errors[413];
			break;
			case 422:
			return $this->errors[422];
			break;
			case 501:
			return $this->errors[501];
			break;
		}
	}
}
?>
