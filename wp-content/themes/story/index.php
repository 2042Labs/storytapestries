<?php
/**
 * Main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<div class="middle-banner">
    <img src="<?php echo get_template_directory_uri(); ?>/images/middle-banner.png">
</div>


<div class="footer-subscribe">
    <div class="textblock">
        <div class="text">Thank you for <span class="yellow">inspiring</span> me to remember how I used to teach</div>
        <div class="small-text">- Jen Flores, 1st Grade Teacher Barrett Elementary School, VA</div>
    </div>
    <div class="subscribe_block">
        <div class="form-holder">
            <div class="text">Stay in touch with us</div>
            <form method="post">
                <input type="text" placeholder="Email" name="email" class="text subscribe">
                <input type="button" value="Subscribe" class="link-button subscribe">
            </form>
        </div>
    </div>
</div>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>
