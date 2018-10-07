/**
 * Created by phuongth on 1/20/2016.
 */
(function($){
    "use strict";
    var CourseSearch = {
        init: function() {
            $('.course-search.advance').each(function(){
                var $bg_image = $(this).attr('data-bg');
                console.log($bg_image);
                if($bg_image!=''){
                    $(this).append('<style>.course-search.advance::after{background-image:url(' + $bg_image + ')}</style>');
                }
            });
        },
    };
    $(document).ready(function(){
        CourseSearch.init();
    });

})(jQuery);