<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_ShortCode_Event')) {
    class g5plusFramework_ShortCode_Event
    {
        function __construct()
        {
            add_shortcode('academia_event', array($this, 'event_shortcode'));
        }

        function event_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $layout_style
             * @var $item_amount
             * @var $autoplaytimeout
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            if(!class_exists('Tribe__Events__Main')) return null;
            $layout_style=$item_amount=$autoplaytimeout=$el_class=$css_animation=$duration=$delay='';
            $atts = vc_map_get_attributes( 'academia_event', $atts );
            extract( $atts );
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            $g5plus_options = &academia_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('academia_event_css', plugins_url('academia-framework/includes/shortcodes/event/assets/css/event' . $min_suffix_css . '.css'), array(), false);
            $args = array(
                'post_type'            => Tribe__Events__Main::POSTTYPE,
                'posts_per_page'       => $item_amount
            );
            $data = new WP_Query($args);
            ob_start();
            if($layout_style=='style1')
            {
                $data_section_id = uniqid();
                ?>
                <div data-section-id="<?php echo esc_attr($data_section_id) ?>" class="event row style1 <?php echo esc_attr($g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
                    <?php
                    $index=0;
                    $matrix = array(
                        array(1,2,1,1,1.5,2.5,1)
                    );
                    if ($data->have_posts()) :?>
                        <?php while ($data->have_posts()): $data->the_post();
                            $attach_id = get_post_thumbnail_id();
                            $index++;
                            $index_col = floor(($index-1)%7);
                            if($matrix[0][$index_col]==2){
                                $img =wpb_resize($attach_id,null,590,220,true);
                                $class='col-md-6 col-sm-6 col-xs-12 height-220';
                            }
                            elseif($matrix[0][$index_col]==1.5){
                                $img = wpb_resize($attach_id, null, 280, 450, true);
                                $class='col-md-3 col-sm-6 col-xs-12 height-450';
                            }
                            elseif($matrix[0][$index_col]==2.5){
                                $img =wpb_resize($attach_id,null,590,450,true);
                                $class='col-md-6 col-sm-6 col-xs-12 height-450';
                            }
                            else{
                                $img =wpb_resize($attach_id,null,280,220,true);
                                $class='col-md-3 col-sm-6 col-xs-12 height-220';
                            }
                            ?>
                            <div class="<?php echo esc_attr($class) ?> event-item-isotope">
                                <div class="event-item">
                                    <img src="<?php echo wp_kses_post($img['url']) ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
                                    <div class="event-overlay">
                                        <div class="event-overlay-content">
                                            <?php echo tribe_events_event_schedule_details() ?>
                                                <h4>
                                                    <a href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
                                                    <?php the_title() ?>
                                                    </a>
                                                </h4>
                                                <span class="event-comment"><?php echo get_comments_number(); ?></span>
                                                <?php if (function_exists('g5plus_get_post_views') ):?>
                                                    <span class="event-view"><?php echo g5plus_get_post_views(); ?></span>
                                                <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                    <?php endif;?>
                </div>
                <script type="text/javascript">
                    (function ($) {
                        "use strict";
                        $(document).ready(function () {
                            var $container = $('div[data-section-id="<?php echo esc_attr($data_section_id); ?>"]');
                            $container.imagesLoaded(function () {
                                $container.isotope({
                                    itemSelector: '.event-item-isotope',
                                    percentPosition: true
                                }).isotope('layout');
                            });
                        });
                    })(jQuery);
                </script>
            <?php
            }
            else
            {
                if($data->post_count > 1) {
                    $data_carousel = '"autoplay": true,"loop":true,"center":false,"margin":0,"animateOut":"fadeOut","autoplayHoverPause":true,"autoplayTimeout":' . $autoplaytimeout . ',"items":1,"responsive":{},"dots": true, "nav":false';
                } else {
                    $data_carousel = '"autoplay": true,"loop":false,"center":false,"margin":0,"animateOut":"fadeOut","autoplayHoverPause":true,"autoplayTimeout":' . $autoplaytimeout . ',"items":1,"responsive":{},"dots": true, "nav":false';
                }
                ?>
                <div class="event style2 <?php echo esc_attr($g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
                    <div data-plugin-options='{<?php echo esc_attr($data_carousel) ?>}' class="owl-g5plus-shortcode owl-carousel">
                        <?php if ($data->have_posts()) :?>
                        <?php while ($data->have_posts()): $data->the_post();
                            $attach_id = get_post_thumbnail_id();
                            $img =wpb_resize($attach_id,null,570,415,true);
                            ?>
                            <div class="row-event-item">
                                <div class="col-md-6 col-sm-12 col-md-push-6 col-event-image">
                                    <img src="<?php echo wp_kses_post($img['url']) ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
                                </div>
                                <div class="col-md-6 col-sm-12 col-md-pull-6 col-event-content">
                                    <div class="content-middle-inner">
                                        <?php echo tribe_events_event_schedule_details() ?>
                                        <h4>
                                            <a class="heading-color" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
                                                <?php the_title() ?>
                                            </a>
                                        </h4>
                                        <span class="event-comment"><?php echo get_comments_number(); ?></span>
                                        <?php if (function_exists('g5plus_get_post_views') ):?>
                                            <span class="event-view"><?php echo g5plus_get_post_views(); ?></span>
                                        <?php endif; ?>
                                        <?php the_excerpt();?>
                                        <a class="bt bt-xs bt-bg bt-tertiary sm-mg-bottom-30" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
                                            <?php echo esc_html__('JOIN NOW', 'g5plus-academia') ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <?php endif;?>
                    </div>
                </div>
            <?php
            }
            wp_reset_postdata();
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_ShortCode_Event();
}