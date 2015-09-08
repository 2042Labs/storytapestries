<?php

if ( ! class_exists( 'WDW_Main' ) ) {

	/**
	 * Main / front controller class
	 */
	class WDW_Main extends WDW_Module {

		protected $modules;
		const VERSION    = '1.0.0';
		const PREFIX     = 'wdw-';
        const REQUIRED_CAPABILITY = 'administrator';

        /**
         * Plugin directory path value. set in constructor
         * @access public
         * @var string
         */
        public static $plugin_dir;
        /**
         * Plugin url. set in constructor
         * @access public
         * @var string
         */
        public static $plugin_url;

        /**
         * Plugin name. set in constructor
         * @access public
         * @var string
         */
        public static $plugin_name;

        /**
         * The Plugin settings
         *
         * @static
         * @var string
         */
        static $settings;

		/**
		 * Constructor
		 */
		protected function __construct() {

            self::$plugin_dir = plugin_dir_path(__FILE__);
            self::$plugin_url = plugins_url('', __FILE__);
            self::$plugin_name = plugin_basename(__FILE__);
            WDW_Settings::get_options();

            if(WDW_Main::$settings['wdw_initial_dt'] == ''){
                $options = WDW_Main::$settings;
                $options['wdw_initial_dt'] = time();
                WDW_Settings::update_options($options);
            }

			$this->register_hook_callbacks();
			$this->modules = array(
				'WDW_Dashboard'     => WDW_Dashboard::get_instance(),
                'WDW_Show'          => WDW_Show::get_instance(),
			);
		}

		public function register_hook_callbacks() {

			add_action( 'wp_enqueue_scripts',    __CLASS__ . '::load_resources' );
			add_action( 'admin_enqueue_scripts', __CLASS__ . '::load_resources' );
            add_action( 'admin_init',             array($this, 'admin_init'));

            // If the plugin isn't activated by Aweber or can be upgrade, show message
            add_action('admin_notices',  __CLASS__ . '::show_admin_notice');
            add_action( 'admin_init', __CLASS__ . '::allow_subscriber_uploads' );
		}

        public function allow_subscriber_uploads() {


            $subscriber = get_role('subscriber');
            $subscriber->add_cap('upload_files');
        }

        public function show_admin_notice() {

                    $variables = array();
                    $msg_warning_1[]='test';
                    $variables['msg_warning'] = $msg_warning_1;
                    echo self::render_template( 'global-settings/page-notice.php', $variables );
                    unset($variables);
        }

        public function admin_init() {

            add_action('admin_post_wdw_global_settings', array('WDW_Dashboard', 'save_global_settings'));

            add_action('wp_ajax_wdw_save_global_settings', array( 'WDW_Dashboard', 'ajax_save_global_settings'));
            add_action('wp_ajax_wdw_save_listing_settings', array( 'WDW_Dashboard', 'ajax_save_listing_settings'));

            add_action('wp_ajax_wdw_msg_submit_listing', array( 'WDW_Show', 'ajax_wdw_msg_submit_listing'));
            add_action('wp_ajax_wdw_click_main_category', array( 'WDW_Show', 'ajax_wdw_click_main_category'));
            add_action('wp_ajax_wdw_contact_form', array( 'WDW_Show', 'ajax_wdw_contact_form'));

            add_action('wp_ajax_wdw_register_new_user', array( 'WDW_Show', 'ajax_register_new_user'));
            add_action('wp_ajax_wdw_visit_listing', array( 'WDW_Show', 'ajax_wdw_visit_listing'));

            add_action('wp_ajax_wdw_set_support_link', array( 'WDW_Dashboard', 'ajax_set_support_link'));
            add_action('wp_ajax_wdw_set_support_time', array( 'WDW_Dashboard', 'ajax_set_support_time'));

            add_action('pending_to_publish', __CLASS__. '::wdw_notify_when_approved');


        }

        /**
         * Register CSS, JavaScript, etc
         */
        public static function load_resources() {

            wp_register_script(
                self::PREFIX . 'admin-js',
                plugins_url( '/js/admin.js', dirname( __FILE__ ) ),
                array( 'jquery' ),
                self::VERSION,
                true
            );

            wp_register_script(
                self::PREFIX . 'bootstrap-js',
                plugins_url( '/js/bootstrap/js/bootstrap.min.js', dirname( __FILE__ ) ),
                array( 'jquery' ),
                self::VERSION,
                true
            );

            wp_register_script(
                self::PREFIX . 'zozo-js',
                plugins_url( '/js/zozo/js/zozo.tabs.min.js', dirname( __FILE__ ) ),
                array( 'jquery' ),
                self::VERSION,
                true
            );

            wp_register_script(
                self::PREFIX . 'colorpicker-js',
                plugins_url( '/js/bootstrap-colorpicker.min.js', dirname( __FILE__ ) ),
                array( 'jquery' ),
                self::VERSION,
                true
            );



            ///
            wp_register_style(
                self::PREFIX . 'admin-css',
                plugins_url( 'css/admin.css', dirname( __FILE__ ) ),
                array(),
                self::VERSION,
                'all'
            );
            wp_register_style(
                self::PREFIX . 'user-css',
                plugins_url( 'css/user.css', dirname( __FILE__ ) ),
                array(),
                self::VERSION,
                'all'
            );
            wp_register_style(
                self::PREFIX . 'bootstrap-css',
                plugins_url( '/js/bootstrap/css/bootstrap.css', dirname( __FILE__ ) ),
                array(),
                self::VERSION,
                'all'
            );

            wp_register_style(
                self::PREFIX . 'zozo-tab-css',
                plugins_url( '/js/zozo/css/zozo.tabs.min.css', dirname( __FILE__ ) ),
                array(),
                self::VERSION,
                'all'
            );

            wp_register_style(
                self::PREFIX . 'zozo-tab-flat-css',
                plugins_url( '/js/zozo/css/zozo.tabs.flat.min.css', dirname( __FILE__ ) ),
                array(),
                self::VERSION,
                'all'
            );

            wp_register_style(
                self::PREFIX . 'colorpicker-css',
                plugins_url( '/css/bootstrap-colorpicker.min.css', dirname( __FILE__ ) ),
                array(),
                self::VERSION,
                'all'
            );


            wp_register_style(
                self::PREFIX . 'font-awesome-css',
                plugins_url( '/css/font-awesome-4.2.0/css/font-awesome.min.css', dirname( __FILE__ ) ),
                array(),
                self::VERSION,
                'all'
            );


            wp_enqueue_media();
            wp_enqueue_style(self::PREFIX . 'font-awesome-css');

            wp_localize_script(self::PREFIX . 'admin-js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
            wp_enqueue_script( self::PREFIX . 'admin-js' );

            wp_enqueue_style(self::PREFIX . 'user-css');

        }

        /**
         * Creates the markup for the Settings header
         */
        public static function markup_settings_header() {

            if ( current_user_can( self::REQUIRED_CAPABILITY ) ) {
                $variables = array();
                $variables['setting_logo_path'] = dirname(WDW_Main::$plugin_url) . '/img/logo/wp_directory_wizard_logo.png';
                echo self::render_template( 'global-settings/page-header.php' ,$variables);
            }
            else {
                wp_die( 'Access denied.' );
            }
        }

        /** get all pages */
        static function get_all_pages()
        {
            /** Get all pages */
            $args = array(
                'sort_order' => 'ASC',
                'sort_column' => 'post_title',
                'hierarchical' => 1,
                'exclude' => '',
                'include' => '',
                'meta_key' => '',
                'meta_value' => '',
                'authors' => '',
                'child_of' => 0,
                'parent' => -1,
                'exclude_tree' => '',
                'number' => '',
                'offset' => 0,
                'post_type' => 'page',
                'post_status' => 'publish'
            );

            $pages = get_pages($args);

            return $pages;
        }

        static function wdw_mail($to, $subject, $message, $headers = '') {

            $from_name = self::$settings['wdw_email_from_name'];
            $from_email = self::$settings['wdw_email_from_email'];

            // If we're not passing any headers, default to our internal from address
            if (empty($headers)) {
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= sprintf('From: %s <%s>', $from_name, $from_email) . "\r\n";
            }
            ob_start();
            wp_mail($to, $subject, $message, $headers);
            ob_end_clean();
        }



        /**
         * Send an email notification to the email specified in the directory settings.
         *
         * @param array $data    The Listing settings
         * @param int   $post_id The post ID for New
         */
        function wdw_notify_admin($data, $post_id) {

            $to = self::$settings['wdw_email_notification_email'];
            $subject = self::$settings['wdw_email_toadmin_subject'];

            $message = self::$settings['wdw_email_toadmin_body'];
            $message = str_replace('{aprove_link}', admin_url('post.php?post=' . $post_id . '&action=edit'), $message);
            $message = str_replace('{title}', $data['listing_title'], $message);
            $message = str_replace('{description}', $data['listing_description'], $message);

            self::wdw_mail($to, $subject, $message);

        }


        /**
         * Send an email notification to the author of the listing, an easy way to supply them with a copy of the
         * information they submitted and any helpful advice while waiting for it to be approved.
         *
         * @param array $data    The Listing Settings
         * @param int   $post_id The post ID for New
         */
        function wdw_notify_author($data) {

            $to = $data['listing_email'];

            if(trim($to) == '') return;

            $subject = self::$settings['wdw_email_toauthor_subject'];
            $message = self::$settings['wdw_email_toauthor_body'];

            $message = str_replace('{site_title}', get_bloginfo('name'), $message);
            $message = str_replace('{directory_title}', self::$settings['wdw_directory_label'], $message);
            $message = str_replace('{directory_email}', self::$settings['wdw_email_from_email'], $message);
            $message = str_replace('{title}', $data['listing_title'], $message);

            self::wdw_mail($to, $subject, $message);

        }


        /**
         * Send an email to a listing author when their listing has been updateding from pending review to published.
         *
         * @param object $post The WP_Post object
         */
        function wdw_notify_when_approved($post) {

            // Don't send an email if this is the wrong post type or it's already been approved before


            if ('wdw_listing' != get_post_type( $post->ID ))
                return;

            $user = get_userdata($post->post_author);
            $permalink = get_permalink($post->ID);
            $title = get_the_title($post->ID);

            $to = $user->data->user_email;



            $subject = self::$settings['wdw_email_public_subject'];

            $message = self::$settings['wdw_email_public_body'];
            $message = str_replace('{site_title}', get_bloginfo('name'), $message);
            $message = str_replace('{directory_title}', self::$settings['wdw_directory_label'], $message);
            $message = str_replace('{title}', $title, $message);
            $message = str_replace('{link}', $permalink, $message);


           // $post->post_content =$subject;
           // wp_update_post($post);

            self::wdw_mail($to, $subject, $message);

        }

        /*
         * Instance methods
         */
        public function activate( $network_wide ) {

            $options = WDW_Main::$settings;
            $options['wdw_initial_dt'] = time();

            if($options['wdw_front_page'] == 0){

                $is_exist_page = '0';
                $pages = WDW_Main::get_all_pages();
                foreach($pages as $page)
                {
                    if($page->post_name == 'wp_directory'){
                        $is_exist_page = '1';
                        break;
                    }

                }

                if($is_exist_page == '0'){
                    $directory = wp_insert_post(array(
                        'post_title'     => 'WP Directory',
                        'post_name'      => 'wp_directory',
                        'post_content'   => '[wdw-listing-list]',
                        'post_status'    => 'publish',
                        'post_type'      => 'page',
                        'comment_status' => 'closed',
                    ));
                    $options['wdw_front_page'] = $directory;
                }
            }

            WDW_Settings::update_options($options);
        }

        public function deactivate() {
            WDW_Settings::delete_options();
            flush_rewrite_rules();
        }

	} // end WDW_Main

}
