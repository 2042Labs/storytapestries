<style type="text/css">

    .wdw_view_listing_class {
        border: 1px solid #dcdcdc;
        margin-top: 10px;padding: 10px;
        border-radius: 4px;
    }
    .wdw_view_listing_title h2 {
        color: rgb(73, 182, 202);
    }
    .wdw_view_listing_tags {
        margin-top: 15px;
        height: 20px;
    }
    .wdw_view_listing_tags_header {
        float: left;
        width: 40px;
        height: 100%;
    }
    .wdw_view_listing_tags_list {
        float: left;
        height: 100%;
        width: 80%;
        margin-top: 4px;
    }
    .wdw_view_listing_tags_list_item {
        border: 1px solid rgba(124, 121, 121, 0.57);
        border-radius: 3px;
        background-color: rgba(124, 121, 121, 0.57);
        text-align: center;
        color: white;
        float: left;
        margin-left: 3px;
        padding-left: 5px;
        padding-right: 5px;
        font-size: 11px;

    }

    .wdw_view_listing_property{
        border: 1px solid rgba(243, 240, 240, 1);
        border-radius: 3px;
        background-color: rgba(243, 240, 240, 1);
        margin-top: 15px;
        width: 100%;
        height: 23px;

    }
    .wdw_view_listing_property_list{
        float: left;
        height: 100%;
        color: rgb(73, 182, 202);
        font-size: 13px;
    }
</style>
<style type="text/css">

    .wdw-Button {
        display: inline-block;
        cursor: pointer;
        color: #FFF;
        background-color: #66A6CB ;

        text-align: center;
        text-decoration: none;
        border: 1px solid #FFF;
        border-radius: 6px;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        box-shadow: 0px 0px 2px #999;
        -moz-box-shadow: 0px 0px 2px #999;
        -webkit-box-shadow: 0px 0px 2px #999;

        height: 28px;
        width: 33.33%;
    }

    .wdw-Button:hover  {
        color: #66A6CB;
        background-color: #FFF;
        border: 1px solid #66A6CB;
    }

    .wdw_subcategory_list {
        width: 100%;
        display: inline-block;
    }

</style>
<style type="text/css">

    .wdw_category_view{
        border: 0px solid #dcdcdc;
        margin-top: 10px;
        width: 32%;
        float: left;
        height: 45px;
    }
    .wdw_category_view_top{
        border: 0px solid #dcdcdc;
        height: 30px;
        width: 98%;
        margin: 0%;

    }
    .wdw_category_view_bottom{
        border: 0px solid #dcdcdc;
        height: 25%;
        width: 98%;
        margin-top: 8px;
        font-size: 10px;

    }
    .wdw_category_view_top_img{
        float: left;
        width: 25px;
        height: 25px;

    }
    .wdw_category_view_top_title {
        height: 100%;
        vertical-align: middle;
        margin-left: 28px;
    }

</style>
<style type="text/css">
    .wdw-navbar-1,  .wdw-navbar-2  {
        float: left;
    }
    .site-content .entry-content{
        max-width: 100%;
    }
    .wdw-navbar-1 .wdw-href {
        float: left;
        width: 32%;
    }

    .wdw-navbar-1 {
        width: 60%;
    }
    .wdw-navbar-2 {
        width: 39%;
    }
</style>

<style type="text/css">
    @media (max-width: 640px) and (min-width: 100px) {
        .wdw_category_view{
            width: 49.5%;
            height: 80px;
        }
        .wdw-navbar-1 {
            width: 100%;
        }
        .wdw-navbar-2 {
            width: 100%;
        }
    }

</style>



<?php get_header(); ?>

<section id="primary" class="content-area" style="width: 90%;">
	<div id="content" class="site-content" role="main" style="height: 100%;">
        <?php if ( have_posts() ) : ?>

            <header class="entry-header">
                <h1 class="page-title"><?php echo($_GET['wdw_category']);?></h1>
            </header>
        <div class="entry-content" style="max-width: 90%;">

            <div class="wdw-navbar-view" style="border: 0px solid #66A6CB; width: 100%; height: 60px;">
                <div class="wdw-navbar-1">

                    <div class="wdw-href">
                        <button id="wdw-navbar-<?php echo(WDW_Main::$settings['wdw_global_setting_page_id']);?>" class="wdw-Button" style="padding: 0;width: 100%;" onclick="show_directory_click(this);">Directory</button>
                        <input type="hidden" value="<?php echo home_url();?>/?page_id=<?php echo(WDW_Main::$settings['wdw_global_setting_page_id']);?>" id="wdw-navbar-<?php echo(WDW_Main::$settings['wdw_global_setting_page_id']);?>-url">
                    </div>
                    <div class="wdw-href">
                        <button id="wdw-navbar-view-<?php echo(WDW_Main::$settings['wdw_global_setting_page_id']);?>" class="wdw-Button" style="padding: 0;width: 100%;" onclick="view_listing_click(this);">View Listings</button>
                        <input type="hidden" value="<?php echo home_url();?>/?page_id=<?php echo(WDW_Main::$settings['wdw_global_setting_page_id']);?>&action=viewlistings" id="wdw-navbar-view-<?php echo(WDW_Main::$settings['wdw_global_setting_page_id']);?>-url">
                    </div>
                    <div class="wdw-href">
                        <button id="wdw-navbar-submit-<?php echo(WDW_Main::$settings['wdw_global_setting_page_id']);?>" class="wdw-Button" style="padding: 0;width: 100%;" onclick="menu_submit_listing_click(this);">Submit a Listing</button>
                        <input type="hidden" value="<?php echo home_url();?>/?page_id=<?php echo(WDW_Main::$settings['wdw_global_setting_page_id']);?>&action=submitlisting" id="wdw-navbar-submit-<?php echo(WDW_Main::$settings['wdw_global_setting_page_id']);?>-url">
                    </div>


                </div>
                <div class="wdw-navbar-2">
                    <form action="" method="GET" class="wdw-search-form">
                        <input type="hidden" name="action" value="search">
                        <input type="hidden" name="page_id" value="<?php echo(WDW_Main::$settings['wdw_global_setting_page_id']);?>">

                        <input name="q" type="text" value="" style="padding: 0;height: 27px; width: 50%;">
                        <button type="submit" class="wdw-Button" style="padding: 0;width: 30%;">Search</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="entry-content" style="max-width: 90%;">

         <div class="wdw_subcategory_list">
             <?php

             $terms = get_terms('wdw_category', array( 'hide_empty' => true, 'parent' => $_GET['cat_id'] ));

             if(count($terms) != 0) {
                 foreach ($terms as $category) {
                     $term_link = get_term_link($category);
                     $cat_meta = get_option('wdw_category_' . $category->term_id);
                     ?>
                     <div class="wdw_category_view">
                         <div class="wdw_category_view_top">
                             <div class="wdw_category_view_top_img">
                                 <img src="<?php
                                 echo $cat_meta['img']? $cat_meta['img'] :(dirname(WDW_Main::$plugin_url) . '/img/icons/default.png');
                                 ?>" style="width:100%; height: 100%;">
                             </div>
                             <div class="wdw_category_view_top_title">
                                 <div style="margin-top: 2px;">
                                     <a href="<?php echo $term_link;?>&cat_id=<?php echo($category->term_id);?>" style="text-decoration: none;color: rgb(29, 80, 10);" >
                                         <b><?php echo $category->name;?></b></a>
                                     <span style="display: none;"> - <?php echo $category->count;?></span>
                                 </div>
                             </div>
                         </div>

                         <div class="wdw_category_view_bottom">
                             <?php
                             $sub_terms = get_terms('wdw_category', array( 'hide_empty' => true, 'parent' => $category->term_id ));

                             foreach ($sub_terms as $sub_category) {
                                 $sub_term_link = get_term_link($sub_category);
                                     ?>
                                     <a href="<?php echo $sub_term_link;?>&cat_id=<?php echo $sub_category->term_id;?>" style="text-decoration: none;color: rgb(29, 80, 10);" >
                                         <?php echo $sub_category->name;?></a>
                                 <?php
                             }
                             ?>

                         </div>
                     </div>
             <?php
                 }
             }
             ?>

         </div>

         <div class="wdw_subcategory_body">

		<!-- Start the Loop -->
		<?php while ( have_posts() ) : the_post();

            $settings = get_post_meta( get_the_ID(), 'wdw-settings' );


            $post_categories = get_the_terms( get_the_ID(), 'wdw_category' );
            $is_child_category = '0';

            foreach ( $post_categories as $view_category) {
                if($view_category->parent == $_GET['cat_id']) $is_child_category = '1';
            }

            ?>

            <div class="wdw_view_listing_class" style="<?php if($is_child_category) echo 'display: none;'?>">

                <div class="wdw_view_listing_title">
                    <a href="<?php echo(post_permalink());?>" style="text-decoration: none;" onclick="visit_listing(<?php echo get_the_ID();?>);">
                        <h2><?php echo get_the_title(get_the_ID());?></h2></a>

                </div>
                <div class="wdw_view_listing_rating">
                    <?php
                    $nb_stars = intval( $settings[0]['listing_rating']);
                    for ( $star_counter = 1; $star_counter <= 5; $star_counter++ ) {
                        if ( $star_counter <= $nb_stars )
                            echo "<img src='" .
                                plugins_url( "directory-wizard/views/templates/star-icon.png" ) .
                                "' width='24' />";
                        else
                            echo "<img src='" .
                                plugins_url( "directory-wizard/views/templates/star-icon-grey.png" ) .
                                "' width='24' />";
                    }
                    ?>
                </div>
                <div class="wdw_view_listing_summary">
                    <?php echo $settings[0]['listing_summary'];?>
                </div>

                <?php
                $term_list = wp_get_post_terms(get_the_ID(), 'wdw_tag', array("fields" => "all"));
                ?>

                <div class="wdw_view_listing_tags" style="<?php echo(count($term_list)>0 ? '' : 'display:none;');?>">

                    <div class="wdw_view_listing_tags_header">
                        Tags
                    </div>
                    <div class="wdw_view_listing_tags_list">
                        <?php

                        foreach ( $term_list as $tag ) {
                            ?>
                            <div class="wdw_view_listing_tags_list_item">
                                <a href="<?php echo get_term_link($tag); ?>&cat_id=<?php echo($tag->term_id);?>" style="text-decoration: none;color: white;top:0;">
                                    <?php echo($tag->name);?>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="wdw_view_listing_property">

                    <div class="wdw_view_listing_property_list">
                        <i class="fa fa-calendar fa-fw "></i> <?php echo get_the_date('', get_the_ID()); ?>
                    </div>

                </div>


            </div>


		<?php endwhile; ?>


        </div>
	<!-- Display page navigation -->
	<?php global $wp_query;
              if ( isset( $wp_query->max_num_pages ) && $wp_query->max_num_pages > 1 ) { ?>
			<nav id="<?php echo $nav_id; ?>">
				<div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span> Older listings'); ?></div>
				<div class="nav-next"><?php previous_posts_link( 'Newer listings <span class="meta-nav">&rarr;</span>' ); ?></div>
			</nav>
	<?php }; 
    
    endif; ?>

	</div>
</section>

<?php get_footer(); ?>