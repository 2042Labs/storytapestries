<?php
/*
Plugin Name: Directory Wizard
Plugin URI: http://polldirectory.net/directory-plugin/
Description: Powerful and simple to use, add a directory of business or other organizations to your web site.
Version: 1.0.0
Author: Ioannis Knithou
Author URI: http://polldirectory.net/

LICENSE
    Copyright Ioannis Knithou  (email : parpaitas1987@yahoo.com)
*/

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Access denied.' );
}

define( 'WDW_NAME',  'WP Directory Wizard' );
define( 'WDW_REQUIRED_PHP_VERSION', '5.3' );
define( 'WDW_REQUIRED_WP_VERSION',  '3.1' );

// Include Files
    $files = array(
        '/classes/wp-module',
        '/classes/wdw-main',
        '/classes/wdw-dashboard',
        '/classes/wdw-show',
        '/classes/wdw-setting',
        '/includes/admin-notice-helper/admin-notice-helper',
        '/lib/bootstrap'
    );

    foreach ($files as $file) {
        require_once __DIR__.$file.'.php';
    }

// Init Plugin
    if ( class_exists( 'WDW_Main' ) ) {

        $GLOBALS['wp-directory-wizard'] = WDW_Main::get_instance();
        register_activation_hook(   __FILE__, array( $GLOBALS['wp-directory-wizard'], 'activate' ) );
        register_deactivation_hook( __FILE__, array( $GLOBALS['wp-directory-wizard'], 'deactivate' ) );
    }
