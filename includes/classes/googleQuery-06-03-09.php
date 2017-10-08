<?php
class googleExtract
{
	function googleExtract()
	{
		
	}
	function gQuery ($googleQuery)
	{
		if (strpos($googleQuery, "google"))
		{
			$longQuery = 0;
			// --- Encontramos la variable q y su final delimitado por &
			for ($i=0; $i < strlen($googleQuery); $i++)
			{
				//$TxtBody2 .= " " .$googleQuery[$i] . " ";
				if ($googleQuery[$i] == '&')
				{
					//$TxtBody2 .= "\n" ." &amp; inside " . "\n"; 
					for ($n=$i; $n < strlen($googleQuery) ;$n++)
					{    
						if ($googleQuery[$n] == 'q')
						{
					// Extraemos la subcadena a partir de las posiciones de (inicio)$i+2 [excluimos 'q='] y (fin)$n-2 [adelantamos 2 posiciones el final de la cadena resultante]	
							for ($m=$n+2; $m < strlen($googleQuery) ;$m++)
							{
								if ($googleQuery[$m] == '&')
								{
									break; 
								}  
								$q .= $googleQuery[$m];
							} 
							break;
						}    
						$longQuery++; 
					}
					break;
				}
			}
			$q = str_replace('+',' ',$q);
			return $q;
		}
		else
		{
			$q = 'No google Query';
			return $q;
		}
		
	}
	function clean_anchor($anchor) 
	{ 
		$anchor = strtolower($anchor); 
		$code_entities_match = array(' ', '-', '--','&quot;','%3a', '%2f', '!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','='); 
		//$code_entities_replace = array('-','-','','','','','','','','','','','','','','','','','','','','','','','',''); 
		$anchor = str_replace($code_entities_match, " ", $anchor); 
		return $anchor; 
	} 
}
?>