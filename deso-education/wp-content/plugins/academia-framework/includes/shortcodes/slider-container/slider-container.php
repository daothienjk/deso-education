<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Slider_Container')) {
	class g5plusFramework_Shortcode_Slider_Container
	{
		function __construct()
		{
			add_shortcode('academia_slider_container', array($this, 'slider_container_shortcode'));
		}

		function slider_container_shortcode($atts, $content)
		{
			/**
			 * Shortcode attributes
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
            $loop=$center=$nav=$dots=$autoplay=$autoplayhoverpause=$autoplaytimeout=$items=$itemsdesktop=$itemsdesktopsmall=$itemstablet=$itemstabletsmall=$itemsmobile=$el_class=$css_animation=$duration=$delay='';
			$atts = vc_map_get_attributes( 'academia_slider_container', $atts );
			extract( $atts );
			$g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
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
            ob_start();?>
            <div data-plugin-options='{<?php echo esc_attr($data_carousel) ?>}' class="slider-container owl-g5plus-shortcode owl-carousel <?php echo esc_attr($g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
            <?php echo do_shortcode($content) ?>
            </div>
            <?php
            $output = ob_get_clean();
            return $output;
		}
	}
    new g5plusFramework_Shortcode_Slider_Container();
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_academia_slider_container extends WPBakeryShortCodesContainer {
    }
}