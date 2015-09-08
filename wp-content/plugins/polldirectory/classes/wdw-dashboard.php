<?php

if ( ! class_exists( 'WDW_Dashboard' ) ) {

	/**
	 * Handles plugin settings and user profile meta fields
	 */
	class WDW_Dashboard extends WDW_Module {

        const page_id = 'wdw_dashboard_page';
        const PREFIX     = 'wdw-';

        protected $modules;
        protected  $page_hook;
        static $post_types_to_ignore;

		/**
		 * Constructor
		 */
		protected function __construct() {
            self::$post_types_to_ignore = array('thirstylink');
            $this->register_hook_callbacks();

		}

		/**
		 * Register callbacks for actions and filters
		 */
		public function register_hook_callbacks() {

			add_action('admin_menu', __CLASS__ . '::register_settings_pages' );
            add_action( 'init', __CLASS__ . '::create_wdw_listing_taxonomies', 0 );
            add_action( 'init', __CLASS__ . '::custom_post_wdw_listing_init' );

            add_action( 'pre_get_posts', __CLASS__ . '::post_type_fetch' );
            //add extra fields to category edit form hook
            add_action ( 'wdw_category_edit_form_fields', __CLASS__ . '::extra_category_fields');
            // save extra category extra fields hook
            add_action ( 'edited_wdw_category', __CLASS__ . '::save_extra_category_fileds');

        }
//add extra fields to category edit form callback function
        function extra_category_fields( $tag ) {    //check for existing featured ID
            $t_id = $tag->term_id;
            $cat_meta = get_option( "wdw_category_$t_id");

            ?>
            <tr class="form-field">
                <th scope="row" valign="top"><label for="cat_Image_url"><?php _e('Category Image Url'); ?></label></th>
                <td onclick="upload_image_to_category(this);">
                    <input type="text" name="Cat_meta[img]" id="wdw_Cat_meta" size="3" style="width:60%;" value="<?php echo $cat_meta['img'] ? $cat_meta['img'] : ''; ?>"><br />
                    <span class="description"><?php _e('Image for category: use full url with http://'); ?></span>
                </td>
            </tr>

        <?php
        }


        // save extra category extra fields callback function
        function save_extra_category_fileds( $term_id ) {
            if ( isset( $_POST['Cat_meta'] ) ) {
                $t_id = $term_id;
                $cat_meta = get_option( "wdw_category_$t_id");
                $cat_keys = array_keys($_POST['Cat_meta']);
                foreach ($cat_keys as $key){
                    if (isset($_POST['Cat_meta'][$key])){
                        $cat_meta[$key] = $_POST['Cat_meta'][$key];
                    }
                }
                //save the option array
                update_option( "wdw_category_$t_id", $cat_meta );
            }
        }


        //
        function post_type_fetch( $query ) {

            if ( is_admin() ) {
                global $post;
                $types_to_have_boxes = get_post_type( $post );

                if ($types_to_have_boxes == 'wdw_listing') {

                    add_meta_box( 'WDW_metabox_below', 'Listing Settings', __CLASS__ . '::show_metabox_below', $types_to_have_boxes_name, 'normal','core');
                }
            }
        }

        // create two taxonomies, genres and writers for the post type "wdw_listing"
        function create_wdw_listing_taxonomies() {

            // Add new taxonomy, make it hierarchical (like categories)
            $labels = array(
                'name'              => _x( 'Categories', 'taxonomy general name' ),
                'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
                'search_items'      => __( 'Search Categories' ),
                'all_items'         => __( 'All Categories' ),
                'parent_item'       => __( 'Parent Category' ),
                'parent_item_colon' => __( 'Parent Category:' ),
                'edit_item'         => __( 'Edit Category' ),
                'update_item'       => __( 'Update Category' ),
                'add_new_item'      => __( 'Add New Category' ),
                'new_item_name'     => __( 'New Category Name' ),
                'menu_name'         => __( 'Categories' ),
            );

            $args = array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => WDW_Main::$settings['wdw_taxonomy_slug'] ), // category
            );

            register_taxonomy( 'wdw_category', array( 'wdw_listing' ), $args );

            // Add new taxonomy, NOT hierarchical (like tags)
            $labels = array(
                'name'                       => _x( 'Tags', 'taxonomy general name' ),
                'singular_name'              => _x( 'Tag', 'taxonomy singular name' ),
                'search_items'               => __( 'Search Tags' ),
                'popular_items'              => __( 'Popular Tags' ),
                'all_items'                  => __( 'All Tags' ),
                'parent_item'                => null,
                'parent_item_colon'          => null,
                'edit_item'                  => __( 'Edit Tag' ),
                'update_item'                => __( 'Update Tag' ),
                'add_new_item'               => __( 'Add New Tag' ),
                'new_item_name'              => __( 'New Tag Name' ),
                'separate_items_with_commas' => __( 'Separate Tags with commas' ),
                'add_or_remove_items'        => __( 'Add or remove tags' ),
                'choose_from_most_used'      => __( 'Choose from the most used tags' ),
                'not_found'                  => __( 'No tags found.' ),
                'menu_name'                  => __( 'Tags' ),
            );

            $args = array(
                'hierarchical'          => false,
                'labels'                => $labels,
                'show_ui'               => true,
                'show_admin_column'     => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var'             => true,
                'rewrite'               => array( 'slug' => WDW_Main::$settings['wdw_post_type_slug'] ), // tag
            );

            register_taxonomy( 'wdw_tag', 'wdw_listing', $args );

        }


        /**
         * Register a wdw_listing post type.
         *
         */
        function custom_post_wdw_listing_init() {
            $labels = array(
                'name'               => _x( 'WP Directory', 'post type general name' ),
                'singular_name'      => _x( 'Listing', 'post type singular name' ),
                'menu_name'          => _x( 'WP Directory', 'admin menu' ),
                'name_admin_bar'     => _x( 'Listing', 'add new on admin bar' ),
                'add_new'            => _x( 'Add Listing', 'listing' ),
                'add_new_item'       =>  'Add New Listing',
                'new_item'           =>  'New Listing',
                'edit_item'          =>  'Edit Listing',
                'view_item'          =>  'View Listing',
                'all_items'          =>  'All Listings',
                'search_items'       =>  'Search Listings',
                'parent_item_colon'  =>  'Parent Listings:',
                'not_found'          =>  'No listings found.',
                'not_found_in_trash' =>  'No listings found in Trash.'
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'listing' ),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => null,
                'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
            );

            register_post_type( 'wdw_listing', $args );

        }


		/**
		 * Adds pages to the Admin Panel menu
		 */
		public function register_settings_pages() {

            $hook = add_submenu_page('edit.php?post_type=wdw_listing', 'settings', 'Settings', 'manage_options', 'wdw_listing_settings', 'WDW_Dashboard::markup_dashboard_page');

            add_action( 'admin_print_scripts-' . $hook, __CLASS__ . '::enqueue_scripts');
            add_action( 'admin_print_styles-' . $hook, __CLASS__ . '::enqueue_styles');

        }

        /**
         * enqueue scripts of plugin
         */
        function enqueue_scripts()
        {
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-datepicker' );
            wp_enqueue_script( self::PREFIX . 'bootstrap-js' );
            wp_localize_script(self::PREFIX . 'admin-js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
            wp_enqueue_script( self::PREFIX . 'admin-js' );
            wp_enqueue_script(self::PREFIX . 'colorpicker-js');
            wp_enqueue_script( self::PREFIX . 'zozo-js' );
        }

        /**
         * enqueue style sheets of plugin
         */
        function enqueue_styles()
        {

            wp_enqueue_style( 'datepickercss',
                plugins_url( 'css/ui-lightness/ jquery-ui-1.8.17.custom.css',
                    dirname(__FILE__) ), array(), '1.8.17' );

            wp_enqueue_style( self::PREFIX . 'admin-css' );
            wp_enqueue_style( self::PREFIX . 'bootstrap-css' );

            wp_enqueue_style( self::PREFIX . 'zozo-tab-css' );
            wp_enqueue_style( self::PREFIX . 'zozo-tab-flat-css' );
            wp_enqueue_style(self::PREFIX . 'colorpicker-css');
        }

		/**
		 * Creates the markup for the Dashboard page
		 */
		public function markup_dashboard_page() {

            WDW_Main::markup_settings_header();
			if ( current_user_can( WDW_Main::REQUIRED_CAPABILITY ) ) {

                $variables = array();

                echo self::render_template( 'global-settings/page-dashboard.php', $variables );
			}
            else {
				wp_die( 'Access denied.' );
			}
		}

        /**
         * Save Global Settings
         * */
        function save_global_settings()
        {
            $options = WDW_Main::$settings;

            $options['wdw_front_page'] = $_POST['wdw_front_page'];

            WDW_Settings::update_options($options);
            wp_redirect(add_query_arg('page', WDW_Dashboard::page_id , admin_url('admin.php')));
            add_notice( ' Save Settings Successfully.' , 'update' );

            exit;
        }


        /** Ajax module for save Global Settings */
        static public function ajax_save_global_settings(){

            $options = WDW_Main::$settings;

            if($_POST['wdw_front_page'] > 0){

                $post_info = get_post($_POST['wdw_front_page']);

                $post_info->post_content =  '[wdw-listing-list]';
                wp_update_post( $post_info );
                $options['wdw_front_page'] = $_POST['wdw_front_page'];

            }

            $options['wdw_taxonomy_slug'] = $_POST['wdw_taxonomy_slug'];
            $options['wdw_post_type_slug'] = $_POST['wdw_post_type_slug'];
            $options['wdw_use_google_map'] = $_POST['wdw_use_google_map'];

            $options['wdw_directory_label'] = $_POST['wdw_directory_label'];
            $options['wdw_directory_description'] = $_POST['wdw_directory_description'];

            $options['wdw_email_from_name'] = $_POST['wdw_email_from_name'];
            $options['wdw_email_from_email'] = $_POST['wdw_email_from_email'];
            $options['wdw_email_notification_email'] = $_POST['wdw_email_notification_email'];
            $options['wdw_email_toadmin_subject'] = $_POST['wdw_email_toadmin_subject'];
            $options['wdw_email_toadmin_body'] = $_POST['wdw_email_toadmin_body'];

            $options['wdw_email_toauthor_subject'] = $_POST['wdw_email_toauthor_subject'];
            $options['wdw_email_toauthor_body'] = $_POST['wdw_email_toauthor_body'];
            $options['wdw_email_public_subject'] = $_POST['wdw_email_public_subject'];
            $options['wdw_email_public_body'] = $_POST['wdw_email_public_body'];

            $options['wdw_submit_require_tos'] = $_POST['wdw_submit_require_tos'];
            $options['wdw_submit_terms_of_service'] = $_POST['wdw_submit_terms_of_service'];
            $options['wdw_submit_top_message'] = $_POST['wdw_submit_top_message'];
            $options['wdw_submit_success_message'] = $_POST['wdw_submit_success_message'];

            $options['wdw_author_linking'] = $_POST['wdw_author_linking'];
            WDW_Settings::update_options($options);

            die();
        }

        /**
         * Display box in add/edit post/page page to Show the Score
         * @global	$post	POST Object
         * @return 	void
         * @access 	public
         */
        function show_metabox_below() {
            global $post;

            $variables = array();
            $variables['wdw_post_id'] = $post->ID;

            $settings = get_post_meta( $post->ID , 'wdw-settings');

            if(isset($settings)){

                /** General Settings */
                $variables['wdw_listing_logo'] = $settings[0]['listing_logo'];

                $variables['wdw_listing_summary'] = $settings[0]['listing_summary'];
                $variables['wdw_listing_email'] = $settings[0]['listing_email'];
                $variables['wdw_listing_phone'] = $settings[0]['listing_phone'];
                $variables['wdw_listing_fax'] = $settings[0]['listing_fax'];

                $variables['wdw_listing_website'] = $settings[0]['listing_website'];
                $variables['wdw_listing_facebook'] = $settings[0]['listing_facebook'];
                $variables['wdw_listing_twitter'] = $settings[0]['listing_twitter'];
                $variables['wdw_listing_address'] = $settings[0]['listing_address'];
                $variables['wdw_listing_zipcode'] = $settings[0]['listing_zipcode'];
                $variables['wdw_listing_lat'] = $settings[0]['listing_lat'];
                $variables['wdw_listing_lng'] = $settings[0]['listing_lng'];
                $variables['wdw_listing_country'] = $settings[0]['listing_country'];
                $variables['wdw_listing_rating'] = $settings[0]['listing_rating'];

                global $user_ID;
                $user_info = get_userdata($user_ID);
                $variables['wdw_post_author'] = $user_info->user_login;

            }

            self::enqueue_scripts();
            self::enqueue_styles();
            echo self::render_template( 'global-settings/page-metabox-below.php', $variables );
        }


        function show_metabox() {
            global $post;
            $variables = array();
            $variables['wdw_post_id'] = $post->ID;
            echo self::render_template( 'global-settings/page-metabox.php', $variables );
        }

        /** Ajax module for analysis */

        static public function ajax_save_listing_settings() {
            $post_id = $_POST['post_id'];
            $listing_logo = $_POST['listing_logo'];

            $listing_email = $_POST['listing_email'];
            $listing_phone = $_POST['listing_phone'];
            $listing_fax = $_POST['listing_fax'];

            $settings = array();
            $settings['listing_logo'] = $listing_logo;

            $settings['listing_email'] = $listing_email;
            $settings['listing_phone'] = $listing_phone;
            $settings['listing_fax'] = $listing_fax;

            $settings['listing_website'] = $_POST['listing_website'];
            $settings['listing_facebook'] = $_POST['listing_facebook'];
            $settings['listing_twitter'] = $_POST['listing_twitter'];
            $settings['listing_address'] = $_POST['listing_address'];
            $settings['listing_zipcode'] = $_POST['listing_zipcode'];
            $settings['listing_lat'] = $_POST['listing_lat'];
            $settings['listing_lng'] = $_POST['listing_lng'];
            $settings['listing_country'] = $_POST['listing_country'];
            $settings['listing_author'] = $_POST['listing_author'];
            $settings['listing_summary'] = $_POST['listing_summary'];
            $settings['listing_rating'] = $_POST['listing_rating'];
            $settings['listing_refs'] = 1;

            update_post_meta($post_id, 'wdw-settings', $settings);

            die();

        }

        static public function ajax_set_support_link(){
            $options = WDW_Main::$settings;
            $options['wdw_author_linking'] = '1';

            WDW_Settings::update_options($options);


            die();
        }

        static public function ajax_set_support_time(){
            $options = WDW_Main::$settings;
            $options['wdw_initial_dt'] = time();
            WDW_Settings::update_options($options);

            die();
        }

    } // end WDW_Dashboard
}
