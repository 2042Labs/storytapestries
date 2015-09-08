<script>
    jQuery(document).ready(function ($) {
        initialize();
    });

</script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
    function initialize() {

        var lat = 53.80583;
        var lng = -1.548903;

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

            jQuery('#wdw_submit_lat').val(firstmarker.getPosition().lat());
            jQuery('#wdw_submit_lng').val(firstmarker.getPosition().lng());

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

    function submit_listing_click(obj)
    {
        var obj_id = jQuery(obj).attr('id');
        var url_page = jQuery('#' + obj_id + '-url').val();

        var submit_title = jQuery('#wdw_submit_title').val();
        var submit_category = jQuery( "#wdw_submit_category option:selected" ).text();
        var submit_logo = jQuery('#wdw-logo-111-path').val();
        var submit_description = jQuery('#wdw_submit_description').val();


        var data = {
            action:'wdw_msg_submit_listing',

            listing_author: jQuery('#wdw_submit_author').val(),

            listing_title: submit_title,
            listing_category: submit_category,
            listing_logo: submit_logo,
            listing_description: submit_description,
            listing_summary: jQuery('#wdw_submit_summary').val(),

            listing_email : jQuery('#wdw_submit_email').val(),
            listing_phone : jQuery('#wdw_submit_phone').val(),
            listing_fax : jQuery('#wdw_submit_fax').val(),

            listing_website : jQuery('#wdw_submit_website').val(),
            listing_facebook : jQuery('#wdw_submit_facebook').val(),
            listing_twitter : jQuery('#wdw_submit_twitter').val(),

            listing_lat : jQuery('#wdw_submit_lat').val(),
            listing_lng : jQuery('#wdw_submit_lng').val(),

            listing_address : jQuery('#wdw_submit_address').val(),
            listing_zipcode : jQuery('#wdw_submit_zipcode').val(),
            listing_country : jQuery('#wdw_submit_country').val(),
            listing_agree: jQuery('#wdw_submit_is_require').attr('checked') ? '1' : '0'

        };

        jQuery.post(ajax_object.ajax_url, data, function(respond) {


            var result = JSON.parse(respond);

            if(result["state"] == 1)
            {

                var previewBody = document.getElementById('wdw_submit_listing_alert_view');
                previewBody.innerHTML = result["message"];

                jQuery('#wdw_submit_listing_alert_view').show();
                jQuery('#wdw_submit_listing_content_view').hide();
                jQuery('#wdw_submit_listing_error_view').hide();
            }
            else if(result["state"] == 2)
            {
                var previewBody = document.getElementById('wdw_submit_listing_error_view');
                previewBody.innerHTML = result["message"];
                jQuery('#wdw_submit_listing_error_view').show();


            }
           // window.location.href = url_page;

        });
    }

</script>

<style type="text/css">

    .form-control {
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
    #wdw_submit_listing_error_view{
        border: 1px solid;
        padding:10px;
        background-color: #f2dede;
        border-color: #ebccd1;
        color: #a94442;
    }
</style>


<div id="wdw_submit_listing_view">
    <div id="wdw_submit_listing_alert_view" style="display: none;">

    </div>
    <div id="wdw_submit_listing_error_view" style="display: none;">

    </div>

    <div id="wdw_submit_listing_content_view">
    <div class="form-group">
        <p class="control-label"><?php echo(WDW_Main::$settings['wdw_submit_top_message']);?></p>
    </div>

    <div class="form-group">
        <label class="control-label">Title</label>
        <input type="text" id="wdw_submit_title" class="form-control" value="">
        <input type="text" value="<?php echo($wdw_post_author);?>" id="wdw_submit_author" style="display: none;">
    </div>

    <div class="form-group">
        <label class="control-label" for="f_category">Category</label>
        <select id="wdw_submit_category" class="form-control">
            <?php
            $terms = get_terms( 'wdw_category', array( 'hide_empty' => false, 'parent' => 0 ));
            foreach ($terms as $category) {
            ?>
                <option value="<?php echo $category->term_id;?>"><?php echo $category->name;?></option>
            <?php
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <div style="text-align: center; margin-top: 5px;border-radius: 3px; border: 1px solid; width: 110px;" id="wdw-logo-111" onclick="upload_image(this);">Upload Logo</div>
        <input type="text" value="" id="wdw-logo-111-path" style="float: left;width: 100%;padding: 0 0 0;margin-top: 10px;">
    </div>

    <div class="form-group">
        <label class="control-label" style="margin-top: 10px;">Description</label>
        <textarea id="wdw_submit_description" class="form-control" rows="5"></textarea>
    </div>

    <div class="form-group">
        <label class="control-label" for="">Summary</label>
        <input type="text" id="wdw_submit_summary" class="form-control" value="">
        <p class="help-block">Please provide a short summary of your listing that will appear in search results.</p>
    </div>

    <div class="form-group">
        <label class="control-label" for="">Email</label>
        <input type="text" id="wdw_submit_email" class="form-control" value="">
    </div>

    <div class="form-group">
        <label class="control-label" for="">Phone</label>
        <input type="text" id="wdw_submit_phone" class="form-control" value="">
    </div>

    <div class="form-group">
        <label class="control-label" for="">Fax</label>
        <input type="text" id="wdw_submit_fax" class="form-control" value="">
    </div>

    <div class="form-group">
        <label class="control-label" for="">Website</label>
        <input type="text" id="wdw_submit_website" class="form-control" value="">
    </div>

    <div class="form-group">
        <label class="control-label" for="">Facebook</label>
        <input type="text" id="wdw_submit_facebook" class="form-control" value="">
    </div>

    <div class="form-group">
        <label class="control-label" for="">Twitter</label>
        <input type="text" id="wdw_submit_twitter" class="form-control" value="">
    </div>

    <div class="form-group">
        <label class="control-label" for="">Address</label>
        <input type="text" id="wdw_submit_address" class="form-control" value="">
    </div>

    <div class="form-group">
        <label class="control-label" for="">Zip/Postal Code</label>
        <input type="text" id="wdw_submit_zipcode" class="form-control" value="">
    </div>

    <div class="form-group">
        <label class="control-label" for="">Country</label>
        <input type="text" id="wdw_submit_country" class="form-control" value="">
    </div>

    <div class="form-group">
        <label class="control-label" for="">Map</label>
        <input type="hidden" id="wdw_submit_lat" value="">
        <input type="hidden" id="wdw_submit_lng" value="">
        <div id="wdw-map-canvas" style="height:300px;"></div>
    </div>

    <div class="form-group" id="wdw_submit_tos_view" style="<?php echo(WDW_Main::$settings['wdw_submit_require_tos'] == '1' ? '': 'display:none;');?>">
        <textarea id="wdw_submit_tos" class="form-control" rows="5"><?php echo(WDW_Main::$settings['wdw_submit_terms_of_service']);?></textarea>
        <label>
            <input id="wdw_submit_is_require" type="checkbox"> By submitting, you agree your listing abides by our terms of service.<br>
        </label>
    </div>

    <div style="margin-top: 10px;">
        <button id="wdw-submit-button-<?php echo $wdw_post_id;?>" class="wdw-Button" style="padding: 0 0 0;" onclick="submit_listing_click(this);">Submit</button>
        <input type="hidden" value="<?php echo home_url();?>/?page_id=<?php echo $wdw_post_id;?>" id="wdw-submit-button-<?php echo $wdw_post_id;?>-url">
    </div>
</div>
</div>