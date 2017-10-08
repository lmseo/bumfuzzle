<?php
require_once($_SERVER['DOCUMENT_ROOT']. "/includes/drug-master-04-10-10/class.databaseConnection.php");
class medialogos 
{
	public function __construct()
	{ 
	}
	public function __destruct()
	{ 
		
	}
	public function compare()
	{
	}
	public function _getMedia()
	{
		$query = "SELECT id, published_0, published_1, published_2, published_3, published_4, published_5, published_6, published_7, published_8, published_9, published_10, published_11, published_12, published_13, published_14, published_15, published_16, published_17, published_18, published_19, published_20, published_21, published_22, published_23, published_24, published_25, published_26, published_27, published_28, published_29, published_30, published_31, uri   FROM media";
		$conn = databaseConnection::_getConnection();
		$localQryResults = mysql_query($query, $conn);
		if(! ($localQryResults && mysql_num_rows($localQryResults)))
		{
			//die("Failed getting address data for address $addressID");
			return false;
		}
		return $localQryResults;
	}
	public function _getPublished()
	{
		$query = "SELECT * FROM published";
		$conn = databaseConnection::_getConnection();
		$localQryResults = mysql_query($query, $conn);
		if(! ($localQryResults && mysql_num_rows($localQryResults)))
		{
			//die("Failed getting address data for address $addressID"); 
			return false;
		}
		return $localQryResults;
	}
}
$newmedialogos = new mediaLogos();
$mediaQryResults = $newmedialogos->_getMedia();
$publishedQryResults = $newmedialogos->_getPublished();
$insertMediaPublishedQry = 'INSERT INTO media_published (mediaID, publishedID) VALUES ';
$j = 0;
 while ($mediarow = mysql_fetch_assoc($mediaQryResults)) 
{
	while ($publishedrow = mysql_fetch_assoc($publishedQryResults)) 
	{
		$i=0;
		while($i<=30)
		{	
			if ($mediarow['published_'.$i] == $publishedrow['uri'])
			{
				if($j==0)
					$insertMediaPublishedQry .= '(' . $mediarow['id'] . ',' . $publishedrow['id'] . ')';
				else
					$insertMediaPublishedQry .= ',(' . $mediarow['id'] . ',' . $publishedrow['id'] . ')';
			}
			$i++;
		}
	}
	$j++;
	mysql_data_seek( $publishedQryResults,0 ); 
}
//echo $insertMediaPublishedQry;
$conn = databaseConnection::_getConnection();
$insertQryResults =  mysql_query($query, $conn);
if(!$insertQryResults)
{
	echo 'no insert';
	echo $insertMediaPublishedQry;
}
else
{
	echo $insertMediaPublishedQry;
	/*echo $mediarow['uri'] . '    -  <img src=http://www.opiatedetox.org/opiates-com/images/media/logos/' .$publishedrow['uri'] .  ' width='. $publishedrow['width']. ' height=' . $publishedrow['height'] . ' alt="' .ucwords($publishedrow['name']) . '" />   -  ' . $publishedrow['id'] .'    -     ' .$mediarow['id'] . '<br />';*/
//echo $mediarow['uri'] .'   -   '. $mediarow['published_0'].'<br />';
}
?>