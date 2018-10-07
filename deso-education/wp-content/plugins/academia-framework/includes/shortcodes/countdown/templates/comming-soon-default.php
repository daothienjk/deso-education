<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 6/15/15
 * Time: 2:56 PM
 */

$g5plus_options = &academia_get_options_config();
$min_suffix = (isset($g5plus_options['enable_minifile_js']) && $g5plus_options['enable_minifile_js'] == 1) ? '.min' : '';
wp_enqueue_style('academia-portfolio-css', plugins_url() . '/academia-framework/includes/shortcodes/countdown/assets/css/countdown'.$min_suffix.'.css', array(),false);
wp_enqueue_script('academia-jquery-countdown',plugins_url() . '/academia-framework/includes/shortcodes/countdown/assets/jquery.countdown/jquery.countdown.min.js', false, true);

$args = array(
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'post_type'        => 'countdown',
    'post_status'      => 'publish');
$posts_array  = new WP_Query( $args );
$opening_hours = $countdown_type= '';
$urlRedirect = '';
while ( $posts_array->have_posts() ) : $posts_array->the_post();
    $type= rwmb_meta('countdown-type');
    if($type=='comming-soon'){
        $countdown_type = $type;
        $urlRedirect = rwmb_meta('countdown-url');
        $opening_hours = rwmb_meta('countdown-opening');
        break;
    }
endwhile;
wp_reset_postdata();
$color = $g5plus_options['primary_color'];
$font_family = $g5plus_options['count_down_font'];
if(is_array($font_family))
    $font_family = $font_family["font-family"];
$data_section_id = 'opening-hours-'.uniqid();
?>
<div class="countdown <?php echo esc_attr($el_class) ?>">
    <div class="container">
        <div id="<?php echo esc_attr($data_section_id)?>" class="opening-hours">
            <div class="default">
                <div class="canvas">
                    <span id="months" class="times p-color-bg p-font"></span>
                    <span class="title s-font"><?php esc_html_e('Months','g5plus-academia') ?></span>
                </div>
                <div class="canvas">
                    <span id="days" class="times p-color-bg p-font"></span>
                    <span class="title s-font" ><?php esc_html_e('Days','g5plus-academia') ?></span>
                </div>
                <div class="canvas">
                    <span id="hours" class="times p-color-bg p-font"></span>
                    <span class="title s-font"><?php esc_html_e('Hours','g5plus-academia') ?></span>
                </div>
                <div class="canvas">
                    <span id="minutes" class="times p-color-bg p-font"></span>
                    <span class="title s-font"><?php esc_html_e('Minutes','g5plus-academia') ?></span>
                </div>
                <div class="canvas">
                    <span id="second" class="times p-color-bg p-font"></span>
                    <span class="title s-font"><?php esc_html_e('Seconds','g5plus-academia') ?></span>
                </div>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>

</div>
<script type="text/javascript">
    (function($) {
        "use strict";
        var elm = $('#<?php echo esc_attr($data_section_id)?>');
        $(document).ready(function(){
            $("#<?php echo esc_attr($data_section_id)?>").countdown('<?php echo esc_html($opening_hours); ?>',function(event){
                setTimeout(function(){
                    $(elm).css('opacity','1');
                },500);

            });

            $("#<?php echo esc_attr($data_section_id)?>").countdown('<?php echo esc_html($opening_hours); ?>').on('update.countdown', function(event) {
                var second = parseInt(event.strftime('%S'));
                var minutes = parseInt(event.strftime('%M'));
                var hours = parseInt(event.strftime('%H'));
                var days = parseInt(event.strftime('%d'));
                var months = parseInt(event.strftime('%m'));
                var weeks = parseInt(event.strftime('%w'));
                if(months>0){
                    var bufferDay = weeks%4 * 7;
                    if(bufferDay>0){
                        days = bufferDay;
                    }
                }
                else{
                    days =  weeks*7 + days;
                }
                if(second<10)
                    second = '0' + second;
                if(minutes<10)
                    minutes = '0' + minutes;
                if(hours<10)
                    hours = '0' + hours;
                if(days<10)
                    days = '0' + days;
                if(months<10)
                    months = '0' + months;

                var elm = $('#<?php echo esc_attr($data_section_id)?>');
                $('#second',elm).html(second).trigger('change');
                $('#minutes',elm).html(minutes).trigger('change');
                $('#hours',elm).html(hours).trigger('change');
                $('#days',elm).html(days).trigger('change');
                $('#months',elm).html(months).trigger('change');

            }).on('finish.countdown', function(event){
                var elm = $('#<?php echo esc_attr($data_section_id)?>');
                $('#seconds',elm).val(0);
                <?php if( $urlRedirect!=''){ ?>
                    window.location.href= '<?php echo esc_url($urlRedirect); ?>';
                <?php } ?>
            });
            function fullScreen(){
                var $window_height = $(window).height();
                var $window_width = $(window).width();
                var $img = 0;
                if($('img').length>0){
                    $img = $('.under-construction >.vc_column-inner').outerHeight();
                }
                var $padding =  0;
                if($window_width > 1200){
                    $padding =  ($window_height - $img)/2;
                    var $fullScreenHeight = $('.full-screen').outerHeight();
                    if($fullScreenHeight< $window_height){
                        $('.full-screen').css('height',$window_height);
                    }
                }else{
                    $('.full-screen').css('height','auto');
                }
                if($padding>0){
                    $('.widget').css('margin-top',$padding/5);
                    $('.under-construction').css('padding-top',$padding/2);
                    $('.under-construction').css('padding-bottom',$padding/12);
                }


                if($window_width > 2000){
                    $padding =  ($window_height - $img)/2;
                    var $fullScreenHeight = $('.full-screen').outerHeight();
                    if($fullScreenHeight< $window_height){
                        $('.full-screen').css('height',$window_height);
                    }
                    $('.under-construction').css('padding-top',$padding);
                    $('.under-construction').css('padding-bottom',$padding);
                }else{
                    $('.full-screen').css('height','auto');
                }
            }
            fullScreen();
            $(window).resize(function(){
                fullScreen();
            });
        });
    })(jQuery);
</script>
