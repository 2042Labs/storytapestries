<?php

if ( ! class_exists( 'WDW_Show' ) ) {

    /**
     * generate SEO info;
     */
    class WDW_Show extends WDW_Module {

        static $category_index;
        /**
         * Constructor
         */
        protected function __construct() {

            $this->register_hook_callbacks();
        }

        /**
         * Register callbacks for actions and filters
         */
        public function register_hook_callbacks() {

            /****************************************************************************
             * Code from recipe 'Displaying custom post type data in shortcodes'
             ****************************************************************************/

            add_filter( 'template_include', __CLASS__. '::wdw_template_include', 1 );

            /****************************************************************************
             * Code from recipe 'Displaying custom post type data in shortcodes'
             ****************************************************************************/

            add_shortcode( 'wdw-listing-list', __CLASS__. '::wdw_listing_list' );
            add_filter( 'posts_where', __CLASS__. '::wdw_set_search_keyword', 10, 2 );
            add_action('wp_footer', __CLASS__. '::fake_wp_footer' );

            return;


            // Add filter for POST content
            add_filter('the_content', __CLASS__. '::filter_post_content', 1, 2);
            // Add filter for POST title
            add_filter('the_title', __CLASS__. '::filter_post_title', 1, 2);

        }


        function wdw_set_search_keyword( $where, &$wp_query ) {

            global $wpdb;
            if ( trim(WDW_Main::$settings['wdw_search_keyword']) != '' ) {
                $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql(  WDW_Main::$settings['wdw_search_keyword'] ) . '%\'';
            }

            return $where;
        }


        function wdw_template_include( $template_path ){

            if ( get_post_type() == 'wdw_listing' ) {
                if ( is_single() ) {
                    // checks if the file exists in the theme first,
                    // otherwise serve the file from the plugin
                    if ( $theme_file = locate_template( array( 'single-listing.php' ) ) ) {
                        $template_path = $theme_file;
                    } else {
                        $template_path = dirname(plugin_dir_path( __FILE__ )) . '/views/templates/single-listing.php';
                    }
                } elseif ( is_archive() ) {
                    if ( $theme_file = locate_template( array( 'archive-listing.php' ) ) ) {
                        $template_path = $theme_file;
                    } else {
                        $template_path = dirname(plugin_dir_path( __FILE__ )) . '/views/templates/archive-listing.php';
                    }
                }
            }

            return $template_path;
        }

        // Implementation of short code function
        function wdw_listing_list() {

            global $post;
            $postID = $post->ID;
            $post_action = $_GET['action'];

            global $user_ID;
            $user_info = get_userdata($user_ID);

            // Show navigation bar
            $variables = array();
            $variables['wdw_post_id'] = $postID;
            echo self::render_template( 'global-settings/page-navbar.php', $variables );


            if(!is_user_logged_in() && trim($post_action) !=''){
                $variables['wdw_post_id'] = $postID;
                $variables['wdw_post_action'] = $post_action;

                echo self::render_template( 'global-settings/page-login.php', $variables );
                return;
            }

                if($post_action == 'viewlistings'){

                    $variables = array();

                    echo self::render_template( 'global-settings/page-view-listing.php', $variables );

                }
                else if($post_action == 'submitlisting'){

                    $variables = array();
                    $variables['wdw_post_id'] = $postID;
                    $variables['wdw_post_author'] = $user_info->user_login;

                    echo self::render_template( 'global-settings/page-submit-listing.php', $variables );

                }
                else if($post_action == 'search'){

                    $variables = array();
                    $variables['wdw_post_id'] = $postID;
                    $variables['wdw_post_author'] = $user_info->user_login;
                    $variables['wdw_search_keyword'] = $_GET['q'];
                    echo self::render_template( 'global-settings/page-search-listing.php', $variables );

                }
                else{

                    $options = WDW_Main::$settings;
                    $options['wdw_global_setting_page_id'] = $postID;
                    WDW_Settings::update_options($options);

                    self::$category_index = 1;
                    $categories = self::get_all_categories(0);

                    $variables = array();
                    $variables['wdw_post_id'] = $postID;
                    $variables['wdw_post_author'] = $user_info->user_login;
                    $variables['wdw_categories'] = $categories;
                    echo self::render_template( 'global-settings/page-directory-listing.php', $variables );

                }

        }

        function get_all_categories( $parent)  {

            $categories = array();
            $terms = get_terms('wdw_category', array( 'hide_empty' => true, 'parent' => $parent ));
            if(count($terms) == 0) {
                self::$category_index--;
                return $categories;
            }

            foreach ($terms as $category) {
                $term_link = get_term_link($category);

                $categories[] = array(
                    'link' => $term_link,
                    'name' => $category->name,
                    'count' => $category->count,
                    'index' => self::$category_index,
                    'parent' => $parent,
                    'id' =>$category->term_id
                );

                self::$category_index++;
                $m_terms = self::get_all_categories( $category->term_id);

                foreach ($m_terms as $category_1) {
                    $categories[] = $category_1;
                }
             }

            self::$category_index--;
            return $categories;
        }

        /**
         * hook wp_footer
         */
        public function fake_wp_footer() {
            // Only to add the head in Single page where Post is shown
            if (is_single() || is_page()) {
                $post_id = get_the_ID();

                //$settings = get_post_meta( $post_id , 'wdw-settings');

                /*
                 * Add Twitter meta data
                 */
                if (WDW_Main::$settings['wdw_author_linking'] == '1') {
                    echo '<div style="z-index:999999;text-align: center;">Directory Wizard powered by <a href="http://www.polldirectory.net">www.polldirectory.net</a></div>' . "\n";
                }
            }
        }

        /**
         *
         * Filter the POST content
         *
         */
        function filter_post_content($content,$post_id='') {
            // Only filter if is Single Page
            if (!((is_single()  || is_page() ) && !is_feed())) {
                return $content;
            }

            if ($post_id=='') {
                global $post;
                $post_id = $post->ID;
            }

            if (!isset($post)) {
                $post = get_post($post_id);
            }

            $filtered_content = $content;

            $settings = get_post_meta( $post_id , 'wdw-settings');



            return $filtered_content;

        }

        function filter_post_title($title,$post_id='') {

            if ($post_id=='') {
                global $post;
                $post_id = $post->ID;
            }

            if (!isset($post)) {
                $post = get_post($post_id);
            }

            // Check if the filter must be applied
            if (WDW_Main::$settings['wdw_front_page'] != '1')
                return $title;

            if ($title=='')
                return 'no title';

            if ($post->post_status=='auto-draft' || $post->post_status=='trash'
                || $post->post_status=='inherit'
            ) {
                return $title;
            }

            $settings = get_post_meta( $post_id , 'wdw-settings');


            if(trim($settings[0]['keyword_value']) == '') return $title;

            $filtered_title = $title . ' | ' . $settings[0]['keyword_value'];


            // Changed for Headway Theme
            if (! isset ( $filtered_title ) || trim ( $filtered_title ) == '') {
                return $title;
            } else {
                return $filtered_title;
            }
        }

        // submit a listing
        static public function ajax_wdw_msg_submit_listing(){

            $listing_title = $_POST['listing_title'];
            $listing_category = $_POST['listing_category'];
            $listing_description = $_POST['listing_description'];


            if(trim($_POST['listing_title']) == '' || trim($_POST['listing_description']) == '' || trim($_POST['listing_summary']) == '')
            {
                $msg = array(
                    'state' => 2,
                    'message' => '<strong>We\'re sorry!</strong><br>Please provide valid Title, Description or Summary fields.',
                );

                echo json_encode($msg);
                die();
                return;
            }


            if(WDW_Main::$settings['wdw_submit_require_tos'] == 1 && $_POST['listing_agree'] == 0)
            {
                $msg = array(
                    'state' => 2,
                    'message' => '<strong>We\'re sorry!</strong><br>Please agree our terms of service.',
                );
                echo json_encode($msg);
                die();
                return;
            }

            $user_id = get_current_user_id();

            // Create post object
            $my_post = array(
                'post_title'    => $listing_title,
                'post_excerpt' => $_POST['listing_summary'],
                'post_type'     => 'wdw_listing',
                'post_status'   => 'pending',
                'post_content'  => $listing_description,
                'post_author'   => $user_id

            );

            // Insert the post into the database
            $post_id = wp_insert_post( $my_post );

            $category_ids = array();
            $category_ids[] = $listing_category;
            if (!is_wp_error($post_id)) {
                wp_set_object_terms( $post_id, $category_ids, 'wdw_category');
            }

            $settings = array();
            $settings['listing_logo'] = $_POST['listing_logo'];
            $settings['listing_author'] = $_POST['listing_author'];
            $settings['listing_summary'] = $_POST['listing_summary'];

            $settings['listing_email'] = $_POST['listing_email'];
            $settings['listing_phone'] = $_POST['listing_phone'];
            $settings['listing_fax'] = $_POST['listing_fax'];
            $settings['listing_website'] = $_POST['listing_website'];
            $settings['listing_facebook'] = $_POST['listing_facebook'];
            $settings['listing_twitter'] = $_POST['listing_twitter'];

            $settings['listing_address'] = $_POST['listing_address'];
            $settings['listing_zipcode'] = $_POST['listing_zipcode'];
            $settings['listing_country'] = $_POST['listing_country'];

            $settings['listing_lat'] = $_POST['listing_lat'];
            $settings['listing_lng'] = $_POST['listing_lng'];
            $settings['listing_rating'] = '5';
            $settings['listing_refs'] = 1;
            update_post_meta($post_id, 'wdw-settings', $settings);

            WDW_Main::wdw_notify_admin($settings, $post_id); // Notification of new listing
            WDW_Main::wdw_notify_author($settings); // Receipt of submission


            $msg = array(
                'state' => 1,
                'message' => WDW_Main::$settings['wdw_submit_success_message'],
            );

            echo json_encode($msg);

            die();

        }

        static public function ajax_wdw_click_main_category(){
            $category_id = $_POST['category_id'];
            $options = WDW_Main::$settings;
            $options['category_id'] = $category_id;
            WDW_Settings::update_options($options);

            die();
        }


        static public function ajax_wdw_contact_form(){
            $contact_senders_name = $_POST['contact_senders_name'];
            $contact_email = $_POST['contact_email'];
            $contact_subject = $_POST['contact_subject'];
            $contact_message = $_POST['contact_message'];


            if(trim($contact_senders_name) == '' || trim($contact_email) == '' || trim($contact_subject) == ''){

                echo('');
                die();
            }
            else{

                $post_id = $_POST['post_id'];
                $settings = get_post_meta( $post_id , 'wdw-settings');
                $email = $settings[0]['listing_email'];
                $listing_title = get_the_title($post_id);

                $headers = sprintf("From: %s <%s>\r\n", $contact_senders_name, $contact_email);

                if (wp_mail($email, $contact_subject, $contact_message, $headers)) {
             //   if(wp_mail( 'kingstarspace7@gmail.com', 'The subject', 'The message' ) ){
                    $response = '<div style="background-color: #ffffe0; padding: 10px 20px 10px; border: 1px solid; border-color: #dcdcdc; border-radius: 3px;"><p>' . sprintf('Your message has been successfully sent to <em>%s</em>!', $listing_title) . '</p></div>';
                }
                else
                {
                    $response = '<div style="background-color: #ffffe0; padding: 10px 20px 10px; border: 1px solid; border-color: #dcdcdc; border-radius: 3px;"><p>There were unknown errors with your form submission.</p><p>Please wait a while and then try again.</p></div>';
                }

                echo ($response);
                die();
            }
        }

        static public function ajax_register_new_user(){

            $user_email = $_POST['wdw_user_email'];

            echo($user_email);

            die();
        }


        static public function ajax_wdw_visit_listing(){

            $post_id = $_POST['page_id'];
            $settings = get_post_meta( $post_id , 'wdw-settings');


            if(isset($settings)){

                $count = $settings[0]['listing_refs'];
                $count ++;
                $settings[0]['listing_refs'] = $count;
                update_post_meta($post_id, 'wdw-settings', $settings[0]);
            }
            die();
        }
    } // end WDW_Show
}
