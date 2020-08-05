(function($) {
    'use strict';
    
    $('document').ready(function() {
        $('nav.menu-vertical-wrapper').activescroll({
            active: "selected"
        });
        
        $('nav.menu-vertical-wrapper').sticky({ topSpacing: 20 });
        
        $('nav.menu-vertical-wrapper .expand').on('click', function(){
            var $self = $(this), $parent = $self.closest('.has-children');
            if($parent.hasClass('selected')) {
                $parent.removeClass('selected');
            } else {
                $parent.addClass('selected');
            }
        });
        
    });

})(jQuery);