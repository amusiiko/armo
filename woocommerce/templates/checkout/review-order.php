<?php
/**
 * Review order table
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="shop_table woocommerce-checkout-review-order-table">

<table class="order_items">
<!--	<thead>-->
<!--		<tr>-->
<!--			<th class="product-name">--><?php //_e( 'Product', 'woocommerce' ); ?><!--</th>-->
<!--			<th class="product-total">--><?php //_e( 'Total', 'woocommerce' ); ?><!--</th>-->
<!--		</tr>-->
<!--	</thead>-->
	<tbody>
		<?php
			do_action( 'woocommerce_review_order_before_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
						<td class="product-name">
              <?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <span class="product-quantity">' . sprintf( '%sx', $cart_item['quantity'] ) . '</span>', $cart_item, $cart_item_key ); ?> <?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ); ?>,

							<?php echo WC()->cart->get_item_data( $cart_item ); ?>
						</td>
						<td class="product-total">
							<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
						</td>
					</tr>
					<?php
				}
			}

			do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
</table>
<hr class="checkoutHr">
<table class="order_totals_table">

		<tr class="cart-subtotal">
      <td class="frst_td"></td>
			<th>Subtotal<?php //_e( 'Cart Subtotal', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( $code ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
<!--			<tr class="fee">-->
<!--				<th>--><?php //echo esc_html( $fee->name ); ?><!--</th>-->
<!--				<td>--><?php //wc_cart_totals_fee_html( $fee ); ?><!--</td>-->
<!--			</tr>-->
		<?php endforeach; ?>

		<?php if ( WC()->cart->tax_display_cart === 'excl' ) : ?>
			<?php if ( get_option( 'woocommerce_tax_total_display' ) === 'itemized' ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
<!--					<tr class="tax-rate tax-rate---><?php //echo sanitize_title( $code ); ?><!--">-->
<!--						<th>--><?php //echo esc_html( $tax->label ); ?><!--</th>-->
<!--						<td>--><?php //echo wp_kses_post( $tax->formatted_amount ); ?><!--</td>-->
<!--					</tr>-->
				<?php endforeach; ?>
			<?php else : ?>
<!--				<tr class="tax-total">-->
<!--					<th>--><?php //echo esc_html( WC()->countries->tax_or_vat() ); ?><!--</th>-->
<!--					<td>--><?php //echo wc_price( WC()->cart->get_taxes_total() ); ?><!--</td>-->
<!--				</tr>-->
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<tr class="order-total">
      <td class="frst_td"></td>
			<th><?php _e( 'Total', 'woocommerce' ); ?></th>
			<td><?php echo  WC()->cart->get_total(); ?></td>
    </tr>
    <tr>
      <td class="frst_td"></td>
      <th>VAT</th>
      <td>
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
    </tr>




		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

</table>

</div>