<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 12/22/15
 * Time: 11:22 AM
 */
if (!defined('ABSPATH')) die('-1');
if (!class_exists('G5PlusFramework_Course_Section')) {
    class G5PlusFramework_Course_Section
    {
        function __construct()
        {
            add_shortcode('academia_course_sections', array($this, 'section_shortcode'));
        }

        function section_shortcode($atts, $content){
            extract( shortcode_atts( array(
                'title' => ''
            ), $atts ) );

            $accordeon_id = rand(0,9999);

            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
            $template_path = $plugin_path . '/templates/section-template.php';
            ob_start();
            if(file_exists($template_path)){

                include($template_path);
            }

            $ret = ob_get_contents();
            ob_end_clean();
            return $ret;
        }
    }
    new G5PlusFramework_Course_Section();
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_academia_course_sections extends WPBakeryShortCodesContainer {
    }
}
?>