<?php

$include_root = $_SERVER['DOCUMENT_ROOT']."/";
include_once($include_root."includes/drug-master/links.php");

class rightNavLinks extends links
{

	function printURL()
	{
		//$host ='http://' . $_SERVER['HTTP_HOST'];
		//$base = $host . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
		$opiates = array('Actiq' , 'Buprenorphine' , 'Codeine' , 'Darvocet' , 'Demerol' , 'Dilaudid' , 'Duragesic' , 'Fentanyl' , 'Fentora', 'Heroin' , 'Hydrocodone' , 'LAAM' , 'Lorcet' , 'Lortab' , 'Methadone' , 'Morphine' , 'ms-contin' , 'Norco' , 'Opiates', 'Oxycodone' , 'OxyContin' , 'Percocet' , 'Percodan' , 'Stadol' , 'Suboxone' , 'Subutex' , 'Tramadol' , 'Tussionex' , 'Ultram' , 'Vicodin' , 'Vicoprofen' , 'Xodol' , 'Zydone');
		//$opiates = array('abuse', 'addiction','detox', 'overdose', 'side-effects', 'treatment', 'withdrawals');
		  
		foreach ($opiates as $value) 
		{
			$value = strtolower($value);
			if($lPageType != "drug")
			{
				$linksRightNav = $host .  '/' .  clean_dir($value) . '/' . $value . '-' . $lPageType . '.html';
				//echo  '<li><a href="' . $linksRightNav . '"><strong>' . $value . ' ' . $lPageType . '</strong></a></li>';
				
				if( $linksRightNav != $host . $_SERVER['PHP_SELF'])
				{
					//echo $host . $_SERVER['PHP_SELF']. "\n";
					//echo $linksRightNav. "\n";
					//echo $host . $_SERVER['PHP_SELF']. "\n";
					$fp  =  is_valid_url($linksRightNav);
					if($fp != false){
							echo  '<li><a href="' . $linksRightNav . '"><strong>' . ucwords($value) . ' ' . $uPageType . '</strong></a></li>';
					}
					elseif($value == "opiates")
					{
						if ($lPageType == "addiction"  )
						{
							
							$linksRightNav = $host .  '/opiate-' . $lPageType . '.html';
						}
						elseif($lPageType == "withdrawals")
						{
							$linksRightNav = $host .  '/opiate-withdrawal.html';
						}
						else
						{
							$linksRightNav = $host .  '/opiates/opiate-' . clean_url($lPageType) . '.html';
						}
						$fp  =  is_valid_url($linksRightNav);
						if($fp != false)
						{
								echo  '<li><a href="' . $linksRightNav . '"><strong>Opiate ' . $uPageType . '</strong></a></li>';
						}
					}
					else
					{
						$valueClean = clean_url($lPageType);
						$linksRightNav = $host .  '/' .  $value  . '/' . $value . '-' . $valueClean . '.html';
						//echo  '<li>' . $linksRightNav .'</li>';
						$fp  =  is_valid_url($linksRightNav);
						if($fp != false)
						{
								echo  '<li><a href="' . $linksRightNav . '"><strong>' . ucwords(clean_anchor($value)) . ' ' . $uPageType . '</strong></a></li>';
						}
					}
				}
				else
				{
					echo  '<li class="current-page" ><strong>' . ucwords($value) . ' ' . $uPageType . '</strong></li>';
				}
			}
			else
			{
				$linksRightNav = $host .  '/' .  clean_dir($value) . '/';
				//echo  '<li><a href="' . $linksRightNav . '"><strong>' . $value . ' ' . $lPageType . '</strong></a></li>';
				
				if( $linksRightNav != $host . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/')
				{
					//echo $host . $_SERVER['PHP_SELF']. "\n";
					//echo $linksRightNav. "\n";
					//echo $host . $_SERVER['PHP_SELF']. "\n";
					$fp  =  is_valid_url($linksRightNav);
					if($fp != false)
					{
							echo  '<li><a href="' . $linksRightNav . '"><strong>' . ucwords($value) . '</strong></a></li>';
					}
				}
				else
				{
					echo  '<li class="current-page"><strong>' . ucwords($value) . '</strong></li>';
				}
			}
		}
	}
}
?>