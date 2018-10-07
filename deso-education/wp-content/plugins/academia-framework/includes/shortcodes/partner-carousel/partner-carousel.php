<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Partner_Carousel')) {
    class g5plusFramework_Shortcode_Partner_Carousel
    {
        function __construct()
        {
            add_shortcode('academia_partner_carousel', array($this, 'partner_carousel_shortcode'));
        }

        function partner_carousel_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $images
             * @var $opacity
             * @var $custom_links
             * @var $custom_links_target
             * @var $img_size
             * @var $loop
             * @var $center
             * @var $nav
             * @var $dots
             * @var $autoplay
             * @var $autoplayhoverpause
             * @var $autoplaytimeout
             * @var $items
             * @var $itemsdesktop
             * @var $itemsdesktopsmall
             * @var $itemstablet
             * @var $itemstabletsmall
             * @var $itemsmobile
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $images=$opacity=$custom_links=$custom_links_target=$img_size=$loop=$center=$nav=$dots=$autoplay=$autoplayhoverpause=$autoplaytimeout='';
            $items=$itemsdesktop=$itemsdesktopsmall=$itemstablet=$itemstabletsmall=$itemsmobile=$el_class=$css_animation=$duration=
            $atts = vc_map_get_attributes('academia_partner_carousel', $atts);
            extract($atts);
            $g5plus_options = &academia_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('academia_partner_carousel_css', plugins_url('academia-framework/includes/shortcodes/partner-carousel/assets/css/partner-carousel' . $min_suffix_css . '.css'), array(), false);
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            if ($images == '') $images = '-1,-2,-3';

            $custom_links = explode(',', $custom_links);

            $images = explode(',', $images);
            $i = -1;
            $data_carousel=array();
            $loop = ($loop == 'yes') ? 'true' : 'false';
            $center = ($center == 'yes') ? 'true' : 'false';
            $nav = ($nav == 'yes') ? 'true' : 'false';
            $dots = ($dots == 'yes') ? 'true' : 'false';
            $autoplay = ($autoplay == 'yes') ? 'true' : 'false';
            $autoplayhoverpause = ($autoplayhoverpause == 'yes') ? 'true' : 'false';
            $data_carousel[]='"loop":'.$loop;
            $data_carousel[]='"center":'.$center;
            $data_carousel[]='"nav":'.$nav;
            $data_carousel[]='"dots":'.$dots;
            $data_carousel[]='"autoplay":'.$autoplay;
            $data_carousel[]='"autoplayHoverPause":'.$autoplayhoverpause;
            $data_carousel[]='"autoplayTimeout":'.$autoplaytimeout;
            $data_carousel[]='"margin":0';
            if($items!='' && intval($items)>0)
            {
                $data_carousel[]='"items":'.$items;
                if(intval($items)>1)
                {
                    $data_responsive=array();
                    if($itemsmobile!='')
                    {
                        $data_responsive[]='"0":{"items":'.$itemsmobile.'}';
                    }
                    if($itemstabletsmall!='')
                    {
                        $data_responsive[]='"600":{"items":'.$itemstabletsmall.'}';
                    }
                    if($itemstablet!='')
                    {
                        $data_responsive[]='"768":{"items":'.$itemstablet.'}';
                    }
                    if($itemsdesktopsmall!='')
                    {
                        $data_responsive[]='"980":{"items":'.$itemsdesktopsmall.'}';
                    }
                    if($itemsdesktop!='')
                    {
                        $data_responsive[]='"1200":{"items":'.$itemsdesktop.'}';
                    }
                    $data_responsive=join(',',$data_responsive);
                    $data_carousel[]='"responsive":{'.$data_responsive.'}';
                }
                else{
                    $data_carousel[]='"responsive":{}';
                }
            }

            $data_carousel=join(',',$data_carousel);

            if ($opacity != '') {
                $opacity = ' opacity' . $opacity;
            }
            ob_start(); ?>
            <div
                class="partner-carousel <?php echo esc_attr($opacity . $g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                <div class="owl-g5plus-shortcode owl-carousel"
                     data-plugin-options='{<?php echo esc_attr($data_carousel) ?>}'>
                    <?php foreach ($images as $attach_id):
                        $i++;
                        if ($attach_id > 0) {
                            $post_thumbnail = wpb_getImageBySize(array('attach_id' => $attach_id, 'thumb_size' => $img_size));
                        } else {
                            $post_thumbnail = array();
                            $post_thumbnail['thumbnail'] = '<img src="' . vc_asset_url('vc/no_image.png') . '" />';
                            $post_thumbnail['p_img_large'][0] = vc_asset_url('vc/no_image.png');
                        }
                        $thumbnail = $post_thumbnail['thumbnail'];
                        if (isset($custom_links[$i]) && $custom_links[$i] != ''):?>
                            <a href="<?php echo esc_url($custom_links[$i]) ?>"
                               target="<?php echo esc_attr($custom_links_target) ?>">
                                <?php echo wp_kses_post($thumbnail) ?>
                            </a>
                        <?php else:
                            echo wp_kses_post($thumbnail);
                        endif;
                    endforeach; ?>
                </div>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }

    new g5plusFramework_Shortcode_Partner_Carousel();
}