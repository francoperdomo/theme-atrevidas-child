<?php
/**
 * Home: Featured Products (Top Más Deseados)
 * Grilla de productos destacados con transient cache y cards nativas de WooCommerce.
 *
 * @package SimpleWoo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$featured_products = function_exists( 'gs_get_featured_products' ) ? gs_get_featured_products( 8 ) : array();

if ( empty( $featured_products ) && function_exists( 'wc_get_products' ) ) {
	$featured_products = wc_get_products( array(
		'status'       => 'publish',
		'limit'        => 8,
		'stock_status' => 'instock',
		'visibility'   => 'catalog',
	) );
}

if ( empty( $featured_products ) ) {
	return;
}

$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/tienda/' );
?>

<section class="sw-featured-products gs-featured-products w-full px-4 sm:px-6 lg:px-8 py-12 md:py-16 bg-surface" aria-label="Productos más deseados">
	<div class="max-w-7xl mx-auto">

		<div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-3">
			<div>
				<span class="font-label-caps text-label-caps text-secondary uppercase tracking-widest block mb-1">
					Selección Exclusiva
				</span>
				<h2 class="font-headline-md text-headline-md text-on-surface">
					Top Más Deseados
				</h2>
			</div>
			<a
				href="<?php echo esc_url( $shop_url ); ?>"
				class="hidden md:inline-flex items-center gap-1 font-body-sm text-body-sm font-semibold text-primary hover:opacity-80 transition-opacity"
			>
				Ver todo el catálogo <span aria-hidden="true">→</span>
			</a>
		</div>

		<!-- Product Grid: 2 cols en mobile, 4 cols en desktop -->
		<div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6">
			<?php
			global $post, $product;
			foreach ( $featured_products as $wc_prod ) :
				$post = get_post( $wc_prod->get_id() );
				setup_postdata( $post );
				$product = $wc_prod;
				wc_get_template_part( 'content', 'product' );
			endforeach;
			wp_reset_postdata();
			?>
		</div>

		<!-- Mobile CTA button -->
		<div class="mt-8 text-center md:hidden">
			<a
				href="<?php echo esc_url( $shop_url ); ?>"
				class="inline-flex items-center justify-center w-full px-6 py-3 border border-primary text-primary font-body-sm font-bold rounded-xl hover:bg-primary hover:text-white transition-colors"
				style="min-height: 44px;"
			>
				Ver Todo el Catálogo
			</a>
		</div>

	</div>
</section>
