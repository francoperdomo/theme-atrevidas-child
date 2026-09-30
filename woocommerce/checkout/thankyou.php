<?php
/**
 * Thankyou page — Grow Socks override
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order max-w-4xl mx-auto px-4 py-8 md:py-16">
	<div class="bg-surface-container-low p-6 md:p-12">

		<?php if ( $order ) :

			do_action( 'woocommerce_before_thankyou', $order->get_id() );
			?>

			<?php if ( $order->has_status( 'failed' ) ) : ?>

				<div class="flex items-center gap-3 mb-6">
					<span class="material-symbols-outlined text-error">error</span>
					<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed font-body-md text-error m-0">
						<?php esc_html_e( 'Lamentablemente tu pedido no pudo procesarse. El banco o comercio rechazó la transacción. Por favor intentá nuevamente.', 'woocommerce' ); ?>
					</p>
				</div>

				<div class="flex flex-col md:flex-row gap-3">
					<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>"
					   class="gs-thankyou-actions"><span class="gs-btn-primary block text-center py-4 px-6 font-label-caps text-label-caps uppercase tracking-[0.16em] font-bold bg-primary text-on-primary hover:bg-neutral-800 transition-colors no-underline">
						<?php esc_html_e( 'Reintentar pago', 'woocommerce' ); ?>
					</span></a>
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"
						   class="block text-center py-4 px-6 font-label-caps text-label-caps uppercase tracking-[0.16em] font-bold border border-primary text-on-surface hover:bg-surface-container-low transition-colors no-underline">
							<?php esc_html_e( 'Mi cuenta', 'woocommerce' ); ?>
						</a>
					<?php endif; ?>
				</div>

			<?php else : ?>

				<!-- ✓ Success header -->
				<div class="flex flex-col items-center text-center mb-8">
					<div class="w-10 h-10 bg-primary text-on-primary flex items-center justify-center mb-4">
						<span class="material-symbols-outlined text-[20px]">check</span>
					</div>
					<h1 class="font-headline-md text-headline-md text-on-surface mb-2">
						<?php echo apply_filters(
							'woocommerce_thankyou_order_received_text',
							esc_html__( '¡Gracias por tu compra!', 'woocommerce' ),
							$order
						); ?>
					</h1>
					<p class="font-body-md text-body-md text-secondary">
						<?php esc_html_e( 'Tu pedido ha sido recibido. En breve recibirás un correo de confirmación.', 'woocommerce' ); ?>
					</p>
				</div>

				<!-- Order details strip -->
				<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

					<li class="woocommerce-order-overview__order order">
						<span class="font-label-caps text-label-caps uppercase text-[10px] tracking-widest text-secondary block mb-1">
							<?php esc_html_e( 'N.° de pedido', 'woocommerce' ); ?>
						</span>
						<strong><?php echo $order->get_order_number(); // phpcs:ignore ?></strong>
					</li>

					<li class="woocommerce-order-overview__date date">
						<span class="font-label-caps text-label-caps uppercase text-[10px] tracking-widest text-secondary block mb-1">
							<?php esc_html_e( 'Fecha', 'woocommerce' ); ?>
						</span>
						<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore ?></strong>
					</li>

					<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
						<li class="woocommerce-order-overview__email email">
							<span class="font-label-caps text-label-caps uppercase text-[10px] tracking-widest text-secondary block mb-1">
								<?php esc_html_e( 'Email', 'woocommerce' ); ?>
							</span>
							<strong><?php echo $order->get_billing_email(); // phpcs:ignore ?></strong>
						</li>
					<?php endif; ?>

					<li class="woocommerce-order-overview__total total">
						<span class="font-label-caps text-label-caps uppercase text-[10px] tracking-widest text-secondary block mb-1">
							<?php esc_html_e( 'Total', 'woocommerce' ); ?>
						</span>
						<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore ?></strong>
					</li>

					<?php if ( $order->get_payment_method_title() ) : ?>
						<li class="woocommerce-order-overview__payment-method method">
							<span class="font-label-caps text-label-caps uppercase text-[10px] tracking-widest text-secondary block mb-1">
								<?php esc_html_e( 'Método de pago', 'woocommerce' ); ?>
							</span>
							<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
						</li>
					<?php endif; ?>

				</ul>

				<!-- WooCommerce hooks (order details table, customer info, etc.) -->
				<div class="mt-8">
					<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
					<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
				</div>

				<!-- CTAs -->
				<div class="gs-thankyou-actions">
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( wc_get_endpoint_url( 'view-order', $order->get_id(), wc_get_page_permalink( 'myaccount' ) ) ); ?>"
						   class="gs-btn-primary">
							<?php esc_html_e( 'Ver mi pedido', 'woocommerce' ); ?>
						</a>
					<?php endif; ?>
					<a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"
					   class="gs-btn-outline">
						<?php esc_html_e( 'Seguir comprando', 'woocommerce' ); ?>
					</a>
				</div>

			<?php endif; ?>

		<?php else : ?>

			<div class="flex flex-col items-center text-center">
				<div class="w-10 h-10 bg-primary text-on-primary flex items-center justify-center mb-4">
					<span class="material-symbols-outlined text-[20px]">check</span>
				</div>
				<h1 class="font-headline-md text-headline-md text-on-surface mb-2">
					<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( '¡Gracias por tu compra!', 'woocommerce' ), null ); ?>
				</h1>
			</div>

		<?php endif; ?>

	</div>
</div>
