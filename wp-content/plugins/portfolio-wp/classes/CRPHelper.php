<?php

class CRPHelper {

static public function shortcodeWithPID($pid){
    return "[crp_portfolio id={$pid}]";
}

static public function tcButtonShortcodes(){
    global $wpdb;

    $query = @$wpdb->prepare("SELECT * FROM ".CRP_TABLE_PORTFOLIOS);
    $results = $wpdb->get_results( $query , ARRAY_A );

    $shortcodes = array();
    for($i=0; $i<count($results); $i++){
        $shortcode = new stdClass();

        $shortcode->id = $results[$i]["id"];
        $shortcode->title = $results[$i]["title"];
        $shortcode->shortcode = CRPHelper::shortcodeWithPID($results[$i]["id"]);

        $shortcodes[] = $shortcode;
    }

    return $shortcodes;
}

static public function getPortfolioWithId($pid){
    if(!$pid) return null;

    global $wpdb;
    $portfolio = null;

    $query = @$wpdb->prepare("SELECT * FROM ".CRP_TABLE_PORTFOLIOS." WHERE id='{$pid}'");
    $res = $wpdb->get_results( $query , OBJECT );

    if(count($res)) {
        $portfolio = $res[0];

        $query = @$wpdb->prepare("SELECT * FROM " . CRP_TABLE_PROJECTS . " WHERE pid='{$pid}'");
        $res = $wpdb->get_results($query, OBJECT);

        $projects = array();
        foreach ($res as $project) {
            $project->pics = explode(',', $project->pics);
            $project->categories = explode(',', $project->categories);
            $projects[$project->id] = $project;
        }
        $portfolio->projects = $projects;
        $portfolio->corder = explode(',', $portfolio->corder);


        if($portfolio->options && !empty($portfolio->options)){
            $portfolio->options = json_decode( base64_decode($portfolio->options), true);
        }else{
            $portfolio->options = json_decode( base64_decode(CRPHelper::getPortfolioDefaultOptions()), true);
        }
    }

    return $portfolio;
}

static public function getPortfolioDefaultOptions($pid = 0){
    //TODO: Update this each time if any default option is changed
    $options = '{"id":"'.$pid.'","kThumbnailQuality":"large","kScaleCoefficient":"0.7","kShowCategoryFilters":true,"kShowFacebookIcon":true,"kShowTwitterIcon":true,"kShowGoogleIcon":true,"kShowPinterestIcon":true,"kSocialIconType":"standard","kShowCaptionTitle":false,"kShowCaptionSubtitle":false,"kShowCaptionIcon":true,"kCaptionIconType":"eye","kTileImageHoverEffect":"zoom-in","kTileCaptionHoverEffect":"fade","kLayoutScrollEffect":"slide","kLayoutWidth":"100","kLayoutWidthUnit":"%","kLayoutMargins":"0","kTileApproxWidth":"250","kTileMinWidth":"200","kTileBorderWidth":"0","kTileMargins":"4","kTileCornerRadius":"0","kTileCornerRadiusUnit":"%","kTileShadowWidth":"0","kLayoutAlignment":"center","kSocialMenuAlignment":"bottom-right","kTintColor":"#000000","kTextTintColor":"#ffffff","kProgressTintColor":"#7f8c8d", "kFilterTintColor":"#7f8c8d","kFilterHoverTintColor":"#2c3e50","kTileBorderColor":"","kTileShadowColor":"","kTileCaptionOverlayColor":"#000000","kTileCaptionOverlayOpacity":"73","kTileCaptionTextsColor":"#ffffff","kTileCaptionIconsColor":"#ffffff","kTileCaptionIconsHoverColor":"#006489","kCustomJS":"","kCustomCSS":"","kLayoutType":"2"}';

    $options = str_replace("'", '"', $options);
    $options = base64_encode($options);
    return $options;
}

static public function getCategoryFiltersFor($project){
    $filter = "";
    foreach($project->categories as $category ){
        $filter .= "ftg-".str_replace(" ","-",$category)." ";
    }
    return $filter;
}

static public function thumbWithQuality($picInfo, $quality){
    if(!isset($picInfo)) return "";
    if(!isset($quality)) return $picInfo->medium;

    if($quality === "medium"){
        return $picInfo->medium;
    }elseif($quality === "large"){
        return $picInfo->large;
    }elseif($quality === "small"){
        return $picInfo->small;
    }else{
        return $picInfo->original;
    }
}

static function hex2rgba($color) {

    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if(empty($color))
        return $default;

    //Sanitize $color if "#" is provided
    if ($color[0] == '#' ) {
        $color = substr( $color, 1 );
    }

    $opacity = 255;

    //Check if color has 8, 6 or 3 characters and get values
    if (strlen($color) == 8) {
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        $opHex = array ($color[6] . $color[7]);
    } elseif (strlen($color) == 6) {
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
        $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
        return $default;
    }

    //Convert hexadec to rgba
    $rgb =  array_map('hexdec', $hex);
    $opacity = array_map('hexdec',$opHex);
    $opacity = $opacity[0]/255;

    $output = 'rgba('.implode(",",$rgb).','.$opacity.')';

    //Return rgb(a) color string
    return $output;
}

} 