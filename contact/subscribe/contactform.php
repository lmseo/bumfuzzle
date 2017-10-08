<?php
session_start();	
function get_request_headers(&$text) 
{
    foreach($_SERVER as $key => $value) 
	{
	  //$headers[str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
	  if($key != 'REQUEST_TIME')
	  {
		  $text .= str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower($key)))) . ' - ' . $value . "\n";
	  }
	  else
	  {
	  	$text .= str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower($key)))) . ' - ' . date(DATE_RFC822, $value) . "\n";
	  }      
    }
}
	$formSubject = $formSitename = $formName1 = $formPhone = $formBesttime = $formLeaveMessage = $formHeardAbout = $formHeardFrom = $formEmail = $formWho = $formAgeWho = $formCountry = $formDrugs = $formsMessage = $webPageReferer = $thisPageReferer = $formLast = " ";
	$dbhost = "localhost";
	$dbname = "eopiatesContactDB";
	$dbuser = "eoctdb";
	$dbpass = "@@Masselin104!@#";
	
	$remoteIP = $_SERVER['REMOTE_ADDR'];
	$formEmail = $_POST['email'];
	$webPageReferer = $_SESSION['pageReferer'];
	$thisPageReferer = $_SERVER['HTTP_REFERER'];
	
	$today = date("m-d-Y");
	$dateAdd = date("Y-m-d h:m:s");
	$CustEmail = "luis@lmseo.com";
	//echo "Ok before Sending";
	$TxtBody = "IP: {$remoteIP} - for fighting spam \n";
	$TxtBody .= "Name: " . $_POST['email'] ." " . $formLast . "\n";
	/* if($_POST['contactmethod2'] == "3"){
	$TxtBody .= "Address: " . $_POST['address'] . "\n";
	$TxtBody .= "City: " . $_POST['city'] . "\n";
	$TxtBody .= "State: " . $_POST['state'] . "\n";
	$TxtBody .= "Zip: " . $_POST['zip'] . "\n";
	$TxtBody .= "Contact Method: " . $_POST['contactmethod'] . "\n";
	}elseif($_POST['contactmethod2'] == "2"){*/
	$From = "From: \"" . ucwords($_POST['email']) .' ' . ucwords($formLast) . "\" <" . $_POST['email'] . ">";
	$Email = $CustEmail;
	
	$Email2 = "luis@lmseo.com";
	$Subject2 = 'Patient Subscription to lmseo.com';
	$TxtBody2 = $TxtBody;
	$TxtBody2 .= "-------------------------------------------"."\n\n";
	$TxtBody2 .= get_request_headers($TxtBody2);
	$TxtBody2 .= "Referer: " . "\n" . $webPageReferer . "\n" . $thisPageReferer;
	  
	if ($_POST['redirect'] == "sending.php" && empty($_POST['name']) )
	{
		$mssg = '';
		if (strstr($remoteIP, ', ')) 
		{
		   $ips = explode(', ', $remoteIP);
		   $remoteIP = $ips[0];
		}
		$fullhost = gethostbyaddr($remoteIP);
		$iparray = array();
		// my ip 71.140.97.101
		if (in_array($remoteIP, $iparray)) 
		{
			$stopspam = "Error 10";
			$i = 1;
			while ($i <= 99) 
			{
			   echo $stopspam;
			   $i++;
			}
		}
		else
		{				
			$myRegExp = '/\<url\>|\<URL\>/';
			$urlHtml = '/[\[<]\/?\w+\s*\w*[^>\]]*[\]>]/';	
			$httpLink = '/(http|https):\/\//';
			if(preg_match($urlHtml, $drugsField, $drugsFieldMatch) || preg_match($urlHtml, $messageField, $messageFieldMatch ))
			{
				mail($Email2, "This email includes a link", $TxtBody2, $From);
				echo "\n\n\n<br /><br /><center><font color=#C40000><b>No HTML code or Links allowed !!!!<br />Please go back ";

				if(isset($drugsFieldMatch) || isset($messageFieldMatch))
				{
					echo ' and remove: ' . '<br />';
					foreach($drugsFieldMatch as $value)
					{
						echo  '<code>' .htmlspecialchars($value) . '</code>' . '<br />';
					}
					foreach($messageFieldMatch as $value)
					{
						echo  '<code>' .htmlspecialchars($value) . '</code>' . '<br />';
					}
				}
				else
				{	
					echo' and try again.</b></font></center><br /><br /><br /><br />';
				}
				die();
			}
			
			mail($Email, 'Patient Subscription to Opiates.com', $TxtBody, $From);
			

				//echo "\n\n\n<br /><br /><center><font color=#C40000><b>Stop you idiot!!!!<br /></b></font></center><br /><br /><br /><br />";
				//die();
			
			/*require_once('recaptchalib.php');
			$privatekey = "6LcYDQYAAAAAAFIiPVshwh72iFNmoYgMvy2ervO1";
			$resp = recaptcha_check_answer ($privatekey,
											$_SERVER["REMOTE_ADDR"],
											$_POST["recaptcha_challenge_field"],
											$_POST["recaptcha_response_field"]);
			
			if (!$resp->is_valid) {
			  echo "\n\n\n<center><font color=#C40000><b>Sorry the verification code does not match the one entered by you!<BR>Please go back and try again.</b></font></center><br><br><br><br>";
				die();
			}*/
			/*require_once("../captcha/class.verificator.php");
			$veri = new VeriFicator($_POST['veriword']);
			$verified = $veri->verified();
			
			if(!$verified){
				echo "\n<center><font color=#C40000><b>Sorry the verification code does not match the one entered by you!<BR>Please go back and try again.</b></font></center><br><br><br><br>";
				die();
			}*/
			$conn = mysql_connect($dbhost,$dbuser,$dbpass);
			if (!$conn) die ("Could not connect MySQL");
			mysql_select_db($dbname,$conn) or die ("Could not open database");		
			
				$qryContact = "INSERT INTO subscribe ( email, sitename, date_added, IP) VALUES ('" . mysql_real_escape_string($formEmail) . " " . "', '" . mysql_real_escape_string($formSitename) . " " . "', '" . mysql_real_escape_string($dateAdd) . " " . "', '" . mysql_real_escape_string($remoteIP) ."')";
			if(mysql_query($qryContact))
			{
				include ($_SERVER['DOCUMENT_ROOT']. "/" . "includes/classes/googleQuery2.php");
			
				$qG = new googleExtract;
				$TxtBody2 .= "\n" . "Google Query: " . $qG->clean_anchor($qG->gQuery($webPageReferer)) . "\n";
				mail($Email2, $Subject2, $TxtBody2, $From);
				$id = mysql_insert_id();
				$qStr_var = "?OID=" . $id;
			  	header('Location: ' . $_POST['redirect'] . $qStr_var);
			}	
			else
			{	
				include ($_SERVER['DOCUMENT_ROOT']. "/" . "includes/classes/googleQuery2.php");

				$qG = new googleExtract;
				$TxtBody2 .= "\n" . "Google Query: " . $qG->clean_anchor($qG->gQuery($webPageReferer)) . "\n";
				mail($Email2, $Subject2 . "----". "The email wasn't saved on the database", $TxtBody2, $From);
				/*echo "\n<center><font color=#C40000><b>Not sent, Contact us at info@opiates.com or the System Administrator at admin@opiates.com!</b></font></center><br><br><br><br>";				*/
				header('Location: ' . $_POST['redirect']);
			}
		}
	}
	else
	{
		include ($_SERVER['DOCUMENT_ROOT']. "/" . "includes/classes/googleQuery2.php");

		$qG = new googleExtract;
		$TxtBody2 .= $_POST['name'];
		$TxtBody2 .= "\n" . "Google Query: " . $qG->clean_anchor($qG->gQuery($webPageReferer)) . "\n";
		mail($Email2, "This email is not from the contact page", $TxtBody2, $From);
				$id = mt_rand();
				$qStr_var = "?OID=" . $id;
			  	header('Location: ' . 'sending.php' . $qStr_var);
		die();
	}
?>