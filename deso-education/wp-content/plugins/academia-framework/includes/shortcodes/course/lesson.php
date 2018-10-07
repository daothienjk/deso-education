<?php
if (!defined('ABSPATH')) die('-1');
if (!class_exists('G5PlusFramework_Course_Lesson')) {
    class G5PlusFramework_Course_Lesson
    {
        function __construct()
        {
            add_shortcode('academia_course_lesson', array($this, 'lesson_shortcode'));
        }

        function lesson_shortcode($atts, $content){
            $atts = vc_map_get_attributes( 'academia_course_lesson', $atts );
            extract( $atts );
            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
            $template_path = $plugin_path . '/templates/lesson-template.php';
            ob_start();
            if(file_exists($template_path)){
                include($template_path);
            }
            $ret = ob_get_contents();
            ob_end_clean();
            return $ret;
        }
    }
    new G5PlusFramework_Course_Lesson();
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_academia_course_lesson extends WPBakeryShortCode {
    }
}