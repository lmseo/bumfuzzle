<?php
$include_root = $_SERVER['DOCUMENT_ROOT']."/";
include_once($include_root."includes/drug-master/links.php");
class AdditionalLinks extends links
{
	function printURL()
	{
		$host ='http://' . $_SERVER['HTTP_HOST'];
		$base = $host . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';
		$arr = array('abuse', 'addiction','detox', 'overdose', 'rehab', 'side-effects', 'treatment', 'withdrawals');
		if( $lPageType != "drug")
		{
			echo  '<li><a href="' . $base. '"><strong>' . $uDrugs .'</strong></a></li>';
		}
		else
		{
			echo  '<li style=" list-style-type: circle"><strong>' . $uDrugs . '</strong></li>';
		}
		foreach ($arr as $additionalValue) 
		{	
			$linkAddiction = $base . clean_url($lDrugs) . '-' . $additionalValue . '.html';
			if( $linkAddiction != $host . $_SERVER['PHP_SELF'])
			{
				$fp  =  is_valid_url($linkAddiction);
				if($fp != false){
						echo  '<li><a href="' . $linkAddiction . '"><strong>' . $uDrugs . ' ' . ucwords(clean_anchor($additionalValue)) . '</strong></a></li>';
				}
			}
			else
			{
				echo  '<li style=" list-style-type: circle"><strong>' . $uDrugs . ' ' . ucwords(clean_anchor($additionalValue)) . '</strong></li>';
			}
		}
	}
}
?>