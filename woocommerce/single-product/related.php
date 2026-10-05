<?php
/**
 * Related Products
 *
 * Sobrescrito para Atrevidas Child Theme para usar Tailwind CSS y el diseño premium de tarjetas.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<section class="w-full px-margin md:px-margin-desktop py-space-2xl bg-surface mt-space-xl" id="related-products-section">
		<div class="max-w-7xl mx-auto space-y-space-lg">
			
			<div class="flex flex-col md:flex-row md:items-end justify-between gap-space-sm">
				<div>
					<span class="font-label-caps text-label-caps uppercase tracking-[0.2em] text-secondary">Sugerencias</span>
					<h2 class="font-headline-md text-headline-md tracking-tight text-primary font-normal">Más opciones para animarte</h2>
				</div>
			</div>

			<div id="product-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-space-md md:gap-gutter-desktop">
				<?php foreach ( $related_products as $related_product ) : ?>
					<?php
					$post_object = get_post( $related_product->get_id() );
					setup_postdata( $GLOBALS['post'] =& $post_object );
					
					wc_get_template_part( 'content', 'product' );
					?>
				<?php endforeach; ?>
			</div>

		</div>
	</section>
	<?php
endif;

wp_reset_postdata();
