<?php
/**
 * João Grilo Plugin
*
* João Grilo is a tool to WordPress developers. It comes with several options intended to be used in the customization of your project.
*
* @package JoaoGrilo
* 
*/

/*
Plugin Name: João Grilo
Plugin URI: https://github.com/wordpressceara/joaogrilo
Description: João Grilo is a tool to WordPress developers. It comes with several options intended to be used in the customization of your project.
Version: 1.0
Author: Comunidade Wordpress Ceará
Author URI: https://www.facebook.com/groups/wordpressceara
Text Domain: joao-grilo
Domain Path: /jg-languages/
License: GPLv2 or later
  
Copyright 2014  COMUNIDADE WORDPRESS CEARÁ  (email : espellcaste@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Main JoaoGrilo Class
 *
 * @since JoaoGrilo (1.0)
 * 
 */
if ( ! class_exists('JoaoGrilo') ) :
	
	/**
	 * Plugin Class Constructor
	 *
	 * @since JoaoGrilo (1.0)
	 * 
	 */
	class JoaoGrilo {

		/**
		* Main JoaoGrilo Instance.
		*
		* Insures that only one instance of JoaoGrilo Class exists in memory at any
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
				
				$instance = new JoaoGrilo;
				$instance->constants();
				$instance->setup_globals();
				$instance->setup_hooks();
				$instance->includes();
			}

			// Always return the instance
			return $instance;
		}


		/** Magic Methods *********************************************************/

		/**
		 * A dummy constructor to prevent JoaoGrilo from being loaded more than once.
		 *
		 * @since JoaoGrilo (1.0)
		 * @access private
		 * @see JoaoGrilo::instance()
		 */
		private function __construct() { /* Do nothing here */ }

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

		/** Private Methods *******************************************************/

		/**
		 * Bootstrap constants.
		 *
		 * @since JoaoGrilo (1.0)
		 * @access private
		 * 
		 */
		private function constants() {

			// Path and URL
			if ( ! defined( 'JOAOGRILO_PLUGIN_DIR' ) ) {
				define( 'JOAOGRILO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			if ( ! defined( 'JOAOGRILO_PLUGIN_URL' ) ) {
				define( 'JOAOGRILO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

		}

		/**
		 * Component global variables.
		 *
		 * @since JoaoGrilo (1.0)
		 * 
		 * @access private
		 *
		 */
		private function setup_globals() {

			/** Versions **********************************************************/

			$this->version    = '1.1';
			$this->db_version = 1;

			// Domain
			$this->domain = 'joao-grilo';

			/** Paths**************************************************************/

			// JoaoGrilo root directory
			$this->file           = constant( 'JOAOGRILO_PLUGIN_DIR' ) . 'joaogrilo.php';
			$this->basename       = basename( constant( 'JOAOGRILO_PLUGIN_DIR' ) ) . '/joaogrilo.php';
			$this->plugin_dir     = constant( 'JOAOGRILO_PLUGIN_DIR' );
			$this->plugin_url     = trailingslashit( constant( 'JOAOGRILO_PLUGIN_URL' ) );

			// Languages
			$this->lang_dir       = $this->plugin_dir . 'jg-languages';

		}

		/**
		 * Include required files.
		 *
		 * @since JoaoGrilo (1.0)
		 * 
		 * @access private
		 *
		 */
		private function includes() {
			
			// Admin Menu Settings
			require( $this->plugin_dir . 'settings/class-settings-api.php' );
			require( $this->plugin_dir . 'settings/settings-api.php' );

			// Classes
			require( $this->plugin_dir . 'classes/core.php' );
			require( $this->plugin_dir . 'classes/security.php' );
		}

		/**
		 * Setups some hooks to register post type stuff, scripts, set
		 * the current user & load plugin's BuddyPress integration
		 *
		 * @since JoaoGrilo (1.0)
		 *
		 * @uses  add_action() to perform custom actions at key points
		 */
		private function setup_hooks() {
			
			// Main hooks
			add_action( 'wp_joao-grilo_loaded',              array( $this, 'load_textdomain'     ), 0 );
		}

		/**
		 * Loads the translation files
		 *
		 * @since JoaoGrilo (1.0)
		 *
		 * @uses get_locale() to get the language of WordPress config
		 * @uses load_texdomain() to load the translation if any is available for the language
		 */
		public function load_textdomain() {

			// Traditional WordPress plugin locale filter
			$locale        = apply_filters( 'plugin_locale', get_locale(), $this->domain );
			$mofile        = sprintf( '%1$s-%2$s.mo', $this->domain, $locale );

			// Setup paths to current locale file
			$mofile_local  = $this->lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/' . $this->domain . '/' . $mofile;

			// Look in global /wp-content/languages/joaogrilo
			load_textdomain( $this->domain, $mofile_global );

			// Look in local /wp-content/plugins/joaogrilo/jg-languages/ folder
			load_textdomain( $this->domain, $mofile_local );

			// Look in global /wp-content/languages/plugins/
			load_plugin_textdomain( $this->domain );
		}

	}

	/**
	 * The main function responsible for returning the one true JoaoGrilo Instance to functions everywhere.
	 *
	 * Use this function like you would a global variable, except without needing
	 * to declare the global.
	 *
	 * Example: <?php $jg = joaogrilo(); ?>
	 *
	 * @return Joaogrilo The one true JoaoGrilo Instance.
	 *
	 * @since JoaoGrilo (1.0)
	 */
	function joaogrilo() {
		return JoaoGrilo::instance();
	}
	
	/**
	 * Hook JoaoGrilo early onto the 'plugins_loaded' action..
	 *
	 * This gives all other plugins the chance to load before JoaoGrilo, to get
	 * their actions, filters, and overrides setup without JoaoGrilo being in the
	 * way.
	 *
	 * @since JoaoGrilo (1.0)
	 */
	if ( defined( 'JOAOGRILO_LATE_LOAD' ) ) {
		add_action( 'plugins_loaded', 'joaogrilo', (int) JOAOGRILO_LATE_LOAD );

	// "And now here's something I kinda hope you'll like!" =)
	} else {
		$GLOBALS['jg'] = joaogrilo();
	}
endif;