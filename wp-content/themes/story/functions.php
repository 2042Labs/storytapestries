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

    /*
     * We'll be using post thumbnails for custom header images on posts and pages.
     * We want them to be 940 pixels wide by 198 pixels tall.
     * Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
     */
    //set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

    // ... and thus ends the custom header business.
     
}

function story_widgets_init() {
    // Area 1, located at the top of the sidebar.
    register_sidebar( array(
        'name' => __( 'Primary Widget Area', 'story' ),
        'id' => 'primary-widget-area',
        'description' => __( 'Add widgets here to appear in your sidebar.', 'twentyten' ),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

}

add_action( 'widgets_init', 'story_widgets_init' );

function story_scripts() {
    wp_enqueue_style( 'theme-styles', get_stylesheet_uri() );
    wp_enqueue_script( 'theme-scripts', get_template_directory_uri().'/js/main.js', array(), '1.0', false );
    //wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'story_scripts' );
