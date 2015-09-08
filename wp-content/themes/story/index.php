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
<div class="post-list-block">
    <div class="post-block">
        <div class="post-image">
            <img src="<?php echo get_template_directory_uri(); ?>/images/block-image1.jpg">
        </div>
        <div class="post-short-text">
            <h3>Who we are</h3>
            After twelve years of delivering arts integration programming in the mid-atlantic region, around the US, in Canada, Brazil and other locations around the world, we are so excited to now operate as a 501-c-3 not-for-profit.  
        </div>
        <a href="#" class="link-button">Read more</a>
    </div>
    <div class="post-block">
        <div class="post-image">
            <img src="<?php echo get_template_directory_uri(); ?>/images/block-image2.jpg">
        </div>
        <div class="post-short-text">
            <h3>Our mission</h3>
            Exposing the community, nationally and internationally to the concept of arts integration as a multi-faceted arts approach that seeks to affect all aspects of our life on a daily basis.  Arts Integration as taught by Story Tapestries serves to develop the total person, social-emotional, intellectual and physical.
        </div>
        <a href="#" class="link-button">Read more</a>
    </div>
    <div class="post-block">
        <div class="post-image">
            <img src="<?php echo get_template_directory_uri(); ?>/images/block-image3.jpg">
        </div>
        <div class="post-short-text">
            <h3>What we do</h3>
            <b>To carry out our mission and vision, we are:</b><br>
            <ul>
                <li>Delivering customized arts integration programs to meet the individual needs of our communities</li>
                <li>Increasing our network of people who have had the training and resources to carry out our mission/vision</li>
            </ul>
        </div>
        <a href="#" class="link-button">Read more</a>
    </div>
    <div class="post-block">
        <div class="post-image">
            <img src="<?php echo get_template_directory_uri(); ?>/images/block-image4.jpg">
        </div>
        <div class="post-short-text">
            <h3>Howe we are growing</h3>
            <ul>
                <li>Providing arts integrated performances and/or training for more children and adults each year</li>
                <li>Strengthening and supporting community development in educational institutions, museums, centers, and businesses through performances, workshops and residencies</li>
            </ul>
        </div>
        <a href="#" class="link-button">Read more</a>
    </div>
</div>
<div class="galary-block">
    <div class="galary-title"></div>
    <div class="wppa_holder">
        <?php echo do_shortcode('[wppa type="cover" album="1.2.4.5" size="564" align="center"]Any comment[/wppa]'); ?>
    </div>
</div>
<div class="contact-block">
    <div class="contact-wrapper">
        <div class="left-block">
            <img src="<?php echo get_template_directory_uri(); ?>/images/contact-block-image.jpg">
        </div>
        <div class="right-block">
            <div class="text-holder">
                <h3>Contact us</h3>
                <div><span class="icon icon-email"></span><a href="mailto:administrator@storytapestries.com">administrator@storytapestries.com</a></div>
                <div><span class="icon icon-phone"></span>301-916-6328</div>
        
                <p>
                If you would like to contribute to bring arts integration programming to help us fulfill our mission, or to specify a particular age group, region, or community group that you'd like to support, you can use the “Donate” button that appears at the top of this page, or donations can be made out to Story Tapestries, Inc. and mailed to: 
                </p>
                <div>
                    <span class="icon icon-point" ></span>13641 Winterspoon Lane<br>
                    <span class="icon"></span>Germantown, MD 20874
                </div>
            </div>
        </div>
    </div>
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
