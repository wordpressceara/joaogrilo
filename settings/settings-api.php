<?php
/**
 * WordPress settings API Demo Class
 *
 * @package JoaoGrilo
 *
 * @since JoaoGrilo (1.0)
 * 
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'JoaoGrilo_Settings_API_Content' ) ) :

    class JoaoGrilo_Settings_API_Content {

        private $settings_api;

        /**
         * A constructor to JoaoGrilo_Settings_API
         *
         * @since JoaoGrilo (1.0)
         * 
         * @access public
         * 
         */
        public function __construct() {

            $this->settings_api = new JoaoGrilo_Settings_API;

            add_action( 'admin_init', array($this, 'admin_init') );
            add_action( 'admin_menu', array($this, 'admin_menu') );
        }

        /**
         * 
         * @since JoaoGrilo (1.0)
         *
         * @access public
         * 
         */
        public function admin_init() {

            // set the settings
            $this->settings_api->set_sections( $this->get_settings_sections() );
            $this->settings_api->set_fields( $this->get_settings_fields() );

            // initialize settings
            $this->settings_api->admin_init();
        }

        public function admin_menu() {
            add_options_page( __('João Grilo', 'joao-grilo' ), __('João Grilo', 'joao-grilo'), 'manage_options',  'joao-grilo',  array($this, 'joaogrilo_plugin_page') );
        }

        /**
         * Returns all the settings sections
         *
         * @return array settings sections
         *
         * @since JoaoGrilo (1.0)
         * 
         */
        public function get_settings_sections() {
            $sections = array(
                array(
                    'id' => 'joaogrilo_basics',
                    'title' => __( 'Basic Settings', 'joao-grilo' )
                )
            );
            return $sections;
        }

        /**
         * Returns all the settings fields
         *
         * @return array settings fields
         *
         * @since JoaoGrilo (1.0)
         * 
         */
        public function get_settings_fields() {
            $settings_fields = array(
                'joaogrilo_basics' => array(

                    array(
                        'name' => 'checkbox',
                        'label' => __( 'Checkbox', 'joao-grilo' ),
                        'desc' => __( 'Checkbox Label', 'joao-grilo' ),
                        'type' => 'checkbox'
                    )

                )
            );

            return $settings_fields;
        }

        /**
         * Fuction to output the content on the Settings Page
         * 
         * @since JoaoGrilo (1.0)
         * 
         */
        public function joaogrilo_plugin_page() { ?>
            <div class="wrap">

                <h2>João Grilo</h2>

                $this->settings_api->show_navigation();
                $this->settings_api->show_forms(); 

                ?>

            </div>

        <?php }

        /**
         * Get all the pages
         *
         * @return array page names with key value pairs
         *
         * @since JoaoGrilo (1.0)
         *
         * @access public
         * 
         */
        public function get_pages() {
            
            $pages = get_pages();
            
            $pages_options = array();

            if ( $pages ) {
                foreach ($pages as $page) {
                    $pages_options[$page->ID] = $page->post_title;
                }
            }

            return $pages_options;
        }

    }

endif;

$settings = new JoaoGrilo_Settings_API_Content();