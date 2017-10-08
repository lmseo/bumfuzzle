<?php
class emailFailOver{
	private $conn;
	function __construct(){
		$this->conn = databaseConnection::_getConnectionToContact();
	}
	public function insertVisitInfo(){
		$qryContact =sprintf("INSERT INTO contact (name, email, phone, address, city, state, message, country, voicemail, drugs, person, sitename, date_added, recEmails) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s');",
			mysql_real_escape_string( visitCount ),
			mysql_real_escape_string( pageCountAcrossAllVisits ),
			mysql_real_escape_string( pageCountForThisVisit ),
			mysql_real_escape_string( searchTextForPreviousVisits ),
			mysql_real_escape_string( searchTextForThisVisit ),
			mysql_real_escape_string( referredByCampaignThisVisit ) ,
			mysql_real_escape_string( referredByCampaignEver ),
			mysql_real_escape_string( referredByPaidAdvertisingThisVisit ),
			mysql_real_escape_string( referredByPaidAdvertisingEver ),
			mysql_real_escape_string( recentPageHistory ));
		if(mysql_query($qryContact,$this->conn)){
			$id = mysql_insert_id();
			$qStr_var = "?OID=" . $id;
			header('Location: ' . $_POST['redirect'] . $qStr_var);
		}else{	
			$qG = new googleExtract;
			header('Location: ' . $_POST['redirect']);
		}
	}
	public function insertConversationInfo(){
		$qryContact =sprintf("INSERT INTO contact (name, email, phone, address, city, state, message, country, voicemail, drugs, person, sitename, date_added, recEmails) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s');",
			mysql_real_escape_string( secondsSinceLastNotificationToOperator ),
			mysql_real_escape_string( secondsSinceLastMessage ),
			mysql_real_escape_string( isConversing ),
			mysql_real_escape_string( conversationCount ));
		if(mysql_query($qryContact,$this->conn)){
			$id = mysql_insert_id();
			$qStr_var = "?OID=" . $id;
			header('Location: ' . $_POST['redirect'] . $qStr_var);
		}else{	
			$qG = new googleExtract;
			header('Location: ' . $_POST['redirect']);
		}
	}
	public function insertEmailInfo(){
		$qryContact =sprintf("INSERT INTO contact (name, email, phone, address, city, state, message, country, voicemail, drugs, person, sitename, date_added, recEmails) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s');",
			mysql_real_escape_string( email ),
			mysql_real_escape_string( message ),
			mysql_real_escape_string( dateAdd ),
			mysql_real_escape_string( emailupdates ));
		if(mysql_query($qryContact,$this->conn)){
			$id = mysql_insert_id();
			$qStr_var = "?OID=" . $id;
			header('Location: ' . $_POST['redirect'] . $qStr_var);
		}else{	
			$qG = new googleExtract;
			header('Location: ' . $_POST['redirect']);
		}
	}
	public function insertPatientInfo(){
		$qryContact =sprintf("INSERT INTO contact (name, email, phone, address, city, state, message, country, voicemail, drugs, person, sitename, date_added, recEmails) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s');",
			mysql_real_escape_string( name ),
			mysql_real_escape_string( lastName ),
			mysql_real_escape_string( email ),
			mysql_real_escape_string( phone1.phone2.phone3 ),
			mysql_real_escape_string( address ),
			mysql_real_escape_string( city ),
			mysql_real_escape_string( region ),
			mysql_real_escape_string( message ),
			mysql_real_escape_string( country ),
			mysql_real_escape_string( leavemessage ) ,
			mysql_real_escape_string( drugs ),
			mysql_real_escape_string( who ),
			mysql_real_escape_string( sitename ),
			mysql_real_escape_string( dateAdd ),
			mysql_real_escape_string( emailupdates ));
		if(mysql_query($qryContact,$this->conn)){
			$id = mysql_insert_id();
			$qStr_var = "?OID=" . $id;
			header('Location: ' . $_POST['redirect'] . $qStr_var);
		}else{	
			$qG = new googleExtract;
			header('Location: ' . $_POST['redirect']);
		}
	}
}
?>