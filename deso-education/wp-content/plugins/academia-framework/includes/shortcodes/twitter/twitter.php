<?php
if ( ! defined( 'ABSPATH' ) ) die( '-1' );

if(!class_exists('G5PlusFramework_Twitter')){
    class G5PlusFramework_Twitter {
        function __construct() {
            add_shortcode('academia_twitter_shortcode', array($this, 'academia_twitter_shortcode' ));
            $this->includes();
        }

        function academia_twitter_shortcode($atts){
            $atts = vc_map_get_attributes( 'academia_twitter_shortcode', $atts );
            extract( shortcode_atts( array(
                'twitter_user_name' => '',
                'twitter_consumer_key' => '',
                'twitter_consumer_secret' => '',
                'twitter_access_token' => '',
                'twitter_access_token_secret' => '',
                'time_to_store' => '',
                'total_feed' => '',
                'paging_style' =>'',
                'css_animation' => '',
                'duration'      => '',
                'delay'         => '',
                'css'      => ''
            ), $atts ) );
            $plugin_path =  untrailingslashit( plugin_dir_path( __FILE__ ) );
            $template_path = $plugin_path . '/templates/lastest-feed.php';

            ob_start();
            include($template_path);
            $ret = ob_get_contents();
            ob_end_clean();
            return $ret;
        }

        private function includes(){
            include_once('utils/twitterclient.php');
        }
    }

    new G5PlusFramework_Twitter();
}