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
        jQuery("#dashboard-page").show();
        jQuery("#wrap-right-side").show();

    });

</script>

<style type="text/css">
    #dashboard-page {
        display:none;
        float: left;
        margin-right: 0px;
        margin-top: 0px;
    }
</style>

<div id="dashboard-page" class="box-border-box col-md-9">

    <form action="admin-post.php" method="post" class="form-horizontal" role="form">
        <input type="hidden" name="action" value="wdw_global_settings" >
        <!-- Adding security through hidden referrer field -->
        <?php wp_nonce_field( 'wdw_global_settings' ); ?>
        <!-- Zozo Tabs Start-->
        <div id="tabbed-nav">
            <!-- Tab Navigation Menu -->
            <ul>
                <li><a>General<span></span></a></li>
                <li><a>Emails<span></span></a></li>
                <li><a>Submit<span></span></a></li>
             </ul>

            <!-- Content container -->
            <div>
                <!-- General -->
                <div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Front Page</label>
                        <div class="col-sm-9">
                            <label style="width: 100%;">

                                <select id="wdw_front_page">

                                    <option value="0"></option>
                                    <?php
                                    $pages = WDW_Main::get_all_pages();
                                    foreach($pages as $page)
                                    {
                                        ?>
                                        <option value="<?php echo $page->ID; ?>" <?php if (WDW_Main::$settings['wdw_front_page'] == $page->ID) echo ' selected="selected"'; ?>><?php echo $page->post_title; ?></option>
                                    <?php
                                    }
                                    ?>

                                </select>
                                <p class="description"> This is the page where the <code>[wdw-listing-list]</code> shortcode has been placed.</p>
                            </label><br>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Taxonomy Slug</label>
                        <div class="col-sm-9">
                            <label style="width: 100%;">
                                <input type="text" id="wdw_taxonomy_slug" value="<?php echo WDW_Main::$settings['wdw_taxonomy_slug']; ?>" style="width: 50%;">
                            </label><br>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Post Type Slug</label>
                        <div class="col-sm-9">
                            <label style="width: 100%;">
                                <input type="text" id="wdw_post_type_slug" value="<?php echo WDW_Main::$settings['wdw_post_type_slug'];?>" style="width: 50%;">
                            </label><br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Directory Information</label>
                        <div class="col-sm-9">
                            <td><hr style="border-top: 1px solid #ddd;"></td>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Directory Label</label>
                        <div class="col-sm-9">
                            <label style="width: 100%;">
                                <input type="text" id="wdw_directory_label" value="<?php echo WDW_Main::$settings['wdw_directory_label'];?>" style="width: 50%;">
                            </label><br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Directory Description</label>
                        <div class="col-sm-9">
                            <label style="width: 100%;">
                                <input type="text" id="wdw_directory_description" value="<?php echo WDW_Main::$settings['wdw_directory_description']; ?>" style="width: 50%;">

                            </label><br>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Other</label>
                        <div class="col-sm-9">
                            <td><hr style="border-top: 1px solid #ddd;"></td>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Google Maps</label>
                        <div class="col-sm-9">
                            <label style="width: 100%;">
                                <input type="checkbox" id="wdw_use_google_map" <?php echo (WDW_Main::$settings['wdw_use_google_map'] =='1')?'checked':''?>>
                                This toggles the display of Google Maps for listings that have an address set.
                            </label>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-sm-3 control-label">Credit Link</label>
                        <div class="col-sm-9">
                            <label style="width: 100%;">
                                <input type="checkbox" id="wdw_author_linking" name="wdw_author_linking" <?php echo (WDW_Main::$settings['wdw_author_linking'] =='1')?'checked':''?>>
                                Please support our plugin by activating author link in your website.
                            </label>
                        </div>
                    </div>

                </div>
                <!-- Emails -->
                <div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">From Name</label>
                        <div class="col-sm-9">
                            <label style="width: 100%;">
                                <input type="text" id="wdw_email_from_name" value="<?php echo WDW_Main::$settings['wdw_email_from_name']; ?>" style="width: 50%;">
                            </label><br>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">From Email</label>
                        <div class="col-sm-9">
                            <label style="width: 100%;">
                                <input type="text" id="wdw_email_from_email" value="<?php echo WDW_Main::$settings['wdw_email_from_email']; ?>" style="width: 50%;">
                            </label><br>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Notification Email</label>
                        <div class="col-sm-9">
                            <label style="width: 100%;">
                                <input type="text" id="wdw_email_notification_email" value="<?php echo WDW_Main::$settings['wdw_email_notification_email']; ?>" style="width: 50%;">

                            </label><br>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email Templates</label>
                        <div class="col-sm-9">
                            <td><hr style="border-top: 1px solid #ddd;"></td>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Admin Notification</label>
                        <div class="col-sm-9">
                            <label style="width: 100%;">
                                <input type="text" id="wdw_email_toadmin_subject" value="<?php echo WDW_Main::$settings['wdw_email_toadmin_subject']; ?>" style="width: 50%;">
                                <p class="description"> The subject line for email notifications sent to the site administrator.</p>
                            </label><br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Message</label>
                        <div class="col-sm-8">
                            <label style="width: 100%;">

                                <textarea id="wdw_email_toadmin_body" class="form-control" rows="8"><?php echo WDW_Main::$settings['wdw_email_toadmin_body']; ?></textarea>
                            </label><br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Submit Notification</label>
                        <div class="col-sm-9">
                            <label style="width: 100%;">
                                <input type="text" id="wdw_email_toauthor_subject" value="<?php echo WDW_Main::$settings['wdw_email_toauthor_subject']; ?>" style="width: 50%;">
                                <p class="description"> Sent to the author after they submit a new listing. Use this to remind them of your terms, inform them of average wait times or other important information.</p>
                            </label><br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Message</label>
                        <div class="col-sm-8">
                            <label style="width: 100%;">

                                <textarea id="wdw_email_toauthor_body" class="form-control" rows="8"><?php echo WDW_Main::$settings['wdw_email_toauthor_body']; ?></textarea>
                            </label><br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Public Notification</label>
                        <div class="col-sm-9">
                            <label style="width: 100%;">
                                <input type="text" id="wdw_email_public_subject" value="<?php echo WDW_Main::$settings['wdw_email_public_subject']; ?>" style="width: 50%;">
                                <p class="description"> Sent to the author when their listing has been approved and is available publicly.</p>
                            </label><br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Message</label>
                        <div class="col-sm-8">
                            <label style="width: 100%;">

                                <textarea id="wdw_email_public_body" class="form-control" rows="8"><?php echo WDW_Main::$settings['wdw_email_public_body']; ?></textarea>
                            </label><br>
                        </div>
                    </div>
                </div>
                <!-- Submit -->
                <div>



                    <div class="form-group">
                        <label class="col-sm-3 control-label">Require TOS</label>
                        <div class="col-sm-9">
                            <label style="width: 100%;">
                                <input type="checkbox" id="wdw_submit_require_tos" <?php echo (WDW_Main::$settings['wdw_submit_require_tos'] =='1')?'checked':''?>>
                                Check this to require users agree to your terms of service (defined below) before submitting a listing.
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Terms of Service</label>
                        <div class="col-sm-8">
                            <label style="width: 100%;">

                                <textarea id="wdw_submit_terms_of_service" class="form-control" rows="8"><?php echo WDW_Main::$settings['wdw_submit_terms_of_service']; ?></textarea>
                            </label><br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Introduction</label>
                        <div class="col-sm-8">
                            <label style="width: 100%;">

                                <textarea id="wdw_submit_top_message" class="form-control" rows="8"><?php echo WDW_Main::$settings['wdw_submit_top_message']; ?></textarea>
                                <p class="description"> This will be displayed at the top of the submit listing form.</p>
                            </label><br>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Success Message</label>
                        <div class="col-sm-8">
                            <label style="width: 100%;">

                                <textarea id="wdw_submit_success_message" class="form-control" rows="8"><?php echo WDW_Main::$settings['wdw_submit_success_message']; ?></textarea>
                                <p class="description"> Displayed following a successful listing submission.</p>
                            </label><br>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!-- Zozo Tabs End-->
        <div class="wdw-global-save-view">
        <button type="button"  class="btn btn-primary" onclick="save_global_settings();">Save Settings</button>
        </div>
    </form>
</div>


<div id="wrap-right-side" class="box-border-box  col-md-3" style="display: none; float: left;">
    <div class="panel panel-default text-left box-border-box  small-content">
        <div class="panel-heading"><strong>About Directory Wizard</strong></div>
        <div class="panel-body">
            <p>Directory Wizard is an Wordpress Plugin software that allows you to add a powerful directory listing to your WordPress web site.</p>
            <ul class="sib-widget-menu">
			                <li>
                    <a href="http://polldirectory.net/?action=submitlisting" target="_blank"><i class="fa fa-angle-right"></i> &nbsp;Submit your site to PollDirectory.net</a>
                </li>
                <li>
                    <a href="http://polldirectory.net/directory-plugin/" target="_blank"><i class="fa fa-angle-right"></i> &nbsp;Visit Plugin Page</a>
                </li>
                <li>
                    <a href="http://polldirectory.net" target="_blank"><i class="fa fa-angle-right"></i> &nbsp;Visit PollDirectory.net</a>
                </li>
            </ul>
        </div>

    </div>
    <div class="panel panel-default text-left box-border-box  small-content">
        <div class="panel-heading"><strong>Step by Step Instructions</strong></div>
        <div class="panel-body">
            <p><strong><font color="red">You need to follow the steps below in order to show correctly the directory script.</font></script></p>
            <ul class="sib-widget-menu">
                <li>Enable user registration, click here to visit your <a href="../wp-admin/options-general.php" target="_blank"><i class="fa fa-angle-right"></i> &nbsp;Settings Page.</a></li>
				                 <li>Create some categories. <a href="../wp-admin/edit-tags.php?taxonomy=wdw_category&post_type=wdw_listing" target="_blank"><i class="fa fa-angle-right"></i> &nbsp;Create a category.</a></li>
								                  <li>To display each category you need to create a listing for it. <a href="../wp-admin/post-new.php?post_type=wdw_listing" target="_blank"><i class="fa fa-angle-right"></i> &nbsp;Create a listing.</a></li>
            </ul>
        </div>
    </div>
    <div class="panel panel-default text-left box-border-box  small-content">
        <div class="panel-heading"><strong>Recommended our plugin</strong></div>
        <div class="panel-body">
            <p>You like Directory Wizard? Let everybody knows and review it</p>
            <ul class="sib-widget-menu">
                <li><a href="http://wordpress.org/support/view/plugin-reviews/directory-wizard/" target="_blank"><i class="fa fa-angle-right"></i> &nbsp;Review this plugin</a></li>
            </ul>
        </div>
    </div>
</div>
