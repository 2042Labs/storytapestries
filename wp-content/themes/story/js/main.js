jQuery(document).ready(function(){
    jQuery('.menu-header .menu-item .sub-menu').each(function(index,el){
        var parent_position = jQuery(el).parent().position();
        jQuery(el).width('100%').css('left','0').css('padding-left','0').css('padding-right','0');
        jQuery(el).find('a').css('padding-left',parent_position.left+'px');
    });
    jQuery('.subscribe_block #frm-email').attr('placeholder','Email');
});