<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Main Core Class
 *
 * @since JoaoGrilo (1.0)
 * 
 */
if ( ! class_exists('Core') ) :

	class Core {

		/**
        * Main Core Instance.
        *
        * Insures that only one instance of Core Class exists in memory at any
        * one time. Also prevents needing to define globals all over the place.
        *
        * @since JoaoGrilo (1.0)
        *
        */
        public static function instance() {

            // Store the instance locally to avoid private static replication
            static $instance = null;

            // Only run these methods if they haven't been run previously
			if ( null === $instance ) {
				
				$instance = new Core;
				$instance->core_functions();
			}

            // Always return the instance
            return $instance;
        }

        /**
         * A dummy constructor to Core Class
         *
         * @since JoaoGrilo (1.0)
         * 
         * @access public
         * 
         */
        public function __construct() {}

        /**
		 * A dummy magic method to prevent JoaoGrilo from being cloned.
		 *
		 * @since JoaoGrilo (1.0)
		 */
		public function __clone() { _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'joao-grilo' ), '1.0' ); }

		/**
		 * A dummy magic method to prevent JoaoGrilo from being unserialized.
		 *
		 * @since JoaoGrilo (1.0)
		 */
		public function __wakeup() { _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'joao-grilo' ), '1.0' ); }


        public function core_functions() {
        	add_action( 'admin_menu', array( $this, 'removeTags_publish_box') );
			add_filter( 'manage_edit-post_columns', array( $this, 'removeTags_columns_filter'));
			add_action( 'admin_enqueue_scripts', array( $this, 'restrictTags_link') );
        }

		/**
		 * Remove the admin tags
		 * 
		 * @since JoaoGrilo (1.0)
		 * 
		 */
		public function removeTags(){}

		public function removeTags_publish_box(){
			remove_meta_box( 'tagsdiv-post_tag', 'post', 'side' );
			remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
		}

		public function removeTags_columns_filter( $columns ){
			unset($columns['tags']);
	    	return $columns;
		}

		public function restrictTags_link() {
		    $screen = get_current_screen();
			if($screen->id == 'edit-post_tag'){
				wp_die(__("Essa área foi desabilitada. Favor contatar o administrador."));
			}
		}

	}

	function core() {
		return Core::instance();
	}

endif;
