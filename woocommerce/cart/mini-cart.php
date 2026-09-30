<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<ul class="woocommerce-mini-cart cart_list product_list_widget list-none p-0 m-0 space-y-4">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail', array('class' => 'w-16 h-16 object-cover bg-surface-container-low border border-surface-container')), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item flex items-start gap-4', $cart_item, $cart_item_key ) ); ?>">
					
					<?php if ( empty( $product_permalink ) ) : ?>
						<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php else : ?>
						<a href="<?php echo esc_url( $product_permalink ); ?>">
							<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</a>
					<?php endif; ?>

                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <h4 class="font-body-sm font-bold text-on-surface m-0 pr-2">
                                <?php if ( empty( $product_permalink ) ) : ?>
                                    <?php echo wp_kses_post( $product_name ); ?>
                                <?php else : ?>
                                    <a class="text-on-surface hover:text-secondary transition-colors" href="<?php echo esc_url( $product_permalink ); ?>">
                                        <?php echo wp_kses_post( $product_name ); ?>
                                    </a>
                                <?php endif; ?>
                            </h4>
                            
                            <?php
                            echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                'woocommerce_cart_item_remove_link',
                                sprintf(
                                    '<a href="%s" class="remove remove_from_cart_button text-error hover:text-red-700 transition-colors" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><span class="material-symbols-outlined text-[20px]">delete</span></a>',
                                    esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                    /* translators: %s is the product name */
                                    esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
                                    esc_attr( $product_id ),
                                    esc_attr( $cart_item_key ),
                                    esc_attr( $_product->get_sku() )
                                ),
                                $cart_item_key
                            );
                            ?>
                        </div>
                        
                        <div class="text-xs text-secondary mt-1">
                            <?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                        
                        <div class="mt-2 text-on-surface font-label-numeric flex items-center gap-2">
                            <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity font-body-sm">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    </div>
				</li>
				<?php
			}
		}

		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</ul>

	<p class="woocommerce-mini-cart__total total flex justify-between items-center py-4 border-t border-surface-container mt-6 mb-3">
		<?php
		/**
		 * Hook: woocommerce_widget_shopping_cart_total.
		 *
		 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
		 */
		do_action( 'woocommerce_widget_shopping_cart_total' );
		?>
	</p>

    <?php
    $discount_pct = (float) get_option( 'transfer_discount_percentage', 5 );
    if ( $discount_pct > 0 && ! WC()->cart->is_empty() ) :
        $cart_subtotal = (float) WC()->cart->get_subtotal();
        if ( $cart_subtotal > 0 ) :
            $transfer_total = $cart_subtotal * ( ( 100 - $discount_pct ) / 100 );
            $savings        = $cart_subtotal - $transfer_total;
            $pct_label      = rtrim( rtrim( number_format( $discount_pct, 1 ), '0' ), '.' );
    ?>
    <div class="gs-mini-cart-transfer-incentive bg-surface-container-low p-3 mb-4 flex items-center justify-between text-secondary font-body-sm text-[12px] border-l-2 border-primary">
        <div>
            <span class="text-on-surface font-medium block">o <?php echo wc_price( $transfer_total ); ?> con transferencia</span>
            <span class="text-[11px] text-secondary">Ahorrás <?php echo wc_price( $savings ); ?> (<?php echo esc_html( $pct_label ); ?>% OFF)</span>
        </div>
        <span class="material-symbols-outlined text-on-surface text-xl">account_balance</span>
    </div>
    <?php 
        endif;
    endif; 
    ?>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<p class="woocommerce-mini-cart__buttons buttons flex flex-col gap-2 m-0">
		<?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?>
	</p>

	<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

<?php else : ?>

	<div class="flex flex-col items-center justify-center text-center py-12">
        <span class="material-symbols-outlined text-[48px] text-surface-container-highest mb-4">production_quantity_limits</span>
        <p class="woocommerce-mini-cart__empty-message font-body-md text-secondary m-0"><?php esc_html_e( 'No products in the cart.', 'woocommerce' ); ?></p>
    </div>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
