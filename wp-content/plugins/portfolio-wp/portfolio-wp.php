<?php

/*
* Plugin Name: Career Portfolio
* Plugin URI: http://portfoliopluginwp.com
* Description: Super easy Wordpress portfolio plugin which aims to embed portfolio projects on WordPress based web sites.
* Author: Miixee
* Author URI: http://portfoliopluginwp.com
* License: GPLv2 or later
* Version: 1.6.1
*/


//Load configs
require_once( dirname(__FILE__).'/crp-config.php');
require_once( CRP_CLASSES_DIR_PATH.'/crp-ajax.php');
require_once( CRP_CLASSES_DIR_PATH.'/CRPHelper.php');
require_once( CRP_CLASSES_DIR_PATH.'/DBInitializer.php');

//Register activation & deactivation hooks
register_activation_hook( __FILE__, 'crp_activation_hook');
register_uninstall_hook( __FILE__, 'crp_uninstall_hook');

//Register action hooks
add_action('init', 'crp_init_action');
add_action('admin_enqueue_scripts', 'crp_admin_enqueue_scripts_action' );
add_action('wp_enqueue_scripts', 'crp_wp_enqueue_scripts_action' );
add_action('admin_menu', 'crp_admin_menu_action');
add_action('admin_head', 'crp_admin_head_action');
add_action('admin_footer', 'crp_admin_footer_action');

//Register filter hooks

//Register crp shortcode handlers
add_shortcode('crp_portfolio', 'crp_shortcode_handler');

//Register Ajax actions
add_action( 'wp_ajax_crp_get_portfolio', 'wp_ajax_crp_get_portfolio');
add_action( 'wp_ajax_crp_save_portfolio', 'wp_ajax_crp_save_portfolio');
add_action( 'wp_ajax_crp_get_options', 'wp_ajax_crp_get_options');
add_action( 'wp_ajax_crp_save_options', 'wp_ajax_crp_save_options');

//Global vars
$crp_portfolio;

//Registered activation hook
function crp_activation_hook(){
    $dbInitializer = new DBInitializer();
    if($dbInitializer->needsConfiguration()){
        $dbInitializer->configure();
    }
}

function crp_uninstall_hook(){

}

//Registered hook actions
function crp_init_action() {
    ob_start();
}
function crp_admin_enqueue_scripts_action() {
    crp_enqueue_admin_scripts();
    crp_enqueue_admin_csss();
}

function crp_wp_enqueue_scripts_action(){
    crp_enqueue_front_scripts();
    crp_enqueue_front_csss();
}

function crp_admin_menu_action() {
    crp_setup_admin_menu_buttons();
}

function crp_admin_head_action(){
    crp_include_inline_scripts();
    crp_setup_media_buttons();
}

function crp_admin_footer_action() {
    crp_include_inline_htmls();
}

//Registered hook filters
function crp_mce_external_plugins_filter($pluginsArray){
    return crp_register_tinymce_plugin($pluginsArray);
}

function crp_mce_buttons_filter($buttons){
    return crp_register_tc_buttons($buttons);
}

//Shortcode Hanlders
function crp_shortcode_handler($attributes){
	ob_start();

    //Prepare render data
    global $crp_portfolio;
    $crp_portfolio = CRPHelper::getPortfolioWithId($attributes['id']);
    require_once(CRP_FRONT_VIEWS_DIR_PATH."/crp-front.php");

    $result = ob_get_clean();
    return $result;
}

//Internal functionality
function crp_setup_admin_menu_buttons(){
    add_menu_page(CRP_PLUGIN_NAME, CRP_PLUGIN_NAME, 'manage_options', CRP_ADMIN_VIEWS_DIR_PATH.'/crp-admin.php', '', 'dashicons-portfolio', 76);
}

function crp_setup_media_buttons(){
    global $typenow;
    // check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
        return;
    }

    // verify the post type
    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        return;

    // check if WYSIWYG is enabled
    if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "crp_mce_external_plugins_filter");
        add_filter('mce_buttons', 'crp_mce_buttons_filter');
    }
}

function crp_register_tinymce_plugin($pluginsArray) {
    $pluginsArray['crp_tc_buttons'] = CRP_JS_URL."/crp-tc-buttons.js";
    return $pluginsArray;
}

function crp_register_tc_buttons($buttons) {
    array_push($buttons, "crp_insert_tc_button");
    return $buttons;
}

function crp_include_inline_scripts(){
?>
    <script type="text/javascript">

        <?php
            $crp_shortcodes = CRPHelper::tcButtonShortcodes();
        ?>

        crp_shortcodes = [];
        <?php foreach($crp_shortcodes as $crp_shortcode): ?>
            crp_shortcodes.push({
                "id" : "<?php echo $crp_shortcode->id ?>",
                "title" : "<?php echo $crp_shortcode->title ?>",
                "shortcode" : "<?php echo $crp_shortcode->shortcode ?>"
            });
        <?php endforeach; ?>


        jQuery(document).ready(function() {
        });
    </script>
<?php
}

function crp_include_inline_htmls(){
?>

<?php
}

function crp_enqueue_admin_scripts(){
    wp_enqueue_script("jquery");
    wp_enqueue_script("jquery-ui-core");
    wp_enqueue_script("jquery-ui-sortable");
    wp_enqueue_script("jquery-ui-autocomplete");

    //Enqueue JS files
    wp_enqueue_script( 'crp-helper-js', CRP_JS_URL.'/crp-helper.js', array('jquery') );
    wp_enqueue_script( 'crp-main-admin-js', CRP_JS_URL.'/crp-main-admin.js', array('jquery') );
    wp_enqueue_script( 'crp-ajax-admin-js', CRP_JS_URL.'/crp-ajax-admin.js', array('jquery') );

    wp_register_script('crp-tooltipster', CRP_JS_URL."/jquery/jquery.tooltipster.min.js");
    wp_enqueue_script('crp-tooltipster');

    wp_register_script('crp-caret', CRP_JS_URL."/jquery/jquery.caret.min.js");
    wp_enqueue_script('crp-caret');

    wp_register_script('crp-tageditor', CRP_JS_URL."/jquery/jquery.tageditor.min.js");
    wp_enqueue_script('crp-tageditor');

    wp_enqueue_media();
}

function crp_enqueue_admin_csss(){
    //Enqueue CSS files
    wp_register_style('crp-main-admin-style', CRP_CSS_URL.'/crp-main-admin.css');
    wp_enqueue_style('crp-main-admin-style');

    wp_register_style('crp-tc-buttons', CRP_CSS_URL.'/crp-tc-buttons.css');
    wp_enqueue_style('crp-tc-buttons');

    wp_register_style('crp-tooltipster', CRP_CSS_URL.'/tooltipster/tooltipster.css');
    wp_enqueue_style('crp-tooltipster');
    wp_register_style('crp-tooltipster-theme', CRP_CSS_URL.'/tooltipster/themes/tooltipster-shadow.css');
    wp_enqueue_style('crp-tooltipster-theme');

    wp_register_style('crp-tageditor', CRP_CSS_URL.'/tageditor/tageditor.css');
    wp_enqueue_style('crp-tageditor');

    wp_register_style('crp-font-awesome', CRP_CSS_URL.'/fontawesome/font-awesome.css');
    wp_enqueue_style('crp-font-awesome');
}

function crp_enqueue_front_scripts(){
    //Enqueue JS files
    wp_enqueue_script( 'crp-main-front-js', CRP_JS_URL.'/crp-main-front.js', array('jquery') );
    wp_enqueue_script( 'crp-helper-js', CRP_JS_URL.'/crp-helper.js', array('jquery') );

    wp_enqueue_script( 'crp-modernizr', CRP_JS_URL."/jquery/jquery.modernizr.min.js", array('jquery') );
    wp_enqueue_script( 'crp-tiled-layer', CRP_JS_URL."/crp-tiled-layer.js", array('jquery') );
    wp_enqueue_script( 'crp-fs-viewer', CRP_JS_URL.'/crp-fs-viewer.js', array('jquery') );
}

function crp_enqueue_front_csss(){
    //Enqueue CSS files
    wp_register_style('crp-main-front-style', CRP_CSS_URL.'/crp-main-front.css');
    wp_enqueue_style('crp-main-front-style');

    wp_register_style('crp-tc-buttons', CRP_CSS_URL.'/crp-tc-buttons.css');
    wp_enqueue_style('crp-tc-buttons');

    wp_register_style('crp-tiled-layer', CRP_CSS_URL.'/crp-tiled-layer.css');
    wp_enqueue_style('crp-tiled-layer');

    wp_register_style('crp-fs-viewer', CRP_CSS_URL.'/fsviewer/crp-fs-viewer.css');
    wp_enqueue_style('crp-fs-vewer');

    wp_register_style('crp-font-awesome', CRP_CSS_URL.'/fontawesome/font-awesome.css');
    wp_enqueue_style('crp-font-awesome');
}
