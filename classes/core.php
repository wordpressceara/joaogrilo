<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;
	
	add_action( 'admin_init', 'core_functions');

	if ( ! function_exists('core_functions') ) :
		
		function core_functions() {

			// Basics Tags Options/Settings
			$tags_value = get_option( 'joaogrilo_tags', 'Nothing Found' );

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