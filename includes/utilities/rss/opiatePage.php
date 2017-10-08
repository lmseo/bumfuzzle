<?php
$include_root = $_SERVER['DOCUMENT_ROOT']."/";
require_once( $include_root . 'includes/global/htmlPage.php');
//require_once("htmlContent.php");
//require_once("htmlHeader.php");

class opiatePage extends htmlPage  {
	
	var $section; 
	var $dbhost;
	var $dbname;
	var $dbuser;
	var $dbpass;
	var $rightNavLinks;
	var $qryResults;

	function opiatePage($pageSection='opiates')
	{ 
		$this->dbhost = 'localhost';
		$this->dbname = 'testimonials';
		$this->dbuser = 'luis1420';
		$this->dbpass = '!masselin@1058#ave$';
		$this->section = $pageSection;
		$this->rightNavLinks = '';
	}
	function setDatabaseConnection()
	{
		$conn = mysql_connect('localhost','opiatePages','!masselin058#ave$');
		
		if (!$conn) die ("Could not connect MySQL");
			mysql_select_db($this->dbname,$conn) or die ("Could not open database");
	}
	function setSelect()
	{
		$pageURL = 'http://' .$_SERVER['HTTP_HOST']. $_SERVER['PHP_SELF'];
		$qryContact = "SELECT url, title  FROM " . $this->section . "  WHERE type='" . $this->pageType	;
		
		$this->qryResults = mysql_query($qryContact);
	}
	function setInsert()
	{
		$qryInsert = "INSERT INTO opiates ( title, content, type, drug, uri, description, keywords) VALUES ('" . $this->mainPageTitle."', " . ")";
		$this->qryResults = mysql_query($qryInsert);
	}
	function setAdditionalLinks()
	{
		if ( $this->section == 'opiates')
		{
			if (!$this->qryResults) 
			{
				$this->rightNavLinks .= '<ul> 
			<li class="current-page" ><strong>Actiq Detox</strong></li><li><a href="http://www.opiates.com/buprenorphine/buprenorphine-detox.html"><strong>Buprenorphine Detox</strong></a></li><li><a href="http://www.opiates.com/codeine/codeine-detox.html"><strong>Codeine Detox</strong></a></li><li><a href="http://www.opiates.com/darvocet/darvocet-detox.html"><strong>Darvocet Detox</strong></a></li><li><a href="http://www.opiates.com/demerol/demerol-detox.html"><strong>Demerol Detox</strong></a></li><li><a href="http://www.opiates.com/dilaudid/dilaudid-detox.html"><strong>Dilaudid Detox</strong></a></li><li><a href="http://www.opiates.com/duragesic/duragesic-detox.html"><strong>Duragesic Detox</strong></a></li><li><a href="http://www.opiates.com/fentanyl/fentanyl-detox.html"><strong>Fentanyl Detox</strong></a></li><li><a href="http://www.opiates.com/fentora/fentora-detox.html"><strong>Fentora Detox</strong></a></li><li><a href="http://www.opiates.com/heroin/heroin-detox.html"><strong>Heroin Detox</strong></a></li><li><a href="http://www.opiates.com/hydrocodone/hydrocodone-detox.html"><strong>Hydrocodone Detox</strong></a></li><li><a href="http://www.opiates.com/kadian/kadian-detox.html"><strong>Kadian Detox</strong></a></li><li><a href="http://www.opiates.com/laam/laam-detox.html"><strong>Laam Detox</strong></a></li><li><a href="http://www.opiates.com/lorcet/lorcet-detox.html"><strong>Lorcet Detox</strong></a></li><li><a href="http://www.opiates.com/lortab/lortab-detox.html"><strong>Lortab Detox</strong></a></li><li><a href="http://www.opiates.com/methadone/methadone-detox.html"><strong>Methadone Detox</strong></a></li><li><a href="http://www.opiates.com/morphine/morphine-detox.html"><strong>Morphine Detox</strong></a></li><li><a href="http://www.opiates.com/mscontin/ms-contin-detox.html"><strong>Ms-contin Detox</strong></a></li><li><a href="http://www.opiates.com/norco/norco-detox.html"><strong>Norco Detox</strong></a></li><li><a href="http://www.opiates.com/opana/opana-detox.html"><strong>Opana Detox</strong></a></li><li><a href="http://www.opiates.com/opiates/opiate-detox.html"><strong>Opiate Detox</strong></a></li><li><a href="http://www.opiates.com/oxycodone/oxycodone-detox.html"><strong>Oxycodone Detox</strong></a></li><li><a href="http://www.opiates.com/oxycontin/oxycontin-detox.html"><strong>Oxycontin Detox</strong></a></li><li><a href="http://www.opiates.com/oxymorphone/oxymorphone-detox.html"><strong>Oxymorphone Detox</strong></a></li><li><a href="http://www.opiates.com/percocet/percocet-detox.html"><strong>Percocet Detox</strong></a></li><li><a href="http://www.opiates.com/percodan/percodan-detox.html"><strong>Percodan Detox</strong></a></li><li><a href="http://www.opiates.com/stadol/stadol-detox.html"><strong>Stadol Detox</strong></a></li><li><a href="http://www.opiates.com/suboxone/suboxone-detox.html"><strong>Suboxone Detox</strong></a></li><li><a href="http://www.opiates.com/subutex/subutex-detox.html"><strong>Subutex Detox</strong></a></li><li><a href="http://www.opiates.com/tramadol/tramadol-detox.html"><strong>Tramadol Detox</strong></a></li><li><a href="http://www.opiates.com/tussionex/tussionex-detox.html"><strong>Tussionex Detox</strong></a></li><li><a href="http://www.opiates.com/ultram/ultram-detox.html"><strong>Ultram Detox</strong></a></li><li><a href="http://www.opiates.com/vicodin/vicodin-detox.html"><strong>Vicodin Detox</strong></a></li><li><a href="http://www.opiates.com/xodol/xodol-detox.html"><strong>Xodol Detox</strong></a></li><li><a href="http://www.opiates.com/zydone/zydone-detox.html"><strong>Zydone Detox</strong></a></li>	   </ul> ' ;
			}
			else
			{
				while ($row = mysql_fetch_assoc($this->qryResults)) 
				{
					if($row['url'] != NULL && $row['title'] !=  NULL)
					{
						$this->rightNavLinks .= '<ul>
			<li>
				<a href="' . $row['url'] . '">' . $row['title'] . '</a>
			</li>	   
		</ul> ';
					}
				}
			}
		}
	}
	function printAdditionalLinks()
	{
		echo $this->rightNavLinks;
	}
	function setHTMLContent()
	{
		$this->htmlContent->setAllContents();
		$this->setSelect();
		$this->setAdditionalLinks();
	}
}
?>

