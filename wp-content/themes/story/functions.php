<?php

add_action( 'after_setup_theme', 'story_setup' );

function story_setup() {


    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary' => __( 'Primary Navigation', 'story' ),
        'footer' => __( 'Footer Navigation', 'story' ),
    ) );

    // This theme allows users to set a custom background.
    add_theme_support( 'custom-background', array(
        // Let WordPress know what our default background color is.
        'default-color' => 'f1f1f1',
    ) );

    // The custom header business starts here.
    
    $custom_header_support = array(
        /*
         * The default image to use.
         * The %s is a placeholder for the theme template directory URI.
         */
        'default-image' => '%s/images/headers/path.jpg',
        // The height and width of our custom header.
        /**
         * Filter the Twenty Ten default header image width.
         *
         * @since Twenty Ten 1.0
         *
         * @param int The default header image width in pixels. Default 940.
         */
        'width' => apply_filters( 'twentyten_header_image_width', 940 ),
        /**
         * Filter the Twenty Ten defaul header image height.
         *
         * @since Twenty Ten 1.0
         *
         * @param int The default header image height in pixels. Default 198.
         */
        'height' => apply_filters( 'twentyten_header_image_height', 198 ),
        // Support flexible heights.
        'flex-height' => true,
        // Don't support text inside the header image.
        'header-text' => false,
        // Callback for styling the header preview in the admin.
        'admin-head-callback' => 'twentyten_admin_header_style',
    );
    
   /*
    add_theme_support( 'custom-header', $custom_header_support );

    if ( ! function_exists( 'get_custom_header' ) ) {
        // This is all for compatibility with versions of WordPress prior to 3.4.
        define( 'HEADER_TEXTCOLOR', '' );
        define( 'NO_HEADER_TEXT', true );
        define( 'HEADER_IMAGE', $custom_header_support['default-image'] );
        define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
        define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
        add_custom_image_header( '', $custom_header_support['admin-head-callback'] );
        add_custom_background();
    }
    */
    /*
     * We'll be using post thumbnails for custom header images on posts and pages.
     * We want them to be 940 pixels wide by 198 pixels tall.
     * Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
     */
    //set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

    // ... and thus ends the custom header business.
     
}

function story_scripts() {
    wp_enqueue_style( 'style-name', get_stylesheet_uri() );
    //wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'story_scripts' );
