<?php
/**
 * Cart totals
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="cart_totals <?php if ( WC()->customer->has_calculated_shipping() ) echo 'calculated_shipping'; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

<!--	<h2>--><?php //_e( 'Cart Totals', 'woocommerce' ); ?><!--</h2>-->

	<table cellspacing="0" class="cart-total-s">

		<tr class="cart-subtotal">
      <td class="frst_td"></td>
			<th style="padding-bottom: 7px"><?php _e( 'Subtotal', 'woocommerce' ); ?></th>
			<td style="padding-bottom: 7px"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( $code ); ?>">
        <td class="frst_td"></td>
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
        <td class="frst_td"></td>
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->tax_display_cart == 'excl' ) : ?>
			<?php if ( get_option( 'woocommerce_tax_total_display' ) == 'itemized' ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
            <td class="frst_td"></td>
						<th><?php echo esc_html( $tax->label ); ?></th>
						<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
          <td class="frst_td"></td>
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
					<td><?php echo wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

    <tr class="order-total">
      <td class="frst_td"></td>
      <th style="padding-top: 7px;"><?php _e( 'Total', 'woocommerce' ); ?></th>
      <td style="padding-top: 7px;"><?php echo  WC()->cart->get_total(); ?></td>
    </tr>
    <tr class="incl_vat_sm">
      <td class="frst_td"></td>
    <th style="padding-top: 7px;padding-bottom: 7px">VAT</th>
    <td style="padding-top: 7px;padding-bottom: 7px">
      <?php
      // If prices are tax inclusive, show taxes here
      if ( wc_tax_enabled() && WC()->cart->tax_display_cart == 'incl' ) {
        $tax_string_array = array();

        if ( get_option( 'woocommerce_tax_total_display' ) == 'itemized' ) {
          foreach ( WC()->cart->get_tax_totals() as $code => $tax )
            $tax_string_array[] = sprintf( '%s %s', $tax->formatted_amount, $tax->label );
        } else {
          $tax_string_array[] = sprintf( '%s %s', wc_price( WC()->cart->get_taxes_total( true, true ) ), WC()->countries->tax_or_vat() );
        }

        if ( ! empty( $tax_string_array ) )
          echo '<span class="includes_tax">' . sprintf( __( '%s', 'woocommerce' ), rtrim(implode( ', ', $tax_string_array ), " VAT") ) . '</span>';
      }
      ?>
    </td>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</table>

	<?php if ( WC()->cart->get_cart_tax() ) : ?>
		<p><small><?php

			$estimated_text = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
				? sprintf( ' ' . __( ' (taxes estimated for %s)', 'woocommerce' ), WC()->countries->estimated_for_prefix() . __( WC()->countries->countries[ WC()->countries->get_base_country() ], 'woocommerce' ) )
				: '';

			//printf( __( 'Note: Shipping and taxes are estimated%s and will be updated during checkout based on your billing and shipping information.', 'woocommerce' ), $estimated_text );

		?></small></p>
	<?php endif; ?>

	<div class="wc-proceed-to-checkout">
	<a href="" id="updateCartBtn" class="checkout-button button alt wc-forward">Update cart</a>
	<a href="/shop" class='cont-shop'>continue shoping</a>
    
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
<script>
  (function($){
    $(document).ready(function(){

      $("#updateCartBtn").on('click', function(e){
        e.preventDefault();
        $('#ufBtn').trigger('click');
      });
    });
  })(jQuery);
</script>