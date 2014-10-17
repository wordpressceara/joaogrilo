<?php
/**
 * WordPress Settings API Content Class
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
         * A constructor to JoaoGrilo_Settings_API_Content
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

        /**
         * Add the Admin Sub Page in the options page
         * 
         * @since JoaoGrilo (1.0)
         *
         * @access public
         * 
         */
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
                    'id'        => 'joaogrilo_basics',
                    'title'     => __( 'Basic Settings', 'joao-grilo' ),
                ),

                array(
                    'id'        => 'joaogrilo_tags',
                    'title'     => __( 'Tags Settings', 'joao-grilo' )
                )
				,

                array(
                    'id'        => 'joaogrilo_security',
                    'title'     => __( 'WP Security', 'joao-grilo' )
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
                        'name'      => 'checkbox-01',
                        'label'     => __( 'Checkbox', 'joao-grilo' ),
                        'desc'      => __( 'Checkbox Label', 'joao-grilo' ),
                        'type'      => 'checkbox',
                    ),

                ),

                'joaogrilo_tags' => array(

                    array(
                        'name'      => 'tags-checkbox-1',
                        'label'     => __( 'Tags Column', 'joao-grilo' ),
                        'desc'      => __( 'Remove Tags from Post Columns', 'joao-grilo' ),
                        'type'      => 'checkbox',
                    ),

                    array(
                        'name'      => 'tags-checkbox-2',
                        'label'     => __( 'Tags Publish Box', 'joao-grilo' ),
                        'desc'      => __( 'Remove Tags Publish Box', 'joao-grilo' ),
                        'type'      => 'checkbox',
                    ),

                    array(
                        'name'      => 'tags-checkbox-3',
                        'label'     => __( 'Tag Page Restrict', 'joao-grilo' ),
                        'desc'      => __( 'Restrict the Access to the Edit Post Tag', 'joao-grilo' ),
                        'type'      => 'checkbox'
                    )
                ),
				
				'joaogrilo_security' => array(

                    array(
                        'name'      => 'security-checkbox-1',
                        'label'     => __( 'Version', 'joao-grilo' ),
                        'desc'      => __( 'Remove Version Information', 'joao-grilo' ),
                        'type'      => 'checkbox',
                    ),
				
					array(
                        'name'      => 'security-checkbox-2',
                        'label'     => __( 'Error Message', 'joao-grilo' ),
                        'desc'      => __( 'Remove Error Message on the Login Screen', 'joao-grilo' ),
                        'type'      => 'checkbox',
                    )
					,
				
					array(
                        'name'      => 'security-checkbox-3',
                        'label'     => __( 'Restrict Access', 'joao-grilo' ),
                        'desc'      => __( 'Restrict Access to wp-admin', 'joao-grilo' ),
                        'type'      => 'checkbox',
                    )
				),
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

                <h2><?php _e('João Grilo', 'joao-grilo'); ?></h2>

                <?php 

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
