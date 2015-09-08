<?php

/*
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
*/

//***************** Immutable configurations ********************//
define( 'CRP_ROOT_DIR_NAME', 'portfolio-wp');
define( 'CRP_ROOT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'CRP_CLASSES_DIR_PATH' , CRP_ROOT_DIR_PATH.'classes' );
define( 'CRP_IMAGES_DIR_PATH', CRP_ROOT_DIR_PATH.'images' );
define( 'CRP_VIEWS_DIR_PATH', CRP_ROOT_DIR_PATH.'views' );
define( 'CRP_ADMIN_VIEWS_DIR_PATH', CRP_VIEWS_DIR_PATH.'/admin' );
define( 'CRP_FRONT_VIEWS_DIR_PATH', CRP_VIEWS_DIR_PATH.'/front' );
define( 'CRP_PLUGIN_URL'   , plugins_url( CRP_ROOT_DIR_NAME ) );
define( 'CRP_CSS_URL'      , CRP_PLUGIN_URL.'/css' );
define( 'CRP_JS_URL'       , CRP_PLUGIN_URL.'/js' );
define( 'CRP_IMAGES_URL', CRP_PLUGIN_URL.'/images' );


global $wpdb;

define( 'CRP_PLUGIN_PREFIX', 'crp');
define( 'CRP_DB_PREFIX'     , $wpdb->prefix.CRP_PLUGIN_PREFIX.'_' );

define("CRP_PLUGIN_NAME","Career Portfolio");


//**************** Configurable configurations *******************//
define( 'CRP_PRO_URL' , 'http://portfoliopluginwp.com' );

//Define table names
define( 'CRP_TABLE_PORTFOLIOS' , CRP_DB_PREFIX.'portfolios' );
define( 'CRP_TABLE_PROJECTS' , CRP_DB_PREFIX.'projects' );
define( 'CRP_TABLE_OPTIONS' , CRP_DB_PREFIX.'options' );

//Enum simulated classes
abstract class CRPViewType{
    const Unknown = 0;
    const Puzzle = 1;
    const Masonry = 2;
    const Square = 3;
    const WaterfallList = 4;
    const Slider = 5;
    const TestLayout = 6;
}

//Enum simulated classes
abstract class CRPOption{

    //Layout Types
    const kLayoutType = "kLayoutType";
    //Quality
    const kThumbnailQuality = "kThumbnailQuality";
    const kScaleCoefficient = "kScaleCoefficient";
    //Category filtration
    const kShowCategoryFilters = "kShowCategoryFilters";
    //Social buttons
    const kShowFacebookIcon = "kShowFacebookIcon";
    const kShowTwitterIcon = "kShowTwitterIcon";
    const kShowGoogleIcon = "kShowGoogleIcon";
    const kShowPinterestIcon = "kShowPinterestIcon";
    const kSocialIconType = "kSocialIconType";
    //Caption overlay
    const kShowCaptionTitle = "kShowCaptionTitle";
    const kShowCaptionSubtitle = "kShowCaptionSubtitle";
    const kShowCaptionIcon = "kShowCaptionIcon";
    const kCaptionIconType = "kCaptionIconType";
    //Effects & animations
    const kTileImageHoverEffect = "kTileImageHoverEffect";
    const kTileCaptionHoverEffect = "kTileCaptionHoverEffect";
    const kLayoutScrollEffect = "kLayoutScrollEffect";
    //Dimensions
    const kLayoutWidth = "kLayoutWidth";
    const kLayoutWidthUnit = "kLayoutWidthUnit";
    const kLayoutMargins = "kLayoutMargins";
    const kTileApproxWidth = "kTileApproxWidth";
    const kTileMinWidth = "kTileMinWidth";
    const kTileBorderWidth = "kTileBorderWidth";
    const kTileMargins = "kTileMargins";
    const kTileCornerRadius = "kTileCornerRadius";
    const kTileCornerRadiusUnit = "kTileCornerRadiusUnit";
    const kTileShadowWidth = "kTileShadowWidth";
    //Alignments
    const kLayoutAlignment = "kLayoutAlignment";
    const kSocialMenuAlignment = "kSocialMenuAlignment";
    //Colorization
    const kTintColor = "kTintColor";
    const kTextTintColor = "kTextTintColor";
    const kProgressTintColor = "kProgressTintColor";
    const kFilterTintColor = "kFilterTintColor";
    const kFilterHoverTintColor = "kFilterHoverTintColor";
    const kTileBorderColor = "kTileBorderColor";
    const kTileShadowColor = "kTileShadowColor";
    const kTileCaptionOverlayColor = "kTileCaptionOverlayColor";
    const kTileCaptionOverlayOpacity = "kTileCaptionOverlayOpacity";
    const kTileCaptionTextsColor = "kTileCaptionTextsColor";
    const kTileCaptionIconsColor = "kTileCaptionIconsColor";
    const kTileCaptionIconsHoverColor = "kTileCaptionIconsHoverColor";

    //Customize CSS & JS
    const kCustomCSS = "kCustomCSS";
    const kCustomJS = "kCustomJS";

    //Extanded options
}

abstract class CRPLogType{
    const Local = 0;
    const Remote = 1;
}

?>