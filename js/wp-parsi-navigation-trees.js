jQuery(document).ready(function(){


	jQuery('#wb_tree ul li').has('.sub-menu').prepend('<span>+</span>');
	jQuery('#wb_tree ul ul').hide();
	
    jQuery('#wb_tree span').click(
    function(){
    
	   
    }).toggle(
       function(){
       	   jQuery(this).text('-');
       	   
       	   var parent = jQuery(this).parent();
       	   jQuery(parent).find('>ul').slideToggle();
       },
       function(){
       	   jQuery(this).text('+');
       	   var parent = jQuery(this).parent();
       	   jQuery(parent).find('>ul').slideToggle();
       }
    )
    
    jQuery("li:contains('+')").css("background-image", "none");


});