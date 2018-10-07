<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 9/26/15
 * Time: 3:04 PM
 */

class G5Plus_Widget_Payment_Gate extends  g5plus_acf_widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-payment-gate';
        $this->widget_description = esc_html__( "Display logo payment gates that declare in Theme Option", 'g5plus-academia' );
        $this->widget_id          = 'g5plus-payment-gate';
        $this->widget_name        = esc_html__( 'G5Plus: Payment Gate', 'g5plus-academia' );
        $this->settings           = array(
            'id'          => 'payment_gates_acf',
            'type'        => 'rows',
            'title'       => esc_html__('Payment gate', 'g5plus-academia'),
            'subtitle'    => esc_html__('Unlimited Payment gate logo with drag and drop sortings.', 'g5plus-academia'),
            'fields'      => array(
                array(
                    'name' => 'payment_gate_name',
                    'title' => 'Payment gate name',
                    'type'  => 'text',
                    'is_title_block' => 1
                ),
                array(
                    'name' => 'payment_gate_link',
                    'title' => 'Payment gate link',
                    'type'  => 'text'
                ),
                array(
                    'name' => 'payment_gate_logo',
                    'title' => 'Logo',
                    'type'  => 'image'
                ),
            )
        );
        parent::__construct();
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        $widget_id = $args['widget_id'];
        $payment_gates = array_key_exists('fields',$instance) ? $instance['fields'] : array() ;
        echo wp_kses_post($before_widget);

        ?>
        <ul class="payment-gate">
           <?php if(isset($payment_gates) && is_array($payment_gates)){
                    foreach($payment_gates as $gate ){ ?>
                    <li>
                        <a target="_blank" href="<?php echo esc_attr($gate['payment_gate_link']) ?>" title="<?php echo esc_attr($gate['payment_gate_name']) ?>">
                            <img src="<?php echo esc_url($gate['payment_gate_logo']['url'])?>" alt="<?php echo esc_attr($gate['payment_gate_name']) ?>" />
                        </a>
                    </li>
           <?php
               }
            } ?>
        </ul>
        <?php
        echo wp_kses_post($after_widget);
    }
}
if (!function_exists('g5plus_register_widget_payment_gate')) {
    function g5plus_register_widget_payment_gate() {
        register_widget('G5Plus_Widget_Payment_Gate');
    }
    add_action('widgets_init', 'g5plus_register_widget_payment_gate', 1);
}