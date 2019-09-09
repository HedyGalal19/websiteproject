<?php require 'connections.php'; ?>
<?php
//updates the appointment as being done
if (isset($_POST['id'])) {
 $appID = $_POST['id'];
 $stmt = $con->prepare("UPDATE Appointment SET appdone = ? WHERE appID=$appID");
 $stmt->bind_param("s", $change);
 $change = '1';

		$stmt->execute();
 $stmt->close();
	
//	 	//Prepare and bind
//	$stmt1 = $con->prepare( "SELECT * FROM Users WHERE userID = ?" );
//	$stmt1->bind_param( "s", $userID );
//	$userID = $_POST['userid'];
//	$stmt1->execute();
//	$result = $stmt1->get_result();
//	if ( $row = $result->fetch_assoc() ) {
//		$phone  = $row['phone'];
//		$rest = substr($phone, 1, 10);
//		
//		$fullphone = "44" . $rest; // now $b contains "Hello World!"
//			// Account details
//	$apiKey = urlencode('+OWlvQ0GRNM-AJB06GAWzhdYNZbV8v2LY4gvqPPJBJ');
//	
//	// Message details
//	$numbers = array($fullphone);
//	$sender = urlencode('Car Park Valeting');
//	$message = rawurlencode("Thank you for using Car Park Valeting. We would appreciate your feedback on the service provided. Please Click the below to provide your feedback. \n Kind Regards\n\n Car Park Valeting \n www.google.com");
// 
//	$numbers = implode(',', $numbers);
// 
//	// Prepare data for POST request
//	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
// 
//	// Send the POST request with cURL
//	$ch = curl_init('https://api.txtlocal.com/send/');
//	curl_setopt($ch, CURLOPT_POST, true);
//	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//	$response = curl_exec($ch);
//	curl_close($ch);
//
//	}
//	
//
//	$stmt1->close();
}
?>