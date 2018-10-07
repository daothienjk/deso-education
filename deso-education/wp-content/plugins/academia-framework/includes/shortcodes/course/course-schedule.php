<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 1/18/2016
 * Time: 2:35 PM
 */
if (!defined('ABSPATH')) die('-1');
if (!class_exists('G5PlusFramework_Course_Schedule')) {
    class G5PlusFramework_Course_Schedule
    {
        function __construct()
        {
            add_shortcode('academia_course_schedule', array($this, 'course_schedule_shortcode'));
        }

        function course_schedule_shortcode($atts){
            $atts = vc_map_get_attributes( 'academia_course_schedule', $atts );
            extract( $atts );

            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
            $template_path = $plugin_path . '/templates/course-schedule-template.php';
            ob_start();
            if(file_exists($template_path)){
                include($template_path);
            }

            $ret = ob_get_contents();
            ob_end_clean();
            return $ret;
        }
    }
    new G5PlusFramework_Course_Schedule();
}