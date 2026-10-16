<?php
/**
 * Home: Dual Portals (Lencería vs Sexshop & Juguetes)
 * Dos tarjetas de gran impacto para los dos mundos de Atrevidas.
 *
 * @package SimpleWoo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cat_lenceria = get_term_by( 'slug', 'lenceria', 'product_cat' );
$url_lenceria_default = ( $cat_lenceria && ! is_wp_error( $cat_lenceria ) ) ? get_term_link( $cat_lenceria ) : home_url( '/categoria-producto/lenceria/' );

$cat_juguetes = get_term_by( 'slug', 'juguetes', 'product_cat' );
$url_juguetes_default = ( $cat_juguetes && ! is_wp_error( $cat_juguetes ) ) ? get_term_link( $cat_juguetes ) : home_url( '/categoria-producto/juguetes/' );

// Portal 1 (Lencería)
$img_lenceria   = sw_child_get_mod( 'sw_portal1_img', 'https://images.unsplash.com/photo-1583846783214-7229a91b20ed?auto=format&fit=crop&w=1200&q=80', array( 'atrevidas_hero_lenceria' ) );
$portal1_tag    = sw_child_get_mod( 'sw_portal1_tag', 'Colección' );
$portal1_title  = sw_child_get_mod( 'sw_portal1_title', 'Lencería Erótica' );
$portal1_desc   = sw_child_get_mod( 'sw_portal1_desc', 'Combiná talles y armá tu outfit perfecto.' );
$portal1_btn    = sw_child_get_mod( 'sw_portal1_btn', 'Ver Colección' );
$url_lenceria   = sw_child_get_mod( 'sw_portal1_url', $url_lenceria_default );

// Portal 2 (Juguetes)
$img_juguetes   = sw_child_get_mod( 'sw_portal2_img', 'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?auto=format&fit=crop&w=1200&q=80', array( 'atrevidas_hero_juguetes' ) );
$portal2_tag    = sw_child_get_mod( 'sw_portal2_tag', 'Sexshop' );
$portal2_title  = sw_child_get_mod( 'sw_portal2_title', 'Sexshop & Juguetes' );
$portal2_desc   = sw_child_get_mod( 'sw_portal2_desc', 'Descubrí diferentes formas de disfrutar.' );
$portal2_btn    = sw_child_get_mod( 'sw_portal2_btn', 'Explorar' );
$url_juguetes   = sw_child_get_mod( 'sw_portal2_url', $url_juguetes_default );
?>

<section class="sw-dual-portals w-full px-4 sm:px-6 lg:px-8 py-8 md:py-12 bg-surface" aria-label="Colecciones destacadas">
	<div class="max-w-7xl mx-auto">
		<div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 sw-hero-split gs-hero-split">
			<!-- Mitad: Lencería -->
			<a href="<?php echo esc_url( $url_lenceria ); ?>" 
			   class="relative group flex flex-col justify-end p-8 md:p-12 overflow-hidden shadow-lg h-full"
			   style="background-image: url('<?php echo esc_url( $img_lenceria ); ?>'); background-size: cover; background-position: center; border-radius: var(--radius-xl);">
				<div class="absolute inset-0 bg-black/40 group-hover:bg-black/30 transition-colors z-10"></div>
				<div class="relative z-20 text-white transform group-hover:-translate-y-1 transition-transform">
					<span class="block font-label-caps text-label-caps uppercase tracking-widest opacity-80 mb-1"><?php echo esc_html( $portal1_tag ); ?></span>
					<h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg mb-2 drop-shadow-md"><?php echo wp_kses_post( $portal1_title ); ?></h2>
					<p class="font-body-md text-body-md mb-6 opacity-90 drop-shadow-md"><?php echo wp_kses_post( $portal1_desc ); ?></p>
					<span class="inline-flex items-center px-8 py-3 bg-primary text-white font-bold shadow-lg hover:opacity-90 transition-opacity" style="border-radius: var(--radius-btn);"><?php echo esc_html( $portal1_btn ); ?></span>
				</div>
			</a>
			
			<!-- Mitad: Juguetes -->
			<a href="<?php echo esc_url( $url_juguetes ); ?>" 
			   class="relative group flex flex-col justify-end p-8 md:p-12 overflow-hidden shadow-lg h-full"
			   style="background-image: url('<?php echo esc_url( $img_juguetes ); ?>'); background-size: cover; background-position: center; border-radius: var(--radius-xl);">
				<div class="absolute inset-0 bg-black/40 group-hover:bg-black/30 transition-colors z-10"></div>
				<div class="relative z-20 text-white transform group-hover:-translate-y-1 transition-transform">
					<span class="block font-label-caps text-label-caps uppercase tracking-widest opacity-80 mb-1"><?php echo esc_html( $portal2_tag ); ?></span>
					<h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg mb-2 drop-shadow-md"><?php echo wp_kses_post( $portal2_title ); ?></h2>
					<p class="font-body-md text-body-md mb-6 opacity-90 drop-shadow-md"><?php echo wp_kses_post( $portal2_desc ); ?></p>
					<span class="inline-flex items-center px-8 py-3 bg-primary text-white font-bold shadow-lg hover:opacity-90 transition-opacity" style="border-radius: var(--radius-btn);"><?php echo esc_html( $portal2_btn ); ?></span>
				</div>
			</a>
		</div>
	</div>
</section>
