<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_ShortCode_Vertical_Progress_Bar')) {
    class g5plusFramework_ShortCode_Vertical_Progress_Bar
    {
        function __construct(){
            add_shortcode('academia_vertical_progress_bar', array($this, 'vertical_progress_bar_shortcode'));
        }
        function vertical_progress_bar_shortcode($atts){
            /**
             * Shortcode attributes
             * @var $atts
             * @var $title
             * @var $values
             * @var $units
             * @var $bgcolor
             * @var $custombgcolor
             * @var $custombgbarcolor
             * @var $customtxtcolor
             * @var $customvaluetxtcolor
             * @var $options
             * @var $el_class
             * @var $css
             * Shortcode class
             */
            $title=$values=$units=$bgcolor=$custombgcolor=$custombgbarcolor=$customtxtcolor=$customvaluetxtcolor=$options=$el_class=$css='';
	        $atts = vc_map_get_attributes( 'academia_vertical_progress_bar', $atts );
	        extract( $atts );
            $g5plus_options = &academia_get_options_config();
            $min_suffix_js = (isset($g5plus_options['enable_minifile_js']) && $g5plus_options['enable_minifile_js'] == 1) ? '.min' : '';
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_script('academia_vertical_progress_bar_js', plugins_url('academia-framework/includes/shortcodes/vertical-progress-bar/assets/js/vertical-progress-bar' . $min_suffix_js . '.js'), array('waypoints'), false, true);
            wp_enqueue_style('academia_vertical_progress_bar_css', plugins_url('academia-framework/includes/shortcodes/vertical-progress-bar/assets/css/vertical-progress-bar' . $min_suffix_css . '.css'), array(), false);
            $bar_options = array();
            $options = explode( ',', $options );
            if ( in_array( 'animated', $options ) ) {
                $bar_options[] = 'animated';
            }
            if ( in_array( 'striped', $options ) ) {
                $bar_options[] = 'striped';
            }
            if ( 'custom' === $bgcolor && '' !== $custombgcolor ) {
                $custombgcolor = ' style="' . vc_get_css_color( 'background-color', $custombgcolor ) . '"';
                if ( '' !== $customtxtcolor ) {
                    $customtxtcolor = ' style="' . vc_get_css_color( 'color', $customtxtcolor ) . '"';
                }
                if ( '' !== $customvaluetxtcolor ) {
                    $customvaluetxtcolor = ' style="' . vc_get_css_color( 'color', $customvaluetxtcolor ) . '"';
                }
                if ('' !== $custombgbarcolor) {
                    $custombgbarcolor = vc_get_css_color('background-color', $custombgbarcolor);
                }
                $bgcolor = '';
            } else {
                $custombgcolor = '';
                $custombgbarcolor = '';
                $customtxtcolor = '';
                $customvaluetxtcolor='';
                $bgcolor = 'vc_progress-bar-color-' . esc_attr( $bgcolor );
                $el_class .= ' ' . $bgcolor;
            }

            $html = '<div class="v-progress-bar ' . $el_class.'">';
            $html .= wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_progress_bar_heading' ) );
            $values = (array) vc_param_group_parse_atts( $values );
            $max_value = 0.0;
            $graph_lines_data = array();
            foreach ( $values as $data ) {
                $new_line = $data;
                $new_line['value'] = isset( $data['value'] ) ? $data['value'] : 0;
                $new_line['label'] = isset( $data['label'] ) ? $data['label'] : '';
                $new_line['bgcolor'] = isset( $data['color'] ) && 'custom' !== $data['color'] ? '' : $custombgcolor;
                $new_line['bgbarcolor'] = isset($data['color']) && 'custom' !== $data['color'] ? '' : $custombgbarcolor;
                $new_line['txtcolor'] = isset( $data['color'] ) && 'custom' !== $data['color'] ? '' : $customtxtcolor;
                $new_line['valuetxtcolor'] = isset( $data['color'] ) && 'custom' !== $data['color'] ? '' : $customvaluetxtcolor;
                if ( isset( $data['customcolor'] ) && ( ! isset( $data['color'] ) || 'custom' === $data['color'] ) ) {
                    $new_line['bgcolor'] = ' style="background-color: ' . esc_attr( $data['customcolor'] ) . ';"';
                }
                if (isset($data['custombarcolor']) && (!isset($data['color']) || 'custom' === $data['color'])) {
                    $new_line['bgbarcolor'] = ' background-color: ' . esc_attr($data['custombarcolor']) . ';';
                }
                if ( isset( $data['customtxtcolor'] ) && ( ! isset( $data['color'] ) || 'custom' === $data['color'] ) ) {
                    $new_line['txtcolor'] = ' style="color: ' . esc_attr( $data['customtxtcolor'] ) . ';"';
                }
                if ( isset( $data['customvaluetxtcolor'] ) && ( ! isset( $data['color'] ) || 'custom' === $data['color'] ) ) {
                    $new_line['valuetxtcolor'] = ' style="color: ' . esc_attr( $data['customvaluetxtcolor'] ) . ';"';
                }
                if ( $max_value < (float) $new_line['value'] ) {
                    $max_value = $new_line['value'];
                }
                $graph_lines_data[] = $new_line;
            }
            $bar_width=100 / count($values);
            foreach ( $graph_lines_data as $line ) {
                $unit = ( '' !== $units ) ? ' <span class="vc_label_units"'.(( isset($line['valuetxtcolor'])) ? $line['valuetxtcolor'] : '').'>' . $line['value'] . $units . '</span>' : '';
                $html .= '<div class="vc_general vc_single_bar' . ( ( isset( $line['color'] ) && 'custom' !== $line['color'] ) ?
                        ' vc_progress-bar-color-' . $line['color'] : '' )
                    . '" style="width:'.$bar_width.'%;'.(( isset($line['bgbarcolor'])) ? $line['bgbarcolor'] : '').'">';
                if ( $max_value > 100.00 ) {
                    $percentage_value = (float) $line['value'] > 0 && $max_value > 100.00 ? round( (float) $line['value'] / $max_value * 100, 4 ) : 0;
                } else {
                    $percentage_value = $line['value'];
                }
                $html .= '<span class="vc_bar ' . esc_attr( implode( ' ', $bar_options ) ) . '" data-percentage-value="' . esc_attr( $percentage_value ) . '" data-value="' . esc_attr( $line['value'] ) . '"' . $line['bgcolor'] . '></span>';
                $html .= '<small class="vc_label"' . $line['txtcolor'] . '>' . $line['label'] . $unit . '</small>';
                $html .= '</div>';
            }
            $html .= '</div>';
            return $html;
        }
    }
    new g5plusFramework_ShortCode_Vertical_Progress_Bar();
}