<style>
    #wdw-notice-support-view{
        margin-top: 10px;
        padding: 10px 10px 10px 10px;
        border-color: rgba(0, 0, 0, 0.22);
        border-width: 1px;
        border-style: solid;
        border-radius: 2px;
        margin-left: 10px;
    }
    .wdw-support-click-common {
        display: inline;
        position: relative;
    }





</style>
<script>
    jQuery(document).ready(function(){
        jQuery( '#wdw-notice-support-close' ).click( function (event) {
            jQuery("#wdw-notice-support-view").hide();

            var data = {
                action:'wdw_set_support_time'
            };

            jQuery.post(ajax_object.ajax_url, data, function(respond) {

            });
            return false;
        } );

        jQuery( '#wdw-notice-support-click' ).click( function (event) {

                if(document.getElementById('wdw_author_linking'))        document.getElementById('wdw_author_linking').checked = true;

                var data = {
                    action:'wdw_set_support_link'
                };

                jQuery.post(ajax_object.ajax_url, data, function(respond) {
                    jQuery("#wdw_support_title_1").hide();
                    jQuery("#wdw_support_title_2").show();
                    jQuery("#wdw_support_title_3").hide();
                });

        } );

    });

</script>

<div class="updated" id="wdw-notice-save-view" style="display: none; margin-left: 10px;">
<p>Save Settings Successfully.</p>
</div>

<div class="updated" id="wdw-notice-support-view" style="<?php

    if(WDW_Main::$settings['wdw_author_linking'] == '0'){

        //if((time() - WDW_Main::$settings['wdw_initial_dt']) >= 24 * 60 * 60){
        if((time() - WDW_Main::$settings['wdw_initial_dt']) >= 1){

        }
        else{
            echo 'display: none;';
        }
    }
    else {
        echo 'display: none;';
    }

?>">

    <div class="wdw-support-click-title wdw-support-click-common" id="wdw_support_title_1">Thank you for using
        <a href="<?php  $url = admin_url();
        echo $url . 'edit.php?post_type=wdw_listing&page=wdw_listing_settings';?>">Directory Wizard Plugin</a>,  if you enjoy our plugin please activate the author link credit by clicking
        <a href="#" id="wdw-notice-support-click"> OK.</a>

    </div>
    <div class="wdw-support-click-title wdw-support-click-common" id="wdw_support_title_2" style="display: none;">Thank you for supporting our plugin, the link has been placed in your footer.</div>
    <div style="float: right;" id="wdw_support_title_3">
        <small><a href="#" id="wdw-notice-support-close"> Hide this Message</a> </small>
    </div>

</div>