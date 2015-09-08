<?php

if ( ! class_exists( 'WDW_Settings' ) ) {

    /**
     *
     */
    class WDW_Settings{

        /**
         * The name for plugin options
         *
         * @var string
         */
        static $global_option = 'DirectoryWizard_Options';

        /**
         * Updates the General Settings of Plugin
         *
         * @return void
         * @access public
         */
        static function update_options($options) {
            // Save Class variable
            WDW_Main::$settings = $options;

            return update_option(self::$global_option, $options);
        }

        static function delete_options() {
           return delete_option(self::$global_option);
        }



        /**
         * Return the General Settings of Plugin, and set them to default values if they are empty
         *
         * @return array general options of plugin
         * @access public
         */
        static function get_options() {

            // If isn't empty, return class variable
            if (WDW_Main::$settings) {
                return WDW_Main::$settings;
            }

            // default values
            $options = array
            (
                'wdw_front_page' => 0,
                'wdw_global_setting_page_id' => 0,
                'category_id' => 0,
                'wdw_search_keyword' => '',
                'wdw_taxonomy_slug' =>'category',
                'wdw_post_type_slug' => 'tag',
                'wdw_email_from_name' => get_bloginfo('name'),
                'wdw_email_from_email' => get_bloginfo('admin_email'),
                'wdw_email_notification_email' => get_bloginfo('admin_email'),
                'wdw_email_toadmin_subject' => 'A new listing has been submitted for review!',
                'wdw_email_toadmin_body' => 'A new listing is pending review!' . "\n\n" . 'This submission is awaiting approval. Please visit the link to view and approve the new listing:' . "\n\n{approve_link}\n\n" . 'Listing Name:' . " {title}\n" . 'Listing Description:' . " {description}\n\n*****************************************\n" . 'This is an automated message from' . " {site_title}\n" . 'Please do not respond directly to this email' . "\n\n",
                'wdw_email_toauthor_subject' => sprintf('Your listing on %s is pending review!', get_bloginfo('name')),
                'wdw_email_toauthor_body' =>  'Thank you for submitting a listing to' . " {site_title}!\n\n" . 'Your listing is pending approval.' . "\n\n" . 'Please review the following information for accuracy, as this is what will appear on our web site. If you see any errors, please contact us immediately at' . " {directory_email}.\n\n" .'Listing Name:' . " {title}\n" . 'Listing Description:' . " {description}\n\n*****************************************\n" . 'This is an automated message from' . " {site_title}\n" . 'Please do not respond directly to this email' . "\n\n",
                'wdw_email_public_subject' => sprintf('Your listing on %s has been approved!', get_bloginfo('name')),
                'wdw_email_public_body' =>'Thank you for submitting a listing to' . " {site_title}!\n\n" . 'Your listing has been approved! You can now view it online:' . "\n\n{link}\n\n*****************************************\n" . 'This is an automated message from' . " {site_title}\n" . 'Please do not respond directly to this email' . "\n\n",

                'wdw_submit_terms_of_service' => 'Welcome!',
                'wdw_submit_top_message' => '<p>' . 'Please tell us a little bit about the organization you would like to see listed in our directory. Try to include as much information as you can, and be as descriptive as possible where asked.' . '</p>',
                'wdw_submit_success_message' => '<h3>' . 'Congratulations!' . '</h3><p>' . 'Your listing has been successfully submitted for review. Please allow us sufficient time to review the listing and approve it for public display in our directory.' . '</p>',
                'wdw_submit_require_tos' => '0',
                'wdw_use_google_map' => '1',
                'wdw_directory_label' => 'Welcome!',
                'wdw_directory_description' => '',
                'wdw_author_linking' => '0',

            );

            // get saved options
            $saved = get_option(self::$global_option);

            // assign them
            if (!empty($saved)) {
                foreach ($saved as $key => $option) {
                    $options[$key] = $option;
                }
            }

            // update the options if necessary
            if ($saved != $options) {
                update_option(self::$global_option, $options);
            }

            // Save class variable
            WDW_Main::$settings = $options;

            //return the options
            return $options;
        }

    } // end WDW_Settings
}
