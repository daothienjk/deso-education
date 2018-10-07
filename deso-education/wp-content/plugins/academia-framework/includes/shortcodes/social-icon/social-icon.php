<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 8/17/15
 * Time: 11:37 AM
 */

// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Social_Icon')) {
    class g5plusFramework_Shortcode_Social_Icon
    {
        function __construct()
        {
            add_shortcode('academia_social_icon', array($this, 'social_icon_shortcode'));
        }
        function social_icon_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $layout_style
             * @var $values
             * @var $size
             * @var $name
             * @var $link
             * @var $color
             * @var $icon_type
             * @var $icon_image
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $layout_style=$values=$size=$name=$color=$icon_type=$icon_image=$el_class=$css_animation=$duration=$delay='';
            $atts = vc_map_get_attributes( 'academia_social_icon', $atts );
            extract( $atts );
            $g5plus_options = &academia_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('academia_social_icon_css', plugins_url('academia-framework/includes/shortcodes/social-icon/assets/css/social-icon' . $min_suffix_css . '.css'), array(), false);
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            ob_start();?>
            <ul class="social-icon <?php echo esc_attr($layout_style.' '.$size.$g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
                <?php
                    $values = (array) vc_param_group_parse_atts( $values );
                    foreach( $values as $data) {
                        $style_social_icon=$style_social_icon_border=$style_icon=$iconClass='';
                        $name = isset($data['name']) ? $data['name'] : '';
                        $link = isset($data['link']) ? $data['link'] : '';
                        $color = isset($data['color']) ? $data['color'] : '';
                        $icon_type = isset($data['icon_type']) ? $data['icon_type']:'';
                        if($icon_type!='' && $icon_type!='image')
                        {
                            vc_icon_element_fonts_enqueue( $icon_type );
                            $iconClass = isset( $data{"icon_" . $icon_type} ) ? esc_attr( $data{"icon_" . $icon_type} ) : '';
                        }
                        if($icon_type=='image'){
                            $icon_image = isset( $data['icon_image']) ? esc_attr($data['icon_image']):'';
                        }
                        ?>
                        <?php
                        $width = 100/count($values);
                        if($layout_style != 'style3'){
                            $style_social_icon = 'style = "width:'. $width .'%;"';
                        }
                        else{
                            if(!empty($color)){
                                $style_social_icon = 'style = "background-color:'.$color.'; width:'. $width .'%;"';
                                $style_social_icon_border = 'style= "border-color:'.$color.';"';
                            }
                            else{
                                $style_social_icon = 'style = "width:'. $width .'%;"';
                            }
                        }
                        if(!empty($color)) {
                            $style_icon = 'style = "background-color:'.$color.';"';
                            }
                        ?>
                        <li <?php echo wp_kses_post($style_social_icon)?> class="social-icon-item col-xs-12">
                            <a <?php echo wp_kses_post($style_social_icon_border)?> href="<?php echo esc_url($link)?>">
                                <span class="social-icon-name"><?php echo esc_html($name)?></span>
                                <?php if($layout_style == 'style1' && (!empty($name))):?>
                                <span data-lang="en" class="social-icon-name-hover chaffle" style="color: <?php echo esc_attr($color)?>;"><?php echo esc_html($name)?></span>
                                <?php endif;
                                if($layout_style != 'style1'):?>
                                    <?php if ( $icon_type != '' ) :
                                        if ( $icon_type == 'image' ) :
                                            $img = wp_get_attachment_image_src( $icon_image, 'full' );?>
                                            <div <?php echo wp_kses_post($style_icon)?> class="social-icon-img">
                                                <img alt="" src="<?php echo esc_url($img[0])?>"/>
                                            </div>
                                        <?php else :?>
                                            <i <?php echo wp_kses_post($style_icon)?> class="<?php echo esc_attr($iconClass) ?>"></i>
                                        <?php endif;
                                    endif;
                                endif;?>
                            </a>
                        </li>
                        <?php
                    }
                ?>
            </ul>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_Shortcode_Social_Icon();
}