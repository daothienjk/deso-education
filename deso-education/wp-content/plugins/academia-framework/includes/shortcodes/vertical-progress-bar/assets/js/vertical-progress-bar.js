/**
 * Created by trungpq on 15/09/2015.
 */
(function ($) {
    "use strict";
    var G5PlusVerticalProgress = {
        init: function() {
            if ( 'undefined' !== typeof(jQuery.fn.waypoint) ) {
                $( '.v-progress-bar' ).waypoint( function () {
                    $( this ).find( '.vc_single_bar' ).each( function ( index ) {
                        var $this = jQuery( this ),
                            bar = $this.find( '.vc_bar' ),
                            val = bar.data( 'percentage-value' );

                        setTimeout( function () {
                            bar.css( { "height": val + '%' } );
                        }, index * 200 );
                    } );
                }, { offset: '85%' } );
            }
        }
    };
    $(document).ready(G5PlusVerticalProgress.init);
})(jQuery);