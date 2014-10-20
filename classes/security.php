<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;
	
	add_action( 'admin_init', 'security_functions');

	if ( ! function_exists('security_functions') ) :
		
		function security_functions() {

			$security_value = get_option( 'joaogrilo_security', 'Nothing Found' );

			if ( isset( $security_value['security-checkbox-1'] ) == 'on' ) {
				remove_action('wp_head', 'wp_generator');
			}

		}

	endif;