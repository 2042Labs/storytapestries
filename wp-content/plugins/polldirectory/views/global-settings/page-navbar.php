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
        .wdw-navbar-1 {
            width: 100%;
        }
        .wdw-navbar-2 {
            width: 100%;
        }
    }

</style>

<div class="wdw-navbar-view" style="border: 0px solid #66A6CB; width: 100%; height: 60px;">
    <div class="wdw-navbar-1">
        <div class="wdw-href">
            <button id="wdw-navbar-<?php echo $wdw_post_id;?>" class="wdw-Button" style="padding: 0;width: 100%;" onclick="show_directory_click(this);">Directory</button>
            <input type="hidden" value="<?php echo home_url();?>/?page_id=<?php echo $wdw_post_id;?>" id="wdw-navbar-<?php echo $wdw_post_id;?>-url">
        </div>
        <div class="wdw-href">
            <button id="wdw-navbar-view-<?php echo $wdw_post_id;?>" class="wdw-Button" style="padding: 0;width: 100%;" onclick="view_listing_click(this);">View Listings</button>
            <input type="hidden" value="<?php echo home_url();?>/?page_id=<?php echo $wdw_post_id;?>&action=viewlistings" id="wdw-navbar-view-<?php echo $wdw_post_id;?>-url">
        </div>
        <div class="wdw-href">
            <button id="wdw-navbar-submit-<?php echo $wdw_post_id;?>" class="wdw-Button" style="padding: 0;width: 100%;" onclick="menu_submit_listing_click(this);">Submit a Listing</button>
            <input type="hidden" value="<?php echo home_url();?>/?page_id=<?php echo $wdw_post_id;?>&action=submitlisting" id="wdw-navbar-submit-<?php echo $wdw_post_id;?>-url">
        </div>
    </div>

    <div class="wdw-navbar-2">
        <form action="" method="GET" class="wdw-search-form">
            <input type="hidden" name="action" value="search">
            <input type="hidden" name="page_id" value="<?php echo $wdw_post_id;?>">

            <input name="q" type="text" value="" style="padding: 0;height: 27px; width: 50%;">
            <button type="submit" class="wdw-Button" style="padding: 0;width: 30%;">Search</button>
        </form>
    </div>

</div>


