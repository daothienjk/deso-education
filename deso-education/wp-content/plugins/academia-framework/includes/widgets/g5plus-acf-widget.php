<?php
/**
 * Abstract G5Plus Widget Class
 *
 * @author      G5PlusThemes
 * @category    Widgets
 * @package     G5PlusThemes/Abstracts
 * @version     1.0.0
 * @extends     WP_Widget
 */
include_once( PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/widgets/fields/g5plus-acf.php' );

abstract class g5plus_acf_widget extends WP_Widget {
    public $widget_cssclass;
    public $widget_description;
    public $widget_id;
    public $settings;

    /**
     * Constructor
     */
    public function __construct() {
        $widget_ops = array(
            'classname'   => $this->widget_cssclass,
            'description' => $this->widget_description
        );
        parent::__construct( $this->widget_id, $this->widget_name, $widget_ops );

    }

    /**
     * update function.
     *
     * @see WP_Widget->update
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        if ( ! $this->settings ) {
            return $instance;
        }
        $instance = array();
        error_log(serialize($new_instance));
        foreach($new_instance['fields'] as $index => $value){

            foreach ( $this->settings['fields'] as $key => $setting ) {
                if ( isset( $new_instance['fields'][$index][ $setting['name'] ] ) ) {
                    if ( current_user_can('unfiltered_html') ) {
                        $instance['fields'][$index][$setting['name']] = $value[$setting['name']];
                    }
                    else {
                        $instance['fields'][$index][$setting['name']] =  stripslashes( wp_filter_post_kses( addslashes($value[$setting['name']]) ) );
                    }
                }
            }
        }
        foreach($new_instance as $key => $value){
            if($key!='fields'){
                $instance[$key] = $new_instance[$key];
            }
        }
        error_log(serialize($instance));
        return $instance;
    }

    /**
     * form function.
     *
     * @see WP_Widget->form
     * @param array $instance
     */
    public function form( $instance ) {

        if ( ! $this->settings && !isset($this->settings['fields'])) {
            return;
        }
        $acf_widget_fields = new g5plus_acf_widget_fields($this, $instance);
        $acf_widget_fields->render();
    }
}