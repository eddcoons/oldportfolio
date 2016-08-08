<?php

// Exit if accessed directly
defined('ABSPATH') || die;

add_action( 'wp_ajax_sendmail', 'zorbix_sendmail_callback' );
add_action( 'wp_ajax_nopriv_sendmail', 'zorbix_sendmail_callback' );


if(!( function_exists('zorbix_sendmail_callback') )){
	function zorbix_sendmail_callback () {


		$message_error = zorbix_settings::get_option( 'message_error' );
		$to = zorbix_settings::get_option_or_default('contact_email');
		$name_error = zorbix_settings::get_option( 'name_error' );
		$message_error_length = zorbix_settings::get_option( 'message_error_length' );
		$email_error = zorbix_settings::get_option( 'email_error' );

		// Sent and failed messages
		$sent_message           = zorbix_settings::get_option_or_default( 'contact_success_message');
		$failed_message         = zorbix_settings::get_option_or_default( 'contact_failed_message', true);

		$formData = $_REQUEST['formData'];
		$form = array();

		// Neaten form data array
		foreach ($formData as $value) {
			$form[$value['name']] = $value['value'];
		}

		$name = strip_tags($form['name']);
		$message = strip_tags($form['message']);
		$email = $form['email'];

		if(isset($form['subject'])) {
			$subject = strip_tags($form['subject']);
		}

		if(strlen($name)<2) {
			$errors[]   = $name_error;
		}

		if(strlen($message)<1) {
			$errors[]      = $message_error;
		} elseif(strlen($message)<5) {
			$errors[]             = $message_error_length;
		}

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors[]    = $email_error;
		}

		$body = "From: $name \n \n";

		if(isset($subject)) {
			$subject_pre = "Subject: ";
			if(strlen($subject)<1) {
				$subject = $subject_pre.'None';
			} else {
				$subject = $subject_pre.$subject;
			}
			$body .= $subject." \n \n";
		} else {
			$subject = '';
		}

		$body .= $message;
		$headers = "From: $email";
		$alert = '';

		if(wp_mail($to, $subject, $body, $headers)) {
			$alert = $sent_message ;
		} else {
			$errors[] = $failed_message ;
		}

		if(isset($errors) && count($errors) > 0) {
			echo "<div class='contact-error alert error'>";
			foreach($errors as $error) {
				echo esc_html( $error ) . '<br>';
			}
			echo '</div>';
		} else {
			echo "<div class='alert success'>";
			echo  esc_html( $alert );
			echo "</div>";

		}

		die(); // this is required to return a proper result
	}
}
