<style type="text/css">
    .site-content .entry-content{
        max-width: 100%;
    }
    .wdw_category_view{
        border: 0px solid #dcdcdc;
        margin-top: 10px;
        width: 32%;
        float: left;
        height: 60px;
    }
    .wdw_category_view_top{
        border: 0px solid #dcdcdc;

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
    .wdw_directories_view {
        width: 100%;
    }

</style>

<style type="text/css">
    @media (max-width: 640px) and (min-width: 100px) {
        .wdw_category_view{
            width: 49.5%;
            height: 80px;
        }
    }
</style>


<div class="wdw_directories_view">
    <?php
    if(count($wdw_categories) != 0) {
        foreach ($wdw_categories as $category) {

            if($category['parent'] == '0'){

                $cat_meta = get_option('wdw_category_' . $category['id']);

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
                               <a href="<?php echo $category['link'];?>&cat_id=<?php echo($category['id']);?>" style="text-decoration: none;color: rgb(29, 80, 10);" >
                                   <b><?php echo $category['name'];?></b></a>
                               <span style="display: none;"> - <?php echo $category['count'];?></span>
                           </div>
                        </div>
                    </div>

                    <div class="wdw_category_view_bottom">
                        <?php
                        $index = 0;
                            foreach ($wdw_categories as $sub_category) {

                                if($sub_category['parent'] == $category['id']){

                                    if($index == 0){
                                        $sub_name = $sub_category['name'];
                                    }
                                    elseif($index == 1){
                                        $sub_name = ', ' . $sub_category['name'];
                                    }
                                    elseif($index == 2){
                                        $sub_name = ', ' . $sub_category['name'] . '...';
                                    }
                                    else
                                        break;

                                    $index ++;
                                    ?>

                                    <a href="<?php echo $sub_category['link'];?>&cat_id=<?php echo($sub_category['id']);?>" style="text-decoration: none;color: rgb(29, 80, 10);" >
                                        <?php echo $sub_name;?></a>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>

                <?php
            }
        }
    }
    else{
    ?>

    <style>
        .wdw_category_view_bottom_error {
            border: 1px solid red;
            background-color: #F1EAE4;
            padding: 10px;
        }
    </style>
    <div class="wdw_category_view" style="width: 100%;height: 200px;">
        <div class="wdw_category_view_bottom_error">
            There are no categories assigned to the WP Directory yet.
            You need to assign some categories to the the WP Directory.
            Only admins can see this message. Regular users are seeing a message that there are currently no listings in the directory.
            Listings cannot be added until you assign categories to the WP Directory. <a href="<?php  $url = admin_url();
            echo $url . 'edit-tags.php?taxonomy=wdw_category&post_type=wdw_listing';?>">Click here to create a categories...</a>
        </div>

    </div>
    <?php
    }
    ?>

</div>


