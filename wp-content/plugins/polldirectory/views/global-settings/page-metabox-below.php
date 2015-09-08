
<style>
    .z-tabs.nested-tabs > .z-container > .z-content > .z-content-inner {padding-top: 10px;}
</style>
<script>
    jQuery(document).ready(function ($) {
        /* jQuery activation and setting options for parent tabs with id selector*/
        $("#tabbed-nav").zozoTabs({
            rounded: false,
            multiline: true,
            theme: "white",
            size: "medium",
            responsive: true,
            animation: {
                effects: "slideH",
                easing: "easeInOutCirc",
                duration: 500
            },
            defaultTab: "tab1"
        });

        /* jQuery activation and setting options for all nested tabs with class selector*/
        $(".nested-tabs").zozoTabs({
            position: "top-left",
            theme: "red",
            style: "underlined",
            rounded: false,
            shadows: false,
            defaultTab: "tab1",
            animation: {
                easing: "easeInOutCirc",
                effects: "slideV",
                duration: 350
            },
            size: "medium"
        });

        $( "#wdw_event_date" ).datepicker(
                {
                    dateFormat: 'yy-mm-dd',
                    constrainInput: true
                }
            );
        jQuery("#dashboard-page-post").show();

        initialize();

        jQuery( '#wdw-notice-support-click-1' ).click( function (event) {

            if(document.getElementById('wdw_author_linking'))        document.getElementById('wdw_author_linking').checked = true;

            var data = {

                action:'wdw_set_support_link'

            };

            jQuery.post(ajax_object.ajax_url, data, function(respond) {

                jQuery("#wdw_support_title_1").hide();

                jQuery("#wdw_support_title_2").show();

                jQuery("#wdw_support_title_3").hide();

                jQuery("#wdw_support_title_1_1").hide();

            });

        } );



    });

</script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
    function initialize() {

        var lat = jQuery('#wdw_listing_lat').val();
        var lng = jQuery('#wdw_listing_lng').val();
        if(lat == '') {
            lat = 53.80583;
            lng = -1.548903;
        }

        var leeds = new google.maps.LatLng(lat, lng);

        var firstLatlng = new google.maps.LatLng(lat, lng);

        var firstOptions = {
            zoom: 8,
            center: firstLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById("wdw-map-canvas"), firstOptions);

        firstmarker = new google.maps.Marker({
            map:map,
            draggable:true,
            animation: google.maps.Animation.DROP,
            position: leeds
        });


        google.maps.event.addListener(firstmarker, 'drag', function () {

            jQuery('#wdw_listing_lat').val(firstmarker.getPosition().lat());
            jQuery('#wdw_listing_lng').val(firstmarker.getPosition().lng());

        });

    }
</script>



<script type="text/javascript">
    function upload_image(obj)
    {
        var custom_uploader;
        var obj_id = jQuery(obj).attr('id');

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();

            jQuery('#' + obj_id + ' img').attr('src',attachment.url);
            jQuery('#' + obj_id + '-path').val(attachment.url);

        });

        //Open the uploader dialog
        custom_uploader.open();
    }
</script>

<style>

    #wdw_support_title_1_1{

        margin-top: 10px;
        margin-bottom: 10px;

        padding: 10px 10px 10px 10px;

        border-color: rgba(0, 0, 0, 0.22);

        border-width: 1px;

        border-style: solid;

        border-radius: 2px;

        margin-left: 0px;

    }

</style>
<div id="dashboard-page-post" style="display: none; margin-right: 10px;">
    <span id="wdw-post-id" class="wdw-ui-hidden"><?php echo $wdw_post_id; ?></span>
    <input type="text" value="<?php echo($wdw_post_author);?>" id="wdw_listing_author" style="display: none;">


    <div id="wdw_support_title_1_1" style="<?php echo WDW_Main::$settings['wdw_author_linking'] == '1' ? 'display: none;':'';?>">
        Please support our plugin by clicking
        <a href="#" id="wdw-notice-support-click-1"> 'OK' </a>&nbsp;to enable our author link.

    </div>


        <!-- Zozo Tabs Start-->
        <div id="tabbed-nav">

            <!-- Tab Navigation Menu -->
            <ul>
                <li><a>General<span></span></a></li>
                <li><a>Contact<span></span></a></li>
                <li><a>Social<span></span></a></li>
               <li><a>Location<span></span></a></li>
            </ul>

            <!-- Content container -->
            <div>
                <!-- General Settings -->
                <div>

                    <div class="wdw-listing-settings">


                        <div class="form-group">
                            <label class="col-sm-3 control-label">Rating</label>
                            <div class="col-sm-9">
                                <label style="width: 100%;">
                                    <select style="width: 100px" id="wdw_listing_rating">
                                        <?php
                                        // Generate all items of drop-down list
                                        for ( $rating = 5; $rating >= 1; $rating -- ) {	?>
                                        <option value="<?php echo $rating; ?>" <?php echo selected( $rating, $wdw_listing_rating ); ?>><?php echo $rating; ?> stars
                                            <?php } ?>
                                    </select>
                                </label><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <div style="text-align: center; border-radius: 3px;
                             border: 1px solid;" id="wdw-logo-111" onclick="upload_image(this);">Logo</div></label>
                            <div class="col-sm-9">
                                <label style="width: 100%;">
                                    <input type="text" value="<?php echo($wdw_listing_logo);?>" id="wdw-logo-111-path" style="width: 100%;">
                                </label><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Summary</label>
                            <div class="col-sm-9">
                                <label style="width: 100%;">
                                    <textarea id="wdw_listing_summary" style="width: 100%;" class="form-control" rows="5"><?php echo($wdw_listing_summary);?></textarea>
                                </label><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Map</label>
                            <div class="col-sm-9">
                                <label style="width: 100%;">
                                    <input type="hidden" id="wdw_listing_lat" value="<?php echo $wdw_listing_lat==''? '53.80583': $wdw_listing_lat; ?>">
                                    <input type="hidden" id="wdw_listing_lng" value="<?php echo $wdw_listing_lng==''? '-1.548903': $wdw_listing_lng; ?>">
                                    <div id="wdw-map-canvas" style="height:300px;"></div>
                                </label><br>
                            </div>
                        </div>


                    </div>

                </div>

                <!-- Contact Settings -->
                <div>

                    <div class="wdw-listing-settings">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <label style="width: 100%;">
                                    <input type="text" id="wdw_listing_email" value="<?php echo $wdw_listing_email; ?>" style="width: 60%;">
                                </label><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Phone</label>
                            <div class="col-sm-9">
                                <label style="width: 100%;">
                                    <input type="text" id="wdw_listing_phone" value="<?php echo $wdw_listing_phone; ?>" style="width: 60%;">
                                </label><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Fax</label>
                            <div class="col-sm-9">
                                <label style="width: 100%;">
                                    <input type="text" id="wdw_listing_fax" value="<?php echo $wdw_listing_fax; ?>" style="width: 60%;">
                                </label><br>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Social Settings -->
                <div>

                    <div class="wdw-listing-settings">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Website</label>
                            <div class="col-sm-9">
                                <label style="width: 100%;">
                                    <input type="text" id="wdw_listing_website" value="<?php echo $wdw_listing_website; ?>" style="width: 60%;">
                                </label><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Facebook</label>
                            <div class="col-sm-9">
                                <label style="width: 100%;">
                                    <input type="text" id="wdw_listing_facebook" value="<?php echo $wdw_listing_facebook; ?>" style="width: 60%;">
                                </label><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Twitter</label>
                            <div class="col-sm-9">
                                <label style="width: 100%;">
                                    <input type="text" id="wdw_listing_twitter" value="<?php echo $wdw_listing_twitter; ?>" style="width: 60%;">
                                </label><br>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Location Settings -->
                <div>

                    <div class="wdw-listing-settings">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-9">
                                <label style="width: 100%;">
                                    <input type="text" id="wdw_listing_address" value="<?php echo $wdw_listing_address; ?>" style="width: 60%;">
                                </label><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Zip/Postal Code</label>
                            <div class="col-sm-9">
                                <label style="width: 100%;">
                                    <input type="text" id="wdw_listing_zipcode" value="<?php echo $wdw_listing_zipcode; ?>" style="width: 60%;">
                                </label><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Country</label>
                            <div class="col-sm-9">
                                <label style="width: 100%;">
                                    <input type="text" id="wdw_listing_country" value="<?php echo $wdw_listing_country; ?>" style="width: 60%;">
                                </label><br>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
        <!-- Zozo Tabs End-->
    <div class="wdw-global-save-view">
        <button type="button" class="btn btn-primary" onclick="save_listing_settings();" >Save Settings</button>
    </div>

</div>

