<?php
/**
 * EDIT THE VALUES BELOW THIS LINE TO ADJUST THE CONFIGURATION
 * EACH OPTION HAS A COMMENT ABOVE IT WITH A DESCRIPTION
 */
/**
 * Specify the email address to which all mail messages are sent.
 * The script will try to use PHP's mail() function,
 * so if it is not properly configured it will fail silently (no error).
 */
$mailTo     = 'email@example.com';

/**
 * Set the message that will be shown on success
 */
$successMsg = 'Thank you, mail sent successfuly!';

/**
 * Set the message that will be shown if not all fields are filled
 */
$fillMsg    = 'Please fill all fields!';

/**
 * Set the message that will be shown on error
 */
$errorMsg   = 'Hm.. seems there is a problem, sorry!';

/**
 * DO NOT EDIT ANYTHING BELOW THIS LINE, UNLESS YOU'RE SURE WHAT YOU'RE DOING
 */

?>
<?php
if(
    !isset($_POST['rsv-fname']) || 
    !isset($_POST['rsv-lname']) || 
    !isset($_POST['rsv-phone']) || 
	!isset($_POST['rsv-date']) ||
	!isset($_POST['rsv-email']) ||
	!isset($_POST['rsv-message']) ||
    empty($_POST['rsv-fname']) ||
    empty($_POST['rsv-lname']) ||
	empty($_POST['rsv-phone']) || 
	empty($_POST['rsv-date']) ||
    empty($_POST['rsv-email']) ||
	empty($_POST['rsv-message'])
) {
	
	if( empty($_POST['rsv-fname']) && empty($_POST['rsv-email']) ) {
		$json_arr = array( "type" => "error", "msg" => $fillMsg );
		echo json_encode( $json_arr );		
	} else {

		$fields = "";
		if( !isset( $_POST['rsv-fname'] ) || empty( $_POST['rsv-fname'] ) ) {
			$fields .= "First Name";
		}
		
		if( !isset( $_POST['rsv-lname'] ) || empty( $_POST['rsv-phone'] ) ) {
			if( $fields == "" ) {
				$fields .= "Last Name";
			} else {
				$fields .= ", Last Name";
			}
		}
		
		if( !isset( $_POST['rsv-phone'] ) || empty( $_POST['rsv-phone'] ) ) {
			if( $fields == "" ) {
				$fields .= "Phone";
			} else {
				$fields .= ", Phone";
			}
		}
		
		if( !isset( $_POST['rsv-date'] ) || empty( $_POST['rsv-date'] ) ) {
			if( $fields == "" ) {
				$fields .= "Date";
			} else {
				$fields .= ", Date";
			}
		}
		
		if( !isset( $_POST['rsv-table'] ) || empty( $_POST['rsv-table'] ) ) {
			if( $fields == "" ) {
				$fields .= "Table";
			} else {
				$fields .= ", Table";
			}
		}
		
		if( !isset( $_POST['rsv-email'] ) || empty( $_POST['rsv-email'] ) ) {
			if( $fields == "" ) {
				$fields .= "Email";
			} else {
				$fields .= ", Email";
			}
		}
		
		if( !isset( $_POST['rsv-message'] ) || empty( $_POST['rsv-message'] ) ) {
			if( $fields == "" ) {
				$fields .= "Message";
			} else {
				$fields .= ", Message";
			}
		}
		
		$json_arr = array( "type" => "error", "msg" => "Please fill ".$fields." fields!" );
		echo json_encode( $json_arr );		
	
	}

} else {

	// Validate e-mail
	if (!filter_var($_POST['rsv-email'], FILTER_VALIDATE_EMAIL) === false) {
		
		$msg = "First Name: ".$_POST['rsv-fname']."\r\n";
		$msg .= "Last Name: ".$_POST['rsv-lname']."\r\n";
		$msg .= "Phone: ".$_POST['rsv-phone']."\r\n";
		$msg .= "Date: ".$_POST['rsv-date']."\r\n";
		$msg .= "Table: ".$_POST['rsv-table']."\r\n";
		$msg .= "Email: ".$_POST['rsv-email']."\r\n";
		$msg .= "Message: ".$_POST['rsv-message']."\r\n";
		
		$success = @mail($mailTo, $_POST['rsv-email'], $msg, 'From: ' . $_POST['rsv-name'] . '<' . $_POST['rsv-email'] . '>');
		
		if ($success) {
			$json_arr = array( "type" => "success", "msg" => $successMsg );
			echo json_encode( $json_arr );
		} else {
			$json_arr = array( "type" => "error", "msg" => $errorMsg );
			echo json_encode( $json_arr );
		}
		
	} else {
 		$json_arr = array( "type" => "error", "msg" => "Please enter valid email address!" );
		echo json_encode( $json_arr );	
	}

}