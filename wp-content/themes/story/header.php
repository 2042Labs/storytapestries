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
        <form method="post">
            <input type="text" class="text subscribe" name="email" placeholder="Email">
            <input type="button" class="link-button subscribe" value="Subscribe">
        </form>
    </div>
</header>
<div class="menu_line" role="navigation">
    <?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
    <form class="search">
        <input type="text" class="text" name="s">
        <input type="button" class="link-button">
    </form>
</div>