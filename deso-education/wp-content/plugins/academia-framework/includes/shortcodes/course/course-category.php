<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 1/18/2016
 * Time: 2:35 PM
 */
if (!defined('ABSPATH')) die('-1');
if (!class_exists('G5PlusFramework_Course_Category')) {
    class G5PlusFramework_Course_Category
    {
        function __construct()
        {
            add_shortcode('academia_course_category', array($this, 'course_category_shortcode'));
        }

        function course_category_shortcode($atts){
            $this->front_scripts();
            $atts = vc_map_get_attributes( 'academia_course_category', $atts );
            extract( $atts );
            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
            $template_path = $plugin_path . '/templates/course-category-template.php';
            ob_start();
            if(file_exists($template_path)){
                include($template_path);
            }

            $ret = ob_get_contents();
            ob_end_clean();
            return $ret;
        }

        function front_scripts()
        {
            $g5plus_options = &G5Plus_Global::get_options();
            $min_suffix = (isset($g5plus_options['enable_minifile_js']) && $g5plus_options['enable_minifile_js'] == 1) ? '.min' : '';
            wp_enqueue_script('academia-tooltipsy', plugins_url() . '/academia-framework/includes/shortcodes/course/assets/js/tooltipsy.min.js', false, true);
            wp_enqueue_script('academia-course-shortcode', plugins_url() . '/academia-framework/includes/shortcodes/course/assets/js/course-shortcode' . $min_suffix . '.js', false, true);

        }
    }
    new G5PlusFramework_Course_Category();
}