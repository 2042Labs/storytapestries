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

<div id="wdw_search_directories_view">
    <?php

    global $wpdb;

    WDW_Main::$settings['wdw_search_keyword'] = $wdw_search_keyword;


    // Preparation of query array to retrieve 5 book reviews
    $query_params = array( 'post_type' => 'wdw_listing',
        'post_status' => 'publish',
        'posts_per_page' => 5 );

    // Retrieve page query variable, if present
    $page_num = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    // If page number is higher than 1, add to query array
    if ( $page_num != 1 )
        $query_params['paged'] = $page_num;

    // Execution of post query
    $book_review_query = new WP_Query;
    $book_review_query->query( $query_params );

    // Check if any posts were returned by query
    if ( $book_review_query->have_posts() ) {
        // Display posts in table layout


        // Cycle through all items retrieved
        while ( $book_review_query->have_posts() ) {
            $book_review_query->the_post();
            $settings = get_post_meta( get_the_ID(), 'wdw-settings' );
        ?>
            <div class="wdw_view_listing_class">

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

        <?php
        }


        // Display page navigation links
        if ( $book_review_query->max_num_pages > 1 ) {
            ?>
            <nav id="nav-below">
            <div class="nav-previous">
            <?php echo get_next_posts_link( '<span class="meta-nav">&larr;</span> Older listing', $book_review_query->max_num_pages );?>
            </div>
                <div class="nav-next"><?php echo get_previous_posts_link( 'Newer listings <span class="meta-nav">&rarr;</span>', $book_review_query->max_num_pages );?>
           </div>
            </nav>
        <?php
        }

        // Reset post data query
        wp_reset_query();
    }

    ?>
</div>
