<?php
/**
 * Home: Hero Split Screen (Lencería vs Sexshop & Juguetes)
 *
 * @package SimpleWoo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$img_lenceria = get_theme_mod( 'atrevidas_hero_lenceria' ) ?: 'https://images.unsplash.com/photo-1583846783214-7229a91b20ed?auto=format&fit=crop&w=1200&q=80';
$img_juguetes = get_theme_mod( 'atrevidas_hero_juguetes' ) ?: 'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?auto=format&fit=crop&w=1200&q=80';

$cat_lenceria = get_term_by( 'slug', 'lenceria', 'product_cat' );
$url_lenceria = ( $cat_lenceria && ! is_wp_error( $cat_lenceria ) ) ? get_term_link( $cat_lenceria ) : home_url( '/categoria-producto/lenceria/' );

$cat_juguetes = get_term_by( 'slug', 'juguetes', 'product_cat' );
$url_juguetes = ( $cat_juguetes && ! is_wp_error( $cat_juguetes ) ) ? get_term_link( $cat_juguetes ) : home_url( '/categoria-producto/juguetes/' );
?>

<section class="w-full px-4 sm:px-6 lg:px-8 py-6 md:py-8 bg-surface" aria-label="Categorías principales">
	<div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 gs-hero-split">
		<!-- Mitad: Lencería -->
		<a href="<?php echo esc_url( $url_lenceria ); ?>" 
		   class="relative group flex flex-col justify-end p-8 md:p-12 overflow-hidden shadow-lg"
		   style="min-height: 420px; background-image: url('<?php echo esc_url( $img_lenceria ); ?>'); background-size: cover; background-position: center; border-radius: var(--radius-xl);">
			<div class="absolute inset-0 bg-black/40 group-hover:bg-black/30 transition-colors z-10"></div>
			<div class="relative z-20 text-white transform group-hover:-translate-y-1 transition-transform">
				<h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg mb-2 drop-shadow-md">Lencería Erótica</h2>
				<p class="font-body-md text-body-md mb-6 opacity-90 drop-shadow-md">Combiná talles y armá tu outfit perfecto.</p>
				<span class="inline-flex items-center px-8 py-4 bg-primary text-white font-bold shadow-lg hover:opacity-90 transition-opacity" style="border-radius: var(--radius-btn);">Ver Colección</span>
			</div>
		</a>
		
		<!-- Mitad: Juguetes -->
		<a href="<?php echo esc_url( $url_juguetes ); ?>" 
		   class="relative group flex flex-col justify-end p-8 md:p-12 overflow-hidden shadow-lg"
		   style="min-height: 420px; background-image: url('<?php echo esc_url( $img_juguetes ); ?>'); background-size: cover; background-position: center; border-radius: var(--radius-xl);">
			<div class="absolute inset-0 bg-black/40 group-hover:bg-black/30 transition-colors z-10"></div>
			<div class="relative z-20 text-white transform group-hover:-translate-y-1 transition-transform">
				<h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg mb-2 drop-shadow-md">Sexshop & Juguetes</h2>
				<p class="font-body-md text-body-md mb-6 opacity-90 drop-shadow-md">Descubrí diferentes formas de disfrutar.</p>
				<span class="inline-flex items-center px-8 py-4 bg-primary text-white font-bold shadow-lg hover:opacity-90 transition-opacity" style="border-radius: var(--radius-btn);">Explorar</span>
			</div>
		</a>
	</div>
</section>
