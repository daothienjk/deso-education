<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();


if (WC()->cart->coupons_enabled() || !(is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' )) ) {
	echo '<div class="row checkout-before-form">';
}

do_action( 'woocommerce_before_checkout_form', $checkout );

if (WC()->cart->coupons_enabled() || !(is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' )) ) {
	echo '</div>';
}

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', esc_html__( 'You must be logged in to checkout.', 'g5plus-academia' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="row" id="customer_details">
			<div class="col-md-6 margin-bottom-50">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div class="col-md-6 margin-bottom-50">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

		<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'g5plus-academia' ); ?></h3>

	<?php endif; ?>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
