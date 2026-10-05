<?php
/**
 * Orders — Grow Socks override
 * Mobile: card por pedido | Desktop: tabla completa
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders );
?>

<div class="gs-orders-wrapper">

	<h2 class="font-headline-md text-headline-md text-on-surface mb-6">
		<?php esc_html_e( 'Mis Pedidos', 'woocommerce' ); ?>
	</h2>

	<?php if ( $has_orders ) : ?>

		<?php
		// ── Desktop table ──────────────────────────────────────────────────
		?>
		<div class="hidden md:block overflow-x-auto">
			<table class="woocommerce-orders-table w-full">
				<thead>
					<tr class="border-b border-surface-container">
						<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
							<th scope="col" class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?> font-label-caps text-label-caps uppercase tracking-widest text-secondary py-3 text-left font-normal">
								<span class="nobr"><?php echo esc_html( $column_name ); ?></span>
							</th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $customer_orders->orders as $customer_order ) :
						$order      = wc_get_order( $customer_order );
						$item_count = $order->get_item_count() - $order->get_item_count_refunded();
					?>
						<tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-<?php echo esc_attr( $order->get_status() ); ?> order border-b border-surface-container-low hover:bg-surface-container-low transition-colors">
							<?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) :
								$is_order_number = 'order-number' === $column_id;
								$cell_class = 'woocommerce-orders-table__cell woocommerce-orders-table__cell-' . esc_attr( $column_id ) . ' py-4 font-body-md text-body-md';
							?>

								<?php if ( $is_order_number ) : ?>
									<th class="<?php echo $cell_class; ?> text-on-surface font-medium" scope="row" data-title="<?php echo esc_attr( $column_name ); ?>">
								<?php else : ?>
									<td class="<?php echo $cell_class; ?> text-on-surface" data-title="<?php echo esc_attr( $column_name ); ?>">
								<?php endif; ?>

									<?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
										<?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

									<?php elseif ( $is_order_number ) : ?>
										<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="text-on-surface hover:underline" aria-label="<?php echo esc_attr( sprintf( __( 'View order number %s', 'woocommerce' ), $order->get_order_number() ) ); ?>">
											<?php echo esc_html( '#' . $order->get_order_number() ); ?>
										</a>

									<?php elseif ( 'order-date' === $column_id ) : ?>
										<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>">
											<?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?>
										</time>

									<?php elseif ( 'order-status' === $column_id ) : ?>
										<span class="gs-order-status gs-status-<?php echo esc_attr( $order->get_status() ); ?> inline-block font-label-caps text-[10px] tracking-widest uppercase px-2 py-1 border">
											<?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
										</span>

									<?php elseif ( 'order-total' === $column_id ) : ?>
										<?php
										echo wp_kses_post( sprintf(
											_n( '%1$s por %2$s artículo', '%1$s por %2$s artículos', $item_count, 'woocommerce' ),
											$order->get_formatted_order_total(),
											$item_count
										) );
										?>

									<?php elseif ( 'order-actions' === $column_id ) : ?>
										<?php $actions = wc_get_account_orders_actions( $order ); ?>
										<?php if ( ! empty( $actions ) ) : ?>
											<div class="flex gap-2 flex-wrap">
											<?php foreach ( $actions as $key => $action ) :
												$aria = empty( $action['aria-label'] )
													? sprintf( __( '%1$s order number %2$s', 'woocommerce' ), $action['name'], $order->get_order_number() )
													: $action['aria-label'];
											?>
												<a
													href="<?php echo esc_url( $action['url'] ); ?>"
													class="woocommerce-button button <?php echo sanitize_html_class( $key ); ?> font-label-caps text-label-caps uppercase tracking-widest text-on-surface hover:text-secondary transition-colors"
													aria-label="<?php echo esc_attr( $aria ); ?>"
												><?php echo esc_html( $action['name'] ); ?></a>
											<?php endforeach; ?>
											</div>
										<?php endif; ?>
									<?php endif; ?>

								<?php if ( $is_order_number ) : ?></th><?php else : ?></td><?php endif; ?>

							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<?php
		// ── Mobile cards ───────────────────────────────────────────────────
		?>
		<div class="md:hidden flex flex-col divide-y divide-surface-container">
			<?php foreach ( $customer_orders->orders as $customer_order ) :
				$order      = wc_get_order( $customer_order );
				$item_count = $order->get_item_count() - $order->get_item_count_refunded();
				$status     = $order->get_status();
			?>
				<div class="woocommerce-orders-table__row gs-order-card py-5">
					<div class="flex items-start justify-between mb-2">
						<div>
							<a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="font-body-lg font-medium text-on-surface hover:underline">
								<?php echo esc_html( '#' . $order->get_order_number() ); ?>
							</a>
							<p class="font-body-sm text-body-sm text-secondary mt-0.5">
								<time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>">
									<?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?>
								</time>
							</p>
						</div>
						<span class="gs-order-status gs-status-<?php echo esc_attr( $status ); ?> inline-block font-label-caps text-[10px] tracking-widest uppercase px-2 py-1 border flex-shrink-0">
							<?php echo esc_html( wc_get_order_status_name( $status ) ); ?>
						</span>
					</div>

					<div class="flex items-center justify-between">
						<span class="font-body-md text-on-surface font-medium">
							<?php echo wp_kses_post( $order->get_formatted_order_total() ); ?>
							<span class="font-body-sm text-secondary font-normal">
								· <?php echo esc_html( sprintf( _n( '%s artículo', '%s artículos', $item_count, 'woocommerce' ), $item_count ) ); ?>
							</span>
						</span>

						<?php $actions = wc_get_account_orders_actions( $order ); ?>
						<?php if ( ! empty( $actions ) ) :
							$first_action = reset( $actions );
						?>
							<a
								href="<?php echo esc_url( $first_action['url'] ); ?>"
								class="font-label-caps text-label-caps uppercase tracking-widest text-on-surface hover:text-secondary transition-colors flex items-center gap-1"
							><?php echo esc_html( $first_action['name'] ); ?> →</a>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

		<?php if ( 1 < $customer_orders->max_num_pages ) : ?>
			<div class="woocommerce-pagination flex items-center gap-4 mt-8">
				<?php if ( 1 !== $current_page ) : ?>
					<a class="font-label-caps text-label-caps uppercase tracking-widest text-secondary hover:text-primary transition-colors" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>">
						← <?php esc_html_e( 'Anterior', 'woocommerce' ); ?>
					</a>
				<?php endif; ?>
				<?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
					<a class="font-label-caps text-label-caps uppercase tracking-widest text-secondary hover:text-primary transition-colors" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>">
						<?php esc_html_e( 'Siguiente', 'woocommerce' ); ?> →
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

	<?php else : ?>
		<div class="py-8 text-center">
			<p class="font-body-md text-secondary mb-4">
				<?php esc_html_e( 'Todavía no realizaste ningún pedido.', 'woocommerce' ); ?>
			</p>
			<a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"
			   class="inline-block bg-primary text-on-primary py-3 px-6 font-label-caps text-label-caps uppercase tracking-[0.16em] font-bold hover:bg-neutral-800 transition-colors">
				<?php esc_html_e( 'Ver productos', 'woocommerce' ); ?>
			</a>
		</div>
	<?php endif; ?>

</div>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
