<?php
class dateUtilities
{
	public function __construct()
	{
	}
	public function __destruct() 
	{
	}
	protected function formatDateTime($date)
	{
		try {
			$date = new DateTime($date);
		} catch (Exception $e) {
			exit(1);
		}
		return $date->format('m.d.Y');
	}
}
?>