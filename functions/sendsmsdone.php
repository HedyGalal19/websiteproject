<?php require 'connections.php'; ?>
<?php

 if (isset($_POST['customerid'])) {
	 
	 
	 	//Prepare and bind
	$stmt = $con->prepare( "SELECT * FROM Users WHERE userID = ?" );
	$stmt->bind_param( "s", $userID );
	$userID = $_POST['customerid'];
	$stmt->execute();
	$result = $stmt->get_result();
	if ( $row = $result->fetch_assoc() ) {
		$phone  = $row['phone'];
		$rest = substr($phone, 1, 10);
		
		$fullphone = "44" . $rest; // now $b contains "Hello World!"
			// Account details
	$apiKey = urlencode('+OWlvQ0GRNM-AJB06GAWzhdYNZbV8v2LY4gvqPPJBJ');
	
	// Message details
	$numbers = array($fullphone);
	$sender = urlencode('Car Park Valeting');
	$message = rawurlencode("Hi Your car is ready to collect. Please come to reception to collect your keys \n\n Car Park Valeting \n www.eastbournecw.xyz");
 
	$numbers = implode(',', $numbers);
 
	// Prepare data for POST request
	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
	// Send the POST request with cURL
	$ch = curl_init('https://api.txtlocal.com/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);

	}
	 

//	
//	// Process your response here
	echo $response;
 }
?>