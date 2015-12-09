<?php
/**
 * Checkout coupon form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! WC()->cart->coupons_enabled() ) {
	return;
}

// $info_message = apply_filters( 'woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'woocommerce' ) . ' <a href="#" class="showcoupon">' . __( 'Click here to enter your code', 'woocommerce' ) . '</a>' );
//wc_print_notice( $info_message, 'notice' );
?>


<form class="checkout_coupon" method="post" style="">

	<p class="form-row form-row-first">
		<input type="text" name="coupon_code" class="input-text" placeholder="promotional code" id="coupon_code" value="" />
	</p>

	<p class="form-row form-row-last">
		<input type="submit" class="button styleBtn coupon-btn" name="apply_coupon" value="<?php _e( 'apply code', 'woocommerce' ); ?>" />
	</p>

	<div class="clear"></div>
</form>
