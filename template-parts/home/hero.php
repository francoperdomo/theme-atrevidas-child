<?php
/**
 * Home: Hero Editorial Panorámico (Atrevidas)
 * Banner horizontal con tipografía editorial y doble CTA.
 *
 * @package SimpleWoo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 1. Imágenes (Mobile & Desktop)
$hero_custom_desktop = get_theme_mod( 'atrevidas_hero_banner_img' );
$hero_custom_mobile  = get_theme_mod( 'atrevidas_hero_banner_img_mobile' );

$hero_img_desktop = $hero_custom_desktop ? esc_url( $hero_custom_desktop ) : 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=1600&q=80';
$hero_img_mobile  = $hero_custom_mobile ? esc_url( $hero_custom_mobile ) : $hero_img_desktop;

// 2. URLs de Categorías
$cat_lenceria = get_term_by( 'slug', 'lenceria', 'product_cat' );
$url_lenceria = ( $cat_lenceria && ! is_wp_error( $cat_lenceria ) ) ? get_term_link( $cat_lenceria ) : home_url( '/categoria-producto/lenceria/' );

$cat_juguetes = get_term_by( 'slug', 'juguetes', 'product_cat' );
$url_juguetes = ( $cat_juguetes && ! is_wp_error( $cat_juguetes ) ) ? get_term_link( $cat_juguetes ) : home_url( '/categoria-producto/juguetes/' );

// 3. Textos y CTAs configurables
$hero_subtitle = get_theme_mod( 'atrevidas_hero_banner_subtitle', 'Nueva Colección · Lencería & Bienestar' );
$hero_title    = get_theme_mod( 'atrevidas_hero_banner_title', 'Viví tu sensualidad<br>con total libertad.' );
$hero_desc     = get_theme_mod( 'atrevidas_hero_banner_desc', 'Diseños exclusivos y accesorios de calidad superior pensados para tu máximo placer y confort.' );

$hero_btn1_text = get_theme_mod( 'atrevidas_hero_banner_btn1_text', 'Ver Lencería' );
$hero_btn1_url  = get_theme_mod( 'atrevidas_hero_banner_btn1_url', $url_lenceria );

$hero_btn2_text = get_theme_mod( 'atrevidas_hero_banner_btn2_text', 'Explorar Sexshop ✨' );
$hero_btn2_url  = get_theme_mod( 'atrevidas_hero_banner_btn2_url', $url_juguetes );
?>

<section class="atr-hero relative w-full overflow-hidden" aria-label="Bienvenida a Atrevidas">

	<!-- Imagen Hero optimizada con soporte dual mobile/desktop y altura horizontal en desktop -->
	<div class="atr-hero__media relative w-full">
		<picture class="w-full h-full block">
			<?php if ( ! empty( $hero_custom_desktop ) ) : ?>
				<source media="(min-width: 768px)" srcset="<?php echo esc_url( $hero_img_desktop ); ?>">
			<?php endif; ?>
			<img
				src="<?php echo esc_url( $hero_img_mobile ); ?>"
				alt="<?php echo esc_attr( wp_strip_all_tags( $hero_title ) ); ?>"
				class="w-full h-full object-cover object-center"
				fetchpriority="high"
				loading="eager"
				decoding="async"
				width="1600"
				height="900"
			/>
		</picture>
		<!-- Gradiente sutil para legibilidad del texto -->
		<div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-black/10 pointer-events-none"></div>
	</div>

	<!-- Contenido tipográfico superpuesto -->
	<div class="atr-hero__content absolute bottom-0 left-0 right-0 px-4 sm:px-6 lg:px-8 pb-8 md:pb-12">
		<div class="max-w-7xl mx-auto">

			<?php if ( ! empty( $hero_subtitle ) ) : ?>
			<span class="block font-label-caps text-label-caps text-white/80 uppercase tracking-widest mb-2 drop-shadow-sm">
				<?php echo esc_html( $hero_subtitle ); ?>
			</span>
			<?php endif; ?>

			<?php if ( ! empty( $hero_title ) ) : ?>
			<h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-white leading-tight mb-3 drop-shadow-md">
				<?php echo wp_kses_post( $hero_title ); ?>
			</h1>
			<?php endif; ?>

			<?php if ( ! empty( $hero_desc ) ) : ?>
			<p class="font-body-md text-body-md text-white/90 mb-6 max-w-lg drop-shadow-sm">
				<?php echo wp_kses_post( $hero_desc ); ?>
			</p>
			<?php endif; ?>

			<?php if ( ! empty( $hero_btn1_text ) || ! empty( $hero_btn2_text ) ) : ?>
			<div class="flex flex-wrap items-center gap-3">
				<?php if ( ! empty( $hero_btn1_text ) ) : ?>
				<a
					href="<?php echo esc_url( $hero_btn1_url ); ?>"
					class="inline-flex items-center justify-center px-6 py-3 bg-primary text-white font-body-md font-bold text-body-md rounded-full shadow-lg hover:opacity-90 transition-opacity"
					style="min-height: 44px;"
				>
					<?php echo esc_html( $hero_btn1_text ); ?>
				</a>
				<?php endif; ?>

				<?php if ( ! empty( $hero_btn2_text ) ) : ?>
				<a
					href="<?php echo esc_url( $hero_btn2_url ); ?>"
					class="inline-flex items-center justify-center px-6 py-3 border border-white text-white font-body-md font-bold text-body-md rounded-full shadow-lg hover:bg-white hover:text-black transition-colors"
					style="min-height: 44px;"
				>
					<?php echo esc_html( $hero_btn2_text ); ?>
				</a>
				<?php endif; ?>
			</div>
			<?php endif; ?>

		</div>
	</div>

</section>
