<?php
/**
 * Variable product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $post;
?>

<script>
  (function($){
//    $(document).ready(function(){
//      var $sizeStyledWrapper = $('#styles_pa_size');
//      var $sizeSelect = $('#pa_size');
//      //$sizeSelect.hide();
//     // $sizeStyledWrapper.hide();
//
//      $sizeSelect.find('option').each(function(){
//        var value = $(this).val();
//        if ( ! value.length ) return;
//        var html = '<button type="button" class="sizeBtnSelector" id="size_' + value + '" data-val="' + value + '">' + value + '</button>';
//        $('#sizesWrapper').append(html);
//      });
//
//      //$variation_form = $(this).closest('form.variations_form');
//
//      $('.sizeBtnSelector').on('click', function(){
//        $('.sizeBtnSelector').removeClass('active');
//        $(this).addClass('active');
//        var value = $(this).data('val');
//        $sizeSelect.val(value);//.change();
//
//        $sizeSelect
//          .trigger( 'click' );
//
//
//
//
//        console.log($sizeSelect.val());
//      });
//
//    });

  })(jQuery);
</script>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>


<p class="select-color-size">Select size and color</p>
<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php if ( ! empty( $available_variations ) ) : ?>
		<table class="variations" cellspacing="0">
			<tbody>
          <tr><td class="value" id="sizesWrapper"></td></tr>
				<?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++;?>
					<tr>
						<!--<td class="label"><label for="<?php echo sanitize_title( $name ); ?>"><?php echo wc_attribute_label( $name ); ?></label></td>-->
						<td class="value">
              <div class="styled-select" id="styles_<?php echo esc_attr( sanitize_title( $name ) ); ?>">
              <select id="<?php echo esc_attr( sanitize_title( $name ) ); ?>" name="attribute_<?php echo sanitize_title( $name ); ?>" data-attribute_name="attribute_<?php echo sanitize_title( $name ); ?>">
							<option value="">&nbsp;&nbsp;<?php echo 'Choose ' . wc_attribute_label( $name ) ?>&hellip;</option>
							<?php
								if ( is_array( $options ) ) {

									if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
										$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
									} elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
										$selected_value = $selected_attributes[ sanitize_title( $name ) ];
									} else {
										$selected_value = '';
									}

									// Get terms if this is a taxonomy - ordered
									if ( taxonomy_exists( $name ) ) {

										$terms = wc_get_product_terms( $post->ID, $name, array( 'fields' => 'all' ) );

										foreach ( $terms as $term ) {
											if ( ! in_array( $term->slug, $options ) ) {
												continue;
											}
											echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>&nbsp;&nbsp;' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
										}

									} else {

										foreach ( $options as $option ) {
											echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>&nbsp;&nbsp;' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
										}

									}
								}
							?>
						</select>
            </div>
            <?php
							if ( sizeof( $attributes ) === $loop ) {
								//echo '<a class="reset_variations" href="#reset">' . __( 'Clear selection', 'woocommerce' ) . '</a>';
							}
						?>
            <?php if( $name == 'pa_size' ) { ?>
              <a href="<?php echo get_field('file_with_sizes')['url'] ?>" class="measurements zoom first" rel="prettyPhoto">Measurements</a>
            <?php } ?>
            </td>
					</tr>
		        <?php endforeach;?>
			</tbody>
		</table>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap" style="display:block;">
			<?php do_action( 'woocommerce_before_single_variation' ); ?>

			<div class="single_variationADDEDREMOVE"></div>

			<div class="variations_button" style="display: block;">
				<?php

        $product = $GLOBALS['product'];

        $defaults = array(
          'input_name'  	=> 'quantity',
          'input_value'  	=> '1',
          'max_value'  	=> apply_filters( 'woocommerce_quantity_input_max', '', $product ),
          'min_value'  	=> apply_filters( 'woocommerce_quantity_input_min', '', $product ),
          'step' 			=> apply_filters( 'woocommerce_quantity_input_step', '1', $product )
        );

        $args = apply_filters( 'woocommerce_quantity_input_args', wp_parse_args( $args, $defaults ), $product );
?>

        <div class="quantity">
          <input class="minus qtyPMBtns" id="jsMinusBtn" type="button" value="">
          <input type="text" min="1" max="1" step="<?php echo esc_attr( $defaults['step'] ); ?>" <?php if ( is_numeric( $defaults['min_value'] ) ) : ?>min="<?php echo esc_attr( $defaults['min_value'] ); ?>"<?php endif; ?> <?php if ( is_numeric( $defaults['max_value'] ) ) : ?>max="<?php echo esc_attr( $defaults['max_value'] ); ?>"<?php endif; ?> name="<?php echo esc_attr( $defaults['input_name'] ); ?>" value="<?php echo esc_attr( $defaults['input_value'] ); ?>" title="<?php _ex( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="input-text qty text" id="jsQtyInput" size="4" />
          <input class="plus qtyPMBtns" id="jsPlusBtn" type="button" value="">
        </div>


        <script>
          jQuery(document).ready(function(){
            jQuery('#jsPlusBtn').on('click', function(){
              var $input = jQuery('#jsQtyInput');
              var max = $input.attr('max');
              var curValue = parseInt($input.val());


              // var newValue = Math.min(max, curValue+1);
              var newValue = curValue+1;


              $input.val(newValue);
            });
            jQuery('#jsMinusBtn').on('click', function(){
              var $input = jQuery('#jsQtyInput');
              var min = $input.attr('min');
              var curValue = parseInt($input.val());
              var newValue = Math.max(0, curValue-1);
              $input.val(newValue);
            });

          });
        </script>
  <?php
				//woocommerce_quantity_input(); ?>
				<button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
        <?php
        /**
         * woocommerce_before_single_product hook
         *
         * @hooked wc_print_notices - 10
         */
        do_action( 'woocommerce_before_single_product' );
        ?>
			</div>
			<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
			<input type="hidden" name="variation_id" class="variation_id" value="" />

			<?php do_action( 'woocommerce_after_single_variation' ); ?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php else : ?>

		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>

	<?php endif; ?>

</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
