<?php
/*--------------------------------------------------------------
Copyright (C) pixelemu.com
License: https://www.pixelemu.com/company/license PixelEmu Proprietary Use License
Website: https://www.pixelemu.com
Support: info@pixelemu.com
 ---------------------------------------------------------------*/

add_action('wp_ajax_nopriv_send_email', 'send_email');
add_action('wp_ajax_send_email', 'send_email');

if (!function_exists('send_email')) {
	function send_email() {

		if (isset($_POST['contactEmail'])) :

			$nonce = $_POST['nonce'];
			$fromName = sanitize_text_field($_POST['contactName']);
			/* Sanitize From email */
			$fromEmail = sanitize_email($_POST['contactEmail']);
			$subject = sanitize_text_field($_POST['contactSubject']);
			$message = stripslashes($_POST['contactMessage']);
			/* Sanitize Target email */
			$targetEmail = sanitize_email(ot_get_option('contact_email'));
			

			if (!wp_verify_nonce($nonce, 'send_email_nonce')) {
				echo json_encode(array('success' => false, 'message' => __('Unverified Nonce!', 'PixelEmu')));
				die ;
			}

			/* Validate Target email and From email */
			$targetEmail = is_email($targetEmail);
			if (!$targetEmail) {
				echo json_encode(array('success' => false, 'message' => __('Target Email address is not properly configured!', 'PixelEmu')));
				die ;
			}

			$fromEmail = is_email($fromEmail);
			if (!$fromEmail) {
				echo json_encode(array('success' => false, 'message' => __('Provided Email address is invalid!', 'PixelEmu')));
				die ;
			}

			$email_subject = __('New message sent by', 'PixelEmu') . ' ' . $fromName . ' ' . __('using contact form at', 'PixelEmu') . ' ' . get_bloginfo('name');

			$email_body = __("You have received a message from: ", 'PixelEmu') . $fromName . " <br/>";

			if (!empty($subject)) {
				$email_body .= __("Subject : ", 'PixelEmu') . $subject . " <br/>";
			}

			$email_body .= __("Their additional message is as follows.", 'PixelEmu') . " <br/>";
			$email_body .= wpautop($message) . " <br/>";
			$email_body .= __("You can contact ", 'PixelEmu') . $fromName . __(" via email, ", 'PixelEmu') . $fromEmail;

			$header = 'Content-type: text/html; charset=utf-8' . "\r\n";
			$header .= 'From: ' . $fromName . " <" . $fromEmail . "> \r\n";

			if (wp_mail($targetEmail, $email_subject, $email_body, $header)) {
				echo json_encode(array('success' => true, 'message' => __("Message Sent Successfully!", 'PixelEmu')));
			} else {
				echo json_encode(array('success' => false, 'message' => __("Server Error: WordPress mail function failed!", 'PixelEmu')));
			}
		else :
			echo json_encode(array('success' => false, 'message' => __("Invalid Request !", 'PixelEmu')));
		endif;

		die ;

	}

}
?>