
// Save settings for Global.
function save_global_settings()
{

    var data = {

        action:'wdw_save_global_settings',
        wdw_front_page  : jQuery('#wdw_front_page').val(),
        wdw_taxonomy_slug  : jQuery('#wdw_taxonomy_slug').val(),
        wdw_post_type_slug  : jQuery('#wdw_post_type_slug').val(),
        wdw_use_google_map  : jQuery('#wdw_use_google_map').attr('checked') ? '1' : '0',
        wdw_author_linking  : jQuery('#wdw_author_linking').attr('checked') ? '1' : '0',

        wdw_email_from_name  : jQuery('#wdw_email_from_name').val(),
        wdw_email_from_email  : jQuery('#wdw_email_from_email').val(),
        wdw_email_notification_email  : jQuery('#wdw_email_notification_email').val(),

        wdw_email_toadmin_subject  : jQuery('#wdw_email_toadmin_subject').val(),
        wdw_email_toadmin_body  : jQuery('#wdw_email_toadmin_body').val(),
        wdw_email_toauthor_subject  : jQuery('#wdw_email_toauthor_subject').val(),
        wdw_email_toauthor_body  : jQuery('#wdw_email_toauthor_body').val(),
        wdw_email_public_subject  : jQuery('#wdw_email_public_subject').val(),
        wdw_email_public_body  : jQuery('#wdw_email_public_body').val(),

        wdw_submit_require_tos  : jQuery('#wdw_submit_require_tos').attr('checked') ? '1' : '0',
        wdw_submit_terms_of_service  : jQuery('#wdw_submit_terms_of_service').val(),
        wdw_submit_top_message  : jQuery('#wdw_submit_top_message').val(),
        wdw_submit_success_message  : jQuery('#wdw_submit_success_message').val(),
        wdw_directory_label  : jQuery('#wdw_directory_label').val(),
        wdw_directory_description  : jQuery('#wdw_directory_description').val()


    };

    jQuery.post(ajax_object.ajax_url, data, function(respond) {

        jQuery("#wdw-notice-save-view").show();
    });

    if(jQuery('#wdw_author_linking').attr('checked')){

        var dataLink = {
            action  : 'wdw_set_support_link'
        };

        jQuery.post(ajax_object.ajax_url, dataLink, function(respond) {
            jQuery("#wdw_support_title_1").hide();
            jQuery("#wdw_support_title_2").show();
            jQuery("#wdw_support_title_3").hide();
        });
    }
}

// Save settings for Post.
function save_listing_settings()
{
    var post_id = jQuery('#wdw-post-id').text();

    var data = {
        action:'wdw_save_listing_settings',
        post_id: post_id,
        listing_logo  : jQuery('#wdw-logo-111-path').val(),
        listing_author  : jQuery('#wdw_listing_author').val(),

        listing_summary : jQuery('#wdw_listing_summary').val(),

        listing_email : jQuery('#wdw_listing_email').val(),
        listing_phone : jQuery('#wdw_listing_phone').val(),
        listing_fax : jQuery('#wdw_listing_fax').val(),

        listing_website : jQuery('#wdw_listing_website').val(),
        listing_facebook : jQuery('#wdw_listing_facebook').val(),
        listing_twitter : jQuery('#wdw_listing_twitter').val(),

        listing_lat : jQuery('#wdw_listing_lat').val(),
        listing_lng : jQuery('#wdw_listing_lng').val(),

        listing_address : jQuery('#wdw_listing_address').val(),
        listing_zipcode : jQuery('#wdw_listing_zipcode').val(),
        listing_country : jQuery('#wdw_listing_country').val(),
        listing_rating : jQuery( "#wdw_listing_rating option:selected" ).val()


    };

    jQuery.post(ajax_object.ajax_url, data, function(respond) {

    });

}


function show_directory_click(obj)
{
    var obj_id = jQuery(obj).attr('id');
    var post_id = obj_id.split("-").pop();
    var url_page = jQuery('#wdw-navbar-' + post_id + '-url').val();
    window.location.href = url_page;
}

function view_listing_click(obj)
{
    var obj_id = jQuery(obj).attr('id');
    var post_id = obj_id.split("-").pop();
    var url_page = jQuery('#wdw-navbar-view-' + post_id + '-url').val();
    window.location.href = url_page;
}
function menu_submit_listing_click(obj)
{
    var obj_id = jQuery(obj).attr('id');
    var post_id = obj_id.split("-").pop();
    var url_page = jQuery('#wdw-navbar-submit-' + post_id + '-url').val();
    window.location.href = url_page;
}

// Show the LSI for the Page.
function show_page_lsi()
{

    jQuery("#wdw_lsi_view_loading").show();
    jQuery("#wdw-lsi-view").hide();

    var post_id = jQuery('#wdw-post-id').text();

    var lsi_data = {
        action:'wdw_get_lsi',
        post_id: post_id
    };

    jQuery.post(ajax_object.ajax_url, lsi_data, function(respond) {
        var previewBody = document.getElementById('wdw-lsi-view');
        previewBody.innerHTML = respond;
        jQuery("#wdw_lsi_view_loading").hide();
        jQuery("#wdw-lsi-view").show();

    });

}

// show message

function showMessage(message)
{
   // jQuery('#wdw_dialog_message').text(message);
    jQuery("#wdw_dialog").show();
   // jQuery('#dialog').dialog();
}
// Show the content for the Page.
function show_page_content()
{

}



function upload_image_to_category(obj)
{
    var custom_uploader;


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


        jQuery('#wdw_Cat_meta').val(attachment.url);

    });

    //Open the uploader dialog
    custom_uploader.open();
}



function register_new_user(obj)
{
    var wdw_user_email = jQuery('#wdw_user_email').val();
    if(!validEmail(wdw_user_email)){
        alert('invalid email');
    }

    return;
    var data = {
        action:'wdw_register_new_user',
        wdw_user_email  : wdw_user_email

    };

    jQuery.post(ajax_object.ajax_url, data, function(respond) {
        alert(respond);

    });
}

function validEmail(v) {
    var r = new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
    return (v.match(r) == null) ? false : true;
}


function visit_listing(page_id) {
    var data = {
        action:'wdw_visit_listing',
        page_id: page_id
    };

    jQuery.post(ajax_object.ajax_url, data, function(respond) {

    });
}