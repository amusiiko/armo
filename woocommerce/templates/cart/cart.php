<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>
<script type="text/javascript">
	
	jQuery(document).ready(function(){
		console.log('som red');
		console.log(jQuery('.woocommerce-error'));
		jQuery('.woocommerce-error .wc-forward').hide();
	});
</script>
<form id='cartFormik' action="<?php //$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; echo $actual_link . "#updated"

echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-name"><?php _e( 'name', 'woocommerce' ); ?><div class="vert-hr"></div></th>
			
			<th class="product-colour" style="padding-left: 60px;padding-right: 60px;"><?php _e( 'colour', 'woocommerce' ); ?><div class="vert-hr"></div></th>
			<th class="product-size" style="padding-left: 50px;padding-right: 50px;"><?php _e( 'size', 'woocommerce' ); ?><div class="vert-hr"></div></th>
			<th class="product-quantity" style="padding-left: 30px;padding-right: 30px;"><?php _e( 'quantity', 'woocommerce' ); ?><div class="vert-hr"></div></th>
			<th class="product-subtotal" style="padding-left: 20px;"><?php _e( 'price', 'woocommerce' ); ?></th>
			<th class="product-remove">&nbsp;</th>
		</tr>
		<tr>
			<td colspan="6" style="height: 20px;"></td>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">




					<td class="product-name">
						<?php
							if ( ! $_product->is_visible() )
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
							else
								//echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink( $cart_item ), $_product->get_title() ), $cart_item, $cart_item_key );
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '%2$s', $_product->get_permalink( $cart_item ), $_product->get_title() ), $cart_item, $cart_item_key );
							// Meta data
							//echo WC()->cart->get_item_data( $cart_item );

               				// Backorder notification
               				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
               					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
						?>
					</td>
          <td style="text-align: center !important;">
            <?php echo $cart_item['variation']['attribute_pa_color'] ?>

					</td>
          <td style="text-align: center !important;">
            <?php echo $cart_item['variation']['attribute_pa_size'] ?>
          </td>

<!--					<td class="product-price">-->
<!--						--><?php
//							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
//						?>
<!--					</td>-->

					<td class="product-quantity">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0'
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
						?>
					</td>

					<td class="product-subtotal">
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</td>

          <td class="product-remove">
            <?php
            echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s#updated" class="remove removeFromCart" title="%s"></a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
            ?>
          </td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions">

				<?php if ( WC()->cart->coupons_enabled() ) { ?>
					<!-- <div class="coupon">

						<label for="coupon_code"><?php _e( 'Coupon', 'woocommerce' ); ?>:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>" />

						<?php do_action( 'woocommerce_cart_coupon' ); ?>

					</div> -->
				<?php } ?>

				<input type="submit" class="button" id="ufBtn" name="update_cart" style="display: none;" value="<?php _e( 'Update Cart', 'woocommerce' ); ?>" />

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</td>
		</tr>

		<tr>
			<td colspan="6" style="height: 20px;"></td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<div class="cart-collaterals">

	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

	<?php woocommerce_cart_totals(); ?>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
