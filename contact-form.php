<?php

/*
* Submit contact form info
*/

if ( isset( $_POST['action'] ) ) {	

	extract($_POST);	

	$secretkey = '6LfcCr0eAAAAALS38cWEKOVfiz55nPW0EoZabVAC';

	$responsekey = $_POST['g-recaptcha-response'];

	$userip = $_SESSION['REMOTE_ADDR'];	

	$url = 'https://www.google.com/recaptcha/api/siteverify?secret='.$secretkey.'&response='.$responsekey.'&remoteip='.$userip;

	$response = file_get_contents($url);

	$response = json_decode($response);

		if(!$response->success){

		echo json_encode(array(

			'success' => false,

			'message' => "Invalid cpatcha. Please try again"

		));

		exit;

	}

	$to = "aonetheme@gmail.com";

    $to_name = "Aone Team";

	$fullname =(!empty($fullname)) ? $fullname : '';

	$email =(!empty($email)) ? $email : '';

	$phone =(!empty($phone)) ? $phone : '';

	$subject =(!empty($subject)) ? $subject : '';

	$message =(!empty($message)) ? $message : '';

	$msgbody = 'Hello Admin,

	You have received a message from contact form.

	Name: %FULNAME%

	Email: %EMAIL%

	Phone: %PHONE%

	Subject: %SUBJECT%

	Message: %MESSAGE%';

	$tokens = array('%FULNAME%','%EMAIL%','%PHONE%','%SUBJECT%','%MESSAGE%');

	$replace = array($fullname,$email,$phone,$subject,$message);

	$msgbody = str_replace($tokens,$replace,$msgbody);

	mail($to,$subject,$msgbody);

	echo json_encode(array(
		'success' => true,
		'message' => "Message Sent Successfully!"
	));	

	exit;
}

