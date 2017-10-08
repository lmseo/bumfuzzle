<?php
class googleExtract
{
	function googleExtract()
	{
		
	}
	function gQuery ($referrerQuery=" ")
	{
		if (strpos($referrerQuery, "google.com"))
		{
			$longQuery = 0;
			$n = strpos($referrerQuery, "q=");
			if ($n)
			{
				for ($m=$n+3; $m < strlen($referrerQuery) ;$m++)
				{
					if ($referrerQuery[$m] == '&' || $referrerQuery[$m] == "\n")
					{
						break; 
					}  
					$q .= $referrerQuery[$m];
				} 
			}
			else
			{
				$q = 'No Query';
			}
			// --- Encontramos la variable q y su final delimitado por &
			/*for ($i=0; $i < strlen($referrerQuery); $i++)
			{
				//$TxtBody2 .= " " .$referrerQuery[$i] . " ";
				if ($referrerQuery[$i] == '&')
				{
					//$TxtBody2 .= "\n" ." &amp; inside " . "\n"; 
					for ($n=$i; $n < strlen($referrerQuery) ;$n++)
					{    
						if ($referrerQuery[$n] == 'q')
						{
					// Extraemos la subcadena a partir de las posiciones de (inicio)$i+2 [excluimos 'q='] y (fin)$n-2 [adelantamos 2 posiciones el final de la cadena resultante]	
							for ($m=$n+1; $m < strlen($referrerQuery) ;$m++)
							{
								if ($referrerQuery[$m] == '&')
								{
									break; 
								}  
								$q .= $referrerQuery[$m];
							} 
							break;
						}    
						$longQuery++; 
					}
					break;
				}
			}*/
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
		//$code_entities_replace = array('-','-','','','','','','','','','','','','','','','','','','','','','','','',''); 
		$anchor = str_replace($code_entities_match, " ", $anchor); 
		return $anchor; 
	} 
}
?>