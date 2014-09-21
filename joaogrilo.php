<?php
/**
 * Plugin João Grilo
*
* João Grilo é um canivete suíço para desenvolvedores WordPress.
*
* @package JoaoGrilo
* 
*/

/*
Plugin Name: João Grilo
Plugin URI: https://github.com/wordpressceara/joaogrilo
Description: O João Grilo é um canivete suíço para desenvolvedores WordPress. Ele contém as mais variadas funções para customização do projeto.
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
	 *  Plugin Class Constructor
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

			$this->version    = '1.0';
			$this->db_version = 100;

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

			// Classes
			require( $this->plugin_dir . 'classes/core.php' );
			
			// Admin Menu Settings
			require( $this->plugin_dir . 'settings/class-settings-api.php' );
			require( $this->plugin_dir . 'settings/settings-api.php' );
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

	// "And now here's something we hope you'll really like!"
	} else {
		$GLOBALS['jg'] = joaogrilo();
	}
	
endif;