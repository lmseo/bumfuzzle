<?php
class googleExtract
{
	var $engine;
	var $referrer;
	function googleExtract()
	{
		$this->$engine = "Not Known";
		$this->$referrer = array('google.com'=>"q=",'google.co'=>"q=", 'google.ca'=>"q=", 'yahoo.com'=>"q=",'bing.com'=>"q=", 'ask.com'=>"q=", 'doubleclick.net'=>"q=", 'drugs.com'=>"q=", 'aol.com'=>"q=", 'mywebsearch.com'=>"q=", 'peoplepc.com'=>"q=", 'dotellall.com'=>"q=", 'comcast.net'=>"q=", 'conduit.com'=>"q=", 'earthlink.net'=>"q=");
	}
	function identifyReferrer($path)
	{
		foreach($referrer as $value)
		{
			if (strpos($path, $value))
			{
				$this->$engine = $value;
				return $this->$engine;
			}
		}
		return $this->$engine;
	}
	function gQuery ($referrerQuery)
	{
		if($this->$engine!="Not Known")
		{
			$longQuery = 0;
			$n = strpos($referrerQuery, "google.com");
			for ($m=$n + strlen("google.com"); $m < strlen($referrerQuery) ;$m++)
			{
				if ($referrerQuery[$m] == '&' || $referrerQuery[$m] == "\n")
				if ($n)
				{
					$aUrl = explode("&", $referrerQuery);
					foreach($aUrl  as $value)
					{
						if($value = str_replace("=q","", $value))
						{
							return $value;
						}
					}
					/*for ($m=$n+3; $m < strlen($referrerQuery) ;$m++)
					{
						if ($referrerQuery[$m] == '&' || $referrerQuery[$m] == "\n")
						{
							break; 
						}  
						$q .= $referrerQuery[$m];
					} */
				}
				else
				{
					$q = 'No Query';
				}
				return $q;
			
		}
		else
		{
			$q = 'No Query';
			return $q;
		}
	}

	function clean_anchor($anchor) 
	{ 
		$anchor = strtolower($anchor); 
		$code_entities_match = array(' ', '-', '--','&quot;','%3a', '%2f', '%3d', '%2b', '%26', '!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','='); 
		$anchor = str_replace($code_entities_match, " ", $anchor); 
		return $anchor; 
	} 
}
?>