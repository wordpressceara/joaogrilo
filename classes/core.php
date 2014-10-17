<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;
	
	add_action( 'admin_init', 'core_functions');

	if ( ! function_exists('core_functions') ) :
		
		function core_functions() {

			// Basics Tags Options/Settings
			$tags_value = get_option( 'joaogrilo_tags', 'Nada Encontrado' );

			if ( isset( $tags_value['tags-checkbox-1'] ) == 'on' ) {
				add_filter( 'manage_posts_columns', 'joaogrilo_removetags_columns_filter' );
			}

			if ( isset( $tags_value['tags-checkbox-2'] ) == 'on' ) {

				add_action( 'admin_menu', 'jaogrilo_removetags_publish_box');
			}

			if ( isset( $tags_value['tags-checkbox-3'] ) == 'on' ) {
				add_action( 'admin_enqueue_scripts', 'joaogrilo_restricttags_link');
			}

		}

	endif;

	/**
	 * Removes the Tag Columns
	 * 
	 * @since JoaoGrilo (1.0)
	 */
	function joaogrilo_removetags_columns_filter( $columns ){

		unset( $columns['tags'] );
    	return $columns;

	}

	/**
	 * Removes Tag Edit Page
	 * 
	 * @since JoaoGrilo (1.0)
	 */
	function jaogrilo_removetags_publish_box(){

		remove_meta_box( 'tagsdiv-post_tag', 'post', 'side' );
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );

	}

	/**
	 * Restrict the Access to the Edit Post Tag
	 *
	 * @since JoaoGrilo (1.0)
	 */
	function joaogrilo_restricttags_link(){

	    $screen = get_current_screen();

		if ( $screen->id == 'edit-post_tag'){
			wp_die( __("You don't have permission to see this page. Please, contact the admin.") );
		}

	}
	
	/**
	 * Removing Version Information
	 *
	 * Removing Error Message on the Login Screen
	 *
	 * Restrict access to wp-admin
	 */
	$security_value = get_option( 'joaogrilo_security', '');
	
	if ( isset( $security_value['security-checkbox-1'] ) == 'on' ) {
		remove_action('wp_head', 'wp_generator');
	}
	
	if ( isset( $security_value['security-checkbox-2'] ) == 'on' ) {
		add_filter('login_errors',create_function('$a', "return null;"));
	}
	
	if ( isset( $security_value['security-checkbox-3'] ) == 'on' ) {
		add_action( 'admin_init', 'joaogrilo_restringir_login', 1);
	}
	
	function joaogrilo_restringir_login() {
		
		global $current_user;
		
		get_currentuserinfo();
		
		if ( $current_user->user_level < 4 ) {
		
		wp_redirect( get_bloginfo('url') );
		
		exit;
		
		}
	}
