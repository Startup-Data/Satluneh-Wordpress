<?php
/*--------------------------------------------------------------
 Copyright (C) pixelemu.com
 License: http://www.pixelemu.com/license.html PixelEmu Proprietary Use License
 Website: http://www.pixelemu.com
 Support: info@pixelemu.com
 ---------------------------------------------------------------*/

add_action( 'wp_ajax_nopriv_send_email', 'pe_send_email' );
add_action( 'wp_ajax_send_email', 'pe_send_email' );

if ( ! function_exists( 'pe_send_email' ) ) {
	function pe_send_email() {

		if ( isset( $_POST['form_prefix'] ) ) {

			$fid = $_POST['form_prefix'];

			$nonce       = $_POST[ $fid . 'nonce' ];
			$fromName    = sanitize_text_field( $_POST[ $fid . 'contactName' ] );
			$fromEmail   = sanitize_email( $_POST[ $fid . 'contactEmail' ] );
			$subject     = sanitize_text_field( $_POST[ $fid . 'contactSubject' ] );
			$message     = stripslashes( esc_attr( $_POST[ $fid . 'contactMessage' ] ) );
			$targetEmail = sanitize_email( PEsettings::get( 'contact-email-recipients' ) );
			$admin_email = get_option('admin_email');

			$consent1_text = PEsettings::get('consent1-text');
			$consent2_text = PEsettings::get('consent2-text');
			
			if ( ! wp_verify_nonce( $nonce, 'send_email_nonce' ) ) {
				echo json_encode( array( 'success' => false, 'message' => __( 'Unverified nonce!', 'pe-terraclassic-plugin' ) ) );
				die();
			}

			/* Validate Target email and From email */
			$targetEmail = is_email( $targetEmail );
			if ( ! $targetEmail ) {
				echo json_encode( array(
					'success' => false,
					'message' => __( 'Target email address is not properly configured!', 'pe-terraclassic-plugin' )
				) );
				die();
			}
			
			/*$fromEmail = is_email( $fromEmail );
			if ( ! $fromEmail ) {
				echo json_encode( array(
					'success' => false,
					'message' => __( 'Provided email address is invalid!', 'pe-terraclassic-plugin' )
				) );
				die();
			}*/
			
			if ( ! $fromEmail ) {
				$fromEmail = $admin_email;
			}

			$email_subject = __( 'New message sent by', 'pe-terraclassic-plugin' ) . ' ' . $fromName . ' ' . __( 'using contact form at', 'pe-terraclassic-plugin' ) . ' ' . get_bloginfo( 'name' );
			$email_body    = __( "You have received a message from: ", 'pe-terraclassic-plugin' ) . $fromName . " <br/>";

			if ( ! empty( $subject ) ) {
				$email_body .= __( "Subject : ", 'pe-terraclassic-plugin' ) . $subject . " <br/>";
			}

			$email_body .= __( "Message: ", 'pe-terraclassic-plugin' ) . " <br/>";
			$email_body .= wpautop( $message ) . " <br/>";
			$email_body .= __( "You can contact ", 'pe-terraclassic-plugin' ) . $fromName . __( " via email, ", 'pe-terraclassic-plugin' ) . $fromEmail;

			if(isset($_POST['consent1-input']) || isset($_POST['consent2-input'])){
				$email_body .= '<br /><br /><strong>' .  __( "Agreed consents:", 'pe-terraclassic-plugin' ) . '</strong>';
			}

			if(isset($_POST['consent1-input'])){
				$email_body .= '<br />' . $consent1_text;
			}
			
			if(isset($_POST['consent2-input'])){
				$email_body .= '<br />' . $consent2_text;
			}

			$header = 'Content-type: text/html; charset=utf-8' . "\r\n";
			$header .= 'From: ' . $fromName . " <" . $fromEmail . "> \r\n";

			//captcha enabled
			$reCaptchaOpt = ( PEsettings::get( 'google-captcha-api' ) && PEsettings::get( 'google-captcha-sitekey' ) && PEsettings::get( 'google-captcha-secretkey' ) ) ? true : false;

			if ( $reCaptchaOpt && isset( $_POST['g-recaptcha-response'] ) ) {

				$secret    = PEsettings::get( 'google-captcha-secretkey' );
				$recaptcha = new \ReCaptcha\ReCaptcha( $secret );

				$resp = $recaptcha->verify( $_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'] );

				if ( $resp->isSuccess() ) {
					// Your code here to handle a successful verification

					if ( wp_mail( $targetEmail, $email_subject, $email_body, $header ) ) {
						echo json_encode( array(
							'success' => true,
							'message' => __( "Message sent successfully!", 'pe-terraclassic-plugin' )
						) );
					} else {
						echo json_encode( array(
							'success' => false,
							'message' => __( "Server Error: WordPress mail function failed!", 'pe-terraclassic-plugin' )
						) );
					}

				} else {
					// What happens when the CAPTCHA was entered incorrectly
					echo json_encode( array(
						'success' => false,
						'message' => __( "The reCAPTCHA wasn't entered correctly.", 'pe-terraclassic-plugin' )
					) );
					die();
				}

			} else {
				if ( wp_mail( $targetEmail, $email_subject, $email_body, $header ) ) {
					echo json_encode( array(
						'success' => true,
						'message' => __( "Message sent successfully!", 'pe-terraclassic-plugin' )
					) );
				} else {
					echo json_encode( array(
						'success' => false,
						'message' => __( "Server Error: WordPress mail function failed!", 'pe-terraclassic-plugin' )
					) );
				}
			}

		} else {
			echo json_encode( array( 'success' => false, 'message' => __( "Invalid Request !", 'pe-terraclassic-plugin' ) ) );
		}

		die();

	}

}
?>
