<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Icon_Box')) {
	class g5plusFramework_Shortcode_Icon_Box
	{
		function __construct()
		{
			add_shortcode('academia_icon_box', array($this, 'icon_box_shortcode'));
		}
		function icon_box_shortcode($atts)
		{
			/**
			 * Shortcode attributes
			 * @var $layout_style
			 * @var $icon_type
			 * @var $icon_image
             * @var $icon_color
             * @var $icon_bg_color
			 * @var $link
			 * @var $title
			 * @var $description
             * @var $color_scheme
			 * @var $el_class
			 * @var $css_animation
			 * @var $duration
			 * @var $delay
			 */
			$layout_style=$color_scheme=$icon_type=$icon_color=$icon_bg_color=$icon_image=$link=$title=$description=$el_class=$css_animation=$duration=$delay=$iconClass='';
			$atts = vc_map_get_attributes( 'academia_icon_box', $atts );
			extract( $atts );
			$g5plus_animation = esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            if($icon_type!='' && $icon_type!='image')
            {
                vc_icon_element_fonts_enqueue( $icon_type );
                $iconClass = isset( ${"icon_" . $icon_type} ) ? esc_attr( ${"icon_" . $icon_type} ) : '';
            }
            //parse link
            $link = ( $link == '||' ) ? '' : $link;
            $link = vc_build_link( $link );

            $a_href='#';
            $a_target = '_self';
            $a_title = $title;

            if ( strlen( $link['url'] ) > 0 ) {
                $a_href = $link['url'];
                $a_title = $link['title'];
                $a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
            }
            $g5plus_options = &academia_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('academia_icon_box_css', plugins_url('academia-framework/includes/shortcodes/icon-box/assets/css/icon-box' . $min_suffix_css . '.css'), array(), false);

            $icon_box_class = array('iconbox' , $layout_style,$color_scheme, $g5plus_animation);

            ob_start();?>
			<div class="<?php echo join(' ',$icon_box_class)?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
                <div<?php $this->bg_color_style($icon_bg_color,$layout_style) ?>>
                    <?php if ( $icon_type != '' ) :
                        if ( $icon_type == 'image' ) :
                            $img = wp_get_attachment_image_src( $icon_image, 'full' );?>
                            <img alt="" src="<?php echo esc_url($img[0])?>"/>
                        <?php else :?>
                            <i<?php $this->icon_color_style($icon_color) ?> class="<?php echo esc_attr($iconClass) ?>"></i>
                        <?php endif;
                    endif;?>
                </div>
                <?php if(!empty($title)):?>
                <a class="p-font heading-color" title="<?php echo esc_attr($a_title ); ?>" target="<?php echo esc_attr( $a_target ); ?>" href="<?php echo  esc_url($a_href) ?>"><?php echo esc_html($title) ?></a>
                <?php endif;
                if(!empty($description)):?>
                <p><?php echo wp_kses_post($description) ?></p>
                <?php endif;?>
			</div>
            <?php
            $content = ob_get_clean();
            return $content;
		}
        function bg_color_style($color,$layout_style)
        {
            if($color!='')
            {
                if($layout_style=='style2')
                {
                    echo ' style="background-color: '.$color.'; color:'.$color.'"';
                }
                else{
                    echo ' style="background-color: '.$color.'"';
                }
            }
        }
        function icon_color_style($color)
        {
            if($color!='')
            {
                echo ' style="color: '.$color.'"';
            }
        }
	}
    new g5plusFramework_Shortcode_Icon_Box();
}