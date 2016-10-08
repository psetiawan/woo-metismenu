jQuery(document).ready(function() {
var $this = jQuery('#menu'),
            resizeTimer,
            self = jQuery(this);

          var initCollapse = function(el) {
            if (jQuery(window).width() >= 768) {
              this.find('li').has('ul').children('a').off('click');
            }
          };

          jQuery(window).resize(function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(self.initCollapse($this), 250);
          });	
		  jQuery( '<span class="glyphicon glyphicon-chevron-right"></span>' ).insertBefore( "ul.children" );
	jQuery('#menumetis').metisMenu();
});