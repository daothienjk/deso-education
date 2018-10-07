<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 1/18/2016
 * Time: 2:35 PM
 */
if (!defined('ABSPATH')) die('-1');
if (!class_exists('G5PlusFramework_Course_Search')) {
    class G5PlusFramework_Course_Search
    {
        function __construct()
        {
            add_shortcode('academia_course_search', array($this, 'course_search_shortcode'));
            //add query vars
            add_filter('query_vars', array($this,'course_search_add_queryvars') );
        }

        function course_search_shortcode($atts){
            $this->front_scripts();
            $atts = vc_map_get_attributes( 'academia_course_search', $atts );
            extract( $atts );
            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
            $template_path = $plugin_path . '/templates/'.$style.'.php';
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
            wp_enqueue_script('academia-course-search', plugins_url() . '/academia-framework/includes/shortcodes/course/assets/js/course-search' . $min_suffix . '.js', false, true);

        }
        function course_search_add_queryvars($query) {
            if (is_search() && !is_admin() ) {
                if(isset($_GET['post_type'])) {
                    $type = $_GET['post_type'];
                    if($type == 'course') {
                        $query->set('post_type',array('product'));
                    }
                }
            }
            return $query;
        }

    }
    new G5PlusFramework_Course_Search();
}