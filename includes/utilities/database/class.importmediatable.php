<?php
require_once($_SERVER['DOCUMENT_ROOT']. "/includes/drug-master-04-10-10/class.databaseConnection.php");
class importTable
{
	public function __contruct()
	{
		
	}
	public function __destruct()
	{
	}
	public function _getTable($section='media')
	{
		 switch ($section) 
		{
			case 'opiates':
				$query = "SELECT * FROM opiates";
				break;
			case 'testimonials':
				$query = "SELECT * FROM Testimonials ";
				break;
			case 'media':
				$query = "SELECT * FROM media";
				break;
			case 'painkillers':
				$query = "SELECT * FROM painkillers";
				break;
		}
		$conn = databaseConnection::_getConnection();
		$localQryResults = mysql_query($query, $conn);
		if(! ($localQryResults && mysql_num_rows($localQryResults)))
		{
			//die("Failed getting address data for address $addressID");
			return false;
		}
		return $localQryResults;
	}
	public function _printTable($section='media')
	{
		
		
	}
	public function buildQuery($table)
	{
		$tableQryResults = $this->_getTable($table);
		$query = 'INSERT INTO' . $table . ' ('
		while($row = mysql_fetch_assoc($tableQryResults))
		{
			foreach($row as $value){ 
				echo key($row) . ' - ' . $row[key($row)]; 
				next($row); 
			} 
		//$query = 'INSERT INTO' . $table . ' (' . a,b,c) VALUES(1,2,3),(4,5,6),(7,8,9);
		}
	}	
}
$myImportTable = new importTable();
$myImportTable->buildQuery('media');
?>