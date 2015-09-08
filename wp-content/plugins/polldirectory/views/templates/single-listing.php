<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function ($) {
        initialize();
    });
</script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">

    function initialize() {
        <?php
        $settings1 = get_post_meta( get_the_ID(), 'wdw-settings' );
        ?>
        var lat = <?php echo $settings1[0]['listing_lat'] != '' ? $settings1[0]['listing_lat'] : '0';?>;
        var lng = <?php echo $settings1[0]['listing_lng'] != '' ? $settings1[0]['listing_lng'] : '0';?>;

        if(lat == '0'){
            jQuery("#map_canvas").hide();
           return;
        }
        var mapLatLng = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            center: mapLatLng,
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            panControl: false
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

        var marker = new google.maps.Marker({
            position: mapLatLng,
            map: map,
            animation: google.maps.Animation.DROP
        });
    }

    function contact_form_click(obj)
    {
        var obj_id = jQuery(obj).attr('id');
        var post_id = obj_id.split("-").pop();


        var data = {
            action:'wdw_contact_form',
            post_id:post_id,
            contact_senders_name: jQuery('#wdw-senders_name').val(),
            contact_email: jQuery('#wdw-email').val(),
            contact_subject: jQuery('#wdw-subject').val(),
            contact_message: jQuery('#wdw-message').val()

        };

        jQuery.post(ajax_object.ajax_url, data, function(respond) {
            if(respond == '')
            {
                jQuery('#wdw-contact-form-error').show();
            }
            else{
                var previewBody = document.getElementById('wdw-contact-form-wrap');
                previewBody.innerHTML = respond;
            }

        });
    }
</script>


<style type="text/css">

    .wdw_header_main_view {
        float: left;
        width: 45%;
        padding-right: 10px;
    }
    .wdw_header_logo_view{
        float: left;
        width: 50%;
        height: 200px;
    }



</style>


<?php
get_header(); ?>
<div id="main-content" class="main-content">
<div id="primary" class="content-area">
	<div id="content"class="site-content"  role="main">


	<!-- Cycle through all posts -->
	<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>            


        <div class="entry-content">
    <div class="wdw_header_main_view">
        <!-- Display Title and Author Name -->
        <h1><?php the_title(); ?><br /></h1>
        <strong>Author: </strong>
        <?php
        $settings = get_post_meta( get_the_ID(), 'wdw-settings' );
        echo $settings[0]['listing_author'];
       ?>
       <br />
        <!-- Code from recipe 'Adding custom taxonomies for custom post types' -->
        <strong>Categories: </strong>
        <?php
            $book_types = wp_get_post_terms( get_the_ID(), "wdw_category" );
            if ( $book_types ) {
                $first_entry = true;
                for ( $i = 0; $i < count( $first_entry ); $i++ ) {
                    if ( $first_entry == false )
                        echo ", ";
                    echo $book_types[$i]->name;
                    $first_entry = false;
                }
            }
            else
                echo "None Assigned";
        ?><br />

        <strong>Clicks: </strong>
        <?php
        echo $settings[0]['listing_refs'];
        ?>
        <br />

        <strong>Added on: </strong>
        <?php
        echo get_the_date('', get_the_ID());
        ?>
        <br />

        <strong>Summary: </strong>
        <?php

        echo $settings[0]['listing_summary'];
        ?>
        <br />
    </div>
    <!-- Display featured image in right-aligned floating div -->
    <div class="wdw_header_logo_view">
         <img src="<?php echo $settings[0]['listing_logo'];?>" style="width:100%; height: 100%;">
    </div>
    </div>

	<!-- Display book review contents -->
	<div class="entry-content"><?php the_content(); ?></div>

    <div class="entry-content">
        <div style="border: 1px solid; border-radius: 6px; border-color: #adadad;padding-top: 10px;
        <?php
        if(trim($settings[0]['listing_phone']) =='' && trim($settings[0]['listing_fax']) =='' && trim($settings[0]['listing_address']) =='' && trim($settings[0]['listing_website']) =='' && trim($settings[0]['listing_facebook']) =='' && trim($settings[0]['listing_twitter']) =='')
        echo('display:none;');
        ?>">
          <ul class="fa-ul">
                <li style="<?php echo trim($settings[0]['listing_phone']) =='' ? 'display:none;' :'';?>"><i class="fa fa-phone fa-fw fa-li"></i><?php echo $settings[0]['listing_phone'];?></li>
                <li style="<?php echo trim($settings[0]['listing_fax']) =='' ? 'display:none;' :'';?>"><i class="fa fa-fax fa-fw fa-li"></i><?php echo $settings[0]['listing_fax'];?></li>
                <li style="<?php echo trim($settings[0]['listing_address']) =='' ? 'display:none;' :'';?>"><i class="fa fa-globe fa-fw fa-li"></i><?php echo $settings[0]['listing_address'];?>, <?php echo $settings[0]['listing_zipcode'];?>, <?php echo $settings[0]['listing_country'];?></li>
          </ul>
            <ul class="fa-ul">
              <li style="<?php echo trim($settings[0]['listing_website']) =='' ? 'display:none;' :'';?>"><i class="fa fa-link fa-lg fa-li"></i> <a href="<?php echo $settings[0]['listing_website'];?>"><?php echo $settings[0]['listing_website'];?></a></li>
                <li style="<?php echo trim($settings[0]['listing_facebook']) =='' ? 'display:none;' :'';?>"><i class="fa fa-facebook fa-lg fa-li"></i> <a href="<?php echo $settings[0]['listing_facebook'];?>"><?php echo $settings[0]['listing_facebook'];?></a></li>
                <li style="<?php echo trim($settings[0]['listing_twitter']) =='' ? 'display:none;' :'';?>"><i class="fa fa-twitter fa-lg fa-li"></i> <a href="<?php echo $settings[0]['listing_twitter'];?>"><?php echo $settings[0]['listing_twitter'];?></a></li>
            </ul>
        </div>
    </div>

        <div class="entry-content" style="<?php echo WDW_Main::$settings['wdw_use_google_map'] == '1' ? '':'display: none;'?>">
            <div id="map_canvas" style="border-radius:6px; width: 100%; height: 300px;">

            </div>

                <div style="margin-top: 15px; <?php echo trim($settings[0]['listing_email']) == '' ? 'display:none;' : '';?>">
                    <h3>What is this in regards to?</h3>

                    <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">


                    <div class="wdw-input-group">
                        <span class="wdw-input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                        <input id="wdw-senders_name" type="text" class="wdw-form-control" placeholder="User Name" required>
                    </div>


                    <div class="wdw-input-group">
                        <span class="wdw-input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                        <input id="wdw-email" name="email" type="email" class="wdw-form-control" placeholder="Email" required>
                    </div>

                    <div class="wdw-input-group">
                        <span class="wdw-input-group-addon"><i class="fa fa-bookmark fa-fw"></i></span>
                        <input id="wdw-subject" name="subject" type="text" class="wdw-form-control" placeholder="Subject" required>
                    </div>

                    <textarea id="wdw-message" name="message" class="wdw-form-control" rows="5" placeholder="Enter your message here." required></textarea>

                    <button id="wdw-contact-form-submit-<?php echo(get_the_ID());?>" class="wdw-Button" onclick="contact_form_click(this);">Send</button>

                    <div id="wdw-contact-form-error" style="display: none;">

                        <p>Please enter a valid contact information.</p>
                    </div>

                </div>

        </div>





    </article>

	<?php endwhile; ?>

	</div>
</div>

</div>
<?php get_footer(); ?>

<style type="text/css">
    .wdw-input-group {
        position: relative;
        display: table;
        border-collapse: separate;
    }
    .wdw-input-group-addon{
        padding: 6px 12px;
        font-size: 14px;
        font-weight: normal;
        line-height: 1;
        color: #555;
        text-align: center;
        background-color: #eee;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 1%;
        white-space: nowrap;
        vertical-align: middle;
        display: table-cell;
    }
    .wdw-input-group-addon:first-child {
        border-right: 0;
    }

    .wdw-form-control {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
        box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
        -webkit-transition: border-color ease-in-out 0.15s,box-shadow ease-in-out 0.15s;
        -o-transition: border-color ease-in-out 0.15s,box-shadow ease-in-out 0.15s;
        transition: border-color ease-in-out 0.15s,box-shadow ease-in-out 0.15s;
    }
    textarea.wdw-form-control {
        height: auto;
    }
    #wdw-contact-form-error {
        margin-top: 10px;
        background-color: #ffffe0;
        padding: 10px 20px 0px;
        border: 1px solid;
        border-color: #dcdcdc;
        border-radius: 3px;
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


        width: 100%;
    }

    .wdw-Button:hover  {
        color: #66A6CB;
        background-color: #FFF;
        border: 1px solid #66A6CB;
    }

</style>