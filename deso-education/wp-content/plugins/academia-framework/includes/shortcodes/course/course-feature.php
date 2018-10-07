<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 1/18/2016
 * Time: 2:35 PM
 */
if (!defined('ABSPATH')) die('-1');
if (!class_exists('G5PlusFramework_Course_Feature')) {
    class G5PlusFramework_Course_Feature
    {
        function __construct()
        {
            add_shortcode('academia_course_feature', array($this, 'course_feature_shortcode'));
        }

        function course_feature_shortcode($atts){
            $atts = vc_map_get_attributes( 'academia_course_feature', $atts );
            extract( $atts );
            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
            $template_path = $plugin_path . '/templates/course-feature-template.php';
            ob_start();
            if(file_exists($template_path)){
                include($template_path);
            }

            $ret = ob_get_contents();
            ob_end_clean();
            return $ret;
        }

        function academia_order_by_rating_post_clauses( $args ) {
            global $wpdb;

            $args['where'] .= " AND $wpdb->commentmeta.meta_key = 'rating' ";

            $args['join'] .= "
                LEFT JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
                LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
            ";

            $args['orderby'] = "$wpdb->commentmeta.meta_value DESC";

            $args['groupby'] = "$wpdb->posts.ID";

            return $args;
        }
    }
    new G5PlusFramework_Course_Feature();
}