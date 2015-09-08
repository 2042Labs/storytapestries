<?php

?>

<!--Link JS Files-->
<script src="<?php echo CRP_JS_URL.'/jquery/jquery.modernizr.min.js' ?>"></script>
<script src="<?php echo CRP_JS_URL.'/crp-tiled-layer.js' ?>"></script>
<script src="<?php echo CRP_JS_URL.'/jquery/jquery.lightgallery.min.js' ?>"></script>


<!--Link CSS Files-->
<link href="<?php echo CRP_CSS_URL.'/crp-tiled-layer.css' ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo CRP_CSS_URL.'/lightgallery/lightgallery.css' ?>" rel="stylesheet" type="text/css" />


<!--Here Goes CSS-->
<style>
    /* Portfolio Options Configuration Goes Here*/
    #gallery div{
        margin-left: 0px !important;
        margin-right: 0px !important;
        padding-left: 0px !important;
        padding-right: 0px !important;
    }
    
  .lg-info{
    position:fixed; 
    z-index:3; 
    left:10px; 
    top:10px; 
    padding:10px; 
    margin-right: 70px; 
    min-width: 300px;
    max-width: 400px;
    background-color: rgba(0,0,0,0.5);
    color:#FFF; font-size:16px;
  }

  .lg-info h4, .lg-info h3, .lg-info h2 {
    text-transform:uppercase; 
    margin: 0px; 
    font-weight: 100; 
    font-size: 16px; 
    line-height: normal; 
    max-height: 40px; 
    overflow: hidden; 
  }

  .lg-info p {
    margin-top: 7px; 
    font-weight: 100; 
    font-size: 12px; 
    line-height: normal; 
    max-height: 100px; 
    overflow: auto;
  }

</style>

<!--Here Goes HTML-->
<div class="crp-wrapper">
    <div id="gallery">
        <div id="ftg-items" class="ftg-items">
            <?php foreach($crp_portfolio->projects as $crp_project): ?>
                <div id="crp-tile-<?php echo $crp_project->id?>" class="tile">
                    <?php $coverInfo = json_decode(base64_decode($crp_project->cover)); ?>

                    <a id="<?php echo $crp_project->id ?>" class="tile-inner">
                        <img class="item" src="<?php echo CRPHelper::thumbWithQuality($coverInfo,$crp_portfolio->options[CRPOption::kThumbnailQuality]) ?>" />
                        <div class="caption">
                        </div>
                    </a>

                    <ul id="crp-light-gallery-<?php echo $crp_project->id; ?>" class="crp-light-gallery" style="display: none;" data-sub-html="
                      <?php if( (isset($crp_project->title) && $crp_project->title !== '' ) || (isset($crp_project->description) && $crp_project->description !== '' )) : ?>
                        <div class='lg-info'>
                        
                        <?php if(isset($crp_project->title) && $crp_project->title !== '' ) : ?>
                            <h4><?php echo base64_decode($crp_project->title) ?></h4>
                        <?php endif; ?>

                        <?php if(isset($crp_project->description) && $crp_project->description !== '' ) : ?>
                            <p><?php echo base64_decode($crp_project->description) ?></p>
                        <?php endif; ?>

                        </div>
                      <?php endif; ?>
                      " data-url="<?php echo isset($crp_project->url) ? $crp_project->url : ''; ?>">

                        <li data-src="<?php echo $coverInfo->original ?>" >
                            <a href="#">
                                <img src="<?php echo $coverInfo->medium ?>" />
                            </a>
                        </li>    

                        <?php foreach($crp_project->pics as $pic): ?>
                            <?php if(!empty($pic)): ?>
                                <?php $picInfo = json_decode(base64_decode($pic)); ?>
                                    <li data-src="<?php echo $picInfo->original ?>">
                                        <a href="#">
                                            <img src="<?php echo $picInfo->medium ?>" />
                                        </a>
                                    </li>    
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!--Here Goes JS-->
<script>
    (function($) {
        jQuery('#gallery').crpTiledLayer({});

        $( ".crp-light-gallery" ).each(function() {
          var id = $( this ).attr("id");
          $("#" + id).lightGallery({
            mode: 'slide',
            useCSS: true,
            cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
            easing: 'linear', //'for jquery animation',//
            speed: 600,
            addClass: '',

            closable: true,
            loop: true,
            auto: false,
            pause: 6000,
            escKey: true,
            controls: true,
            hideControlOnEnd: false,

            preload: 1, //number of preload slides. will exicute only after the current slide is fully loaded. ex:// you clicked on 4th image and if preload = 1 then 3rd slide and 5th slide will be loaded in the background after the 4th slide is fully loaded.. if preload is 2 then 2nd 3rd 5th 6th slides will be preloaded.. ... ...
            showAfterLoad: true,
            selector: null,
            index: false,

            lang: {
                allPhotos: 'All photos'
            },
            counter: true,

            exThumbImage: false,
            thumbnail: true,
            showThumbByDefault:false,
            animateThumb: true,
            currentPagerPosition: 'middle',
            thumbWidth: 150,
            thumbMargin: 10,


            mobileSrc: false,
            mobileSrcMaxWidth: 640,
            swipeThreshold: 50,
            enableTouch: true,
            enableDrag: true,

            vimeoColor: 'CCCCCC',
            youtubePlayerParams: false, // See: https://developers.google.com/youtube/player_parameters,
            videoAutoplay: true,
            videoMaxWidth: '855px',

            dynamic: false,
            dynamicEl: [],

            // Callbacks el = current plugin
            onOpen        : function(el) {}, // Executes immediately after the gallery is loaded.
            onSlideBefore : function(el) {}, // Executes immediately before each transition.
            onSlideAfter  : function(el) {}, // Executes immediately after each transition.
            onSlideNext   : function(el) {}, // Executes immediately before each "Next" transition.
            onSlidePrev   : function(el) {}, // Executes immediately before each "Prev" transition.
            onBeforeClose : function(el) {}, // Executes immediately before the start of the close process.
            onCloseAfter  : function(el) {}, // Executes immediately once lightGallery is closed.
            onOpenExternal  : function(el) {
              var href = $(el).attr("data-url");
              crp_loadHref(href,true);
            }, // Executes immediately before each "open external" transition.
            onToggleInfo  : function(el) {
              var $info = $(".lg-info");
              if($info.css("opacity") == 1){
                $info.fadeTo("slow",0);
              }else{
                $info.fadeTo("slow",1);
              }
            } // Executes immediately before each "toggle info" transition.
          });
        });

        jQuery(".tile").on('click', function (event){
            event.preventDefault();
            if(jQuery(event.target).hasClass("fa") && !jQuery(event.target).hasClass("zoom")) return;

            var tileId = jQuery(this).attr("id");
            var target = jQuery("#" + tileId + " .crp-light-gallery li:first");
            target.trigger( "click" );
        });
    })( jQuery );
</script>