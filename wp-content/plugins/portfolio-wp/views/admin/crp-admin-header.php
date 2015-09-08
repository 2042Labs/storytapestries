<?php

function featuresListToopltip(){
    $tooltip = "";
    $tooltip .= "<div class=\"crp-tooltip-content\">";
    $tooltip .=      "<img src=\"". CRP_IMAGES_URL ."/general/upgrade-tooltip.png\" />";
    $tooltip .= "</div>";

    $tooltip = htmlentities($tooltip);
    return $tooltip;
}

?>

<div class="crp-header">
    <a href='<?php echo "?page={$crp_adminPage}" ?>'>
        <img class="crp-logo" src="<?php echo CRP_IMAGES_URL ."/general/logo.png" ?>">
    </a>

    <a class='button-secondary upgrade-button tooltip' href='<?php echo CRP_PRO_URL ?>' title='<?php echo featuresListToopltip(); ?>'>* BUY NOW *</a>
    <hr />
</div>


<script>
    //Setup tooltipster
    jQuery('.tooltip').tooltipster({
        contentAsHTML: true,
        animation: 'fade', //fade, grow, swing, slide, fall
        theme: 'tooltipster-shadow',
        position: 'bottom'
    });
</script>