<?php
/**
 * Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">.
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        wp_head();
    ?>
</head>

<body <?php body_class(); ?>>
<header class="header">
    <a href="/" class="logo"><img  src="<?php echo get_template_directory_uri()."/images/logo.png"; ?>"></a>
    <div class="subscribe_block">
        <?php echo do_shortcode('[simpleSubscribeForm]'); ?>
        <input type="button" onclick="jQuery('header #frm-subscriptionFront .subscribeButton').click();" class="link-button subscribe" value="Subscribe">
    </div>
</header>
<?php if (is_home()) : ?>
    <div class="home_header">
        <div class="left_block">
            <div>
                <img class="logo_image" src="<?php echo get_template_directory_uri(); ?>/images/logo-image.png">
            </div>
            <div class="slogan_holder">
                With <span class="orange">art</span>, understanding, 
                with <span class="orange">understanding</span>, community.
            </div>
            <a href="/donate" class="link-button">Donate</a>
        </div>
        <div class="slider_holder">
            <?php echo do_shortcode("[huge_it_slider id='1']"); ?>
        </div>
    </div>
<?php endif; ?>
<div class="menu_line" role="navigation">
    <?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary', 'depth' => 2 ) ); ?>
    <form class="search">
        <input type="text" class="text" name="s" placeholder="Search">
        <input type="button" class="link-button">
    </form>
</div>