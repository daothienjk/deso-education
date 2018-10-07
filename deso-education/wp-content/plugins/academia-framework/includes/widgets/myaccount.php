<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/2/2015
 * Time: 11:48 AM
 */
class G5Plus_Widget_MyAccount extends G5Plus_Widget {
	public function __construct() {
		$this->widget_cssclass    = 'widget-my-account';
		$this->widget_description = esc_html__( "My Account Link Widget", 'g5plus-academia' );
		$this->widget_id          = 'g5plus-my-account';
		$this->widget_name        = esc_html__( 'G5Plus: My Account', 'g5plus-academia' );
		$this->settings           = array(
			'login_text' => array(
				'type' => 'text',
				'std' => 'Login',
				'label' => esc_html__('Login Text','g5plus-academia')
			),
			'logout_text' => array(
				'type' => 'text',
				'std' => 'Logout',
				'label' => esc_html__('Logout Text','g5plus-academia')
			),
		);
		parent::__construct();
	}

	function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) )
			return;

		extract( $args, EXTR_SKIP );
		$login_text = ( ! empty( $instance['login_text'] ) ) ? $instance['login_text'] : '';
		$logout_text = ( ! empty( $instance['logout_text'] ) ) ? $instance['logout_text'] : '';
		$login_url = '';
		if (class_exists( 'WooCommerce' ) ) {
			$myaccount_page_id = wc_get_page_id('myaccount');
			if ( $myaccount_page_id > 0 ) {
				$login_url = get_permalink( $myaccount_page_id );
			}
			else {
				$login_url = wp_login_url( get_permalink() );
			}
		}
		else {
			$login_url = wp_login_url( get_permalink() );
		}

		ob_start();
		echo wp_kses_post($args['before_widget']);
		?>
			<?php if ( !is_user_logged_in() ):?>
				<a href="<?php echo esc_url($login_url) ?>"><?php echo esc_html($login_text) ?></a>
			<?php else: ?>
				<a href="<?php echo esc_url(wp_logout_url(is_home()? home_url() : get_permalink()) ); ?>"><?php echo esc_html($logout_text) ?></a>
			<?php endif; ?>
		<?php
		echo wp_kses_post($args['after_widget']);
		$content =  ob_get_clean();
		echo wp_kses_post($content);
		$this->cache_widget( $args, $content );
	}
}

if (!function_exists('g5plus_register_widget_my_account')) {
	function g5plus_register_widget_my_account() {
		register_widget('G5Plus_Widget_MyAccount');
	}
	add_action('widgets_init', 'g5plus_register_widget_my_account', 1);
}