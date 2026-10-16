<?php
/**
 * Home: Hero Editorial Panorámico (Atrevidas)
 * Banner horizontal con tipografía editorial y doble CTA.
 * Se oculta por completo si no hay imágenes cargadas en el Personalizador.
 *
 * @package SimpleWoo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 1. Imágenes (Mobile & Desktop) desde el Personalizador
$hero_custom_desktop = sw_child_get_mod( 'sw_hero_image_desktop', '', array( 'atrevidas_hero_banner_img' ) );
$hero_custom_mobile  = sw_child_get_mod( 'sw_hero_image', '', array( 'atrevidas_hero_banner_img_mobile' ) );

// REGLA ESTRICTA: Sin fallbacks genéricos. Si no hay imagen cargada, el banner no se muestra.
if ( empty( $hero_custom_desktop ) && empty( $hero_custom_mobile ) ) {
	return;
}

$hero_img_desktop = ! empty( $hero_custom_desktop ) ? esc_url( $hero_custom_desktop ) : esc_url( $hero_custom_mobile );
$hero_img_mobile  = ! empty( $hero_custom_mobile ) ? esc_url( $hero_custom_mobile ) : $hero_img_desktop;

// 2. URLs de Categorías
$cat_lenceria = get_term_by( 'slug', 'lenceria', 'product_cat' );
$url_lenceria = ( $cat_lenceria && ! is_wp_error( $cat_lenceria ) ) ? get_term_link( $cat_lenceria ) : home_url( '/categoria-producto/lenceria/' );

$cat_juguetes = get_term_by( 'slug', 'juguetes', 'product_cat' );
$url_juguetes = ( $cat_juguetes && ! is_wp_error( $cat_juguetes ) ) ? get_term_link( $cat_juguetes ) : home_url( '/categoria-producto/juguetes/' );

// 3. Textos y CTAs configurables
$hero_subtitle = sw_child_get_mod( 'sw_hero_subtitle', 'Nueva Colección · Lencería & Bienestar', array( 'atrevidas_hero_banner_subtitle' ) );
$hero_title    = sw_child_get_mod( 'sw_hero_title', 'Viví tu sensualidad<br>con total libertad.', array( 'atrevidas_hero_banner_title' ) );
$hero_desc     = sw_child_get_mod( 'sw_hero_desc', 'Diseños exclusivos y accesorios de calidad superior pensados para tu máximo placer y confort.', array( 'atrevidas_hero_banner_desc' ) );

$hero_btn1_text = sw_child_get_mod( 'sw_hero_btn1_text', 'Ver Lencería', array( 'atrevidas_hero_banner_btn1_text' ) );
$hero_btn1_url  = sw_child_get_mod( 'sw_hero_btn1_url', $url_lenceria, array( 'atrevidas_hero_banner_btn1_url' ) );

$hero_btn2_text = sw_child_get_mod( 'sw_hero_btn2_text', 'Explorar Sexshop ✨', array( 'atrevidas_hero_banner_btn2_text' ) );
$hero_btn2_url  = sw_child_get_mod( 'sw_hero_btn2_url', $url_juguetes, array( 'atrevidas_hero_banner_btn2_url' ) );
?>

<section class="sw-hero atr-hero relative w-full overflow-hidden" aria-label="Bienvenida a Atrevidas">

	<!-- Imagen Hero optimizada con soporte dual mobile/desktop y altura horizontal en desktop -->
	<div class="sw-hero__media atr-hero__media relative w-full">
		<picture class="w-full h-full block">
			<?php if ( ! empty( $hero_custom_desktop ) && ! empty( $hero_custom_mobile ) ) : ?>
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
		<!-- Gradiente reforzado para legibilidad impecable del texto -->
		<div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent pointer-events-none"></div>
	</div>

	<!-- Contenido tipográfico superpuesto con amplio padding inferior y lateral -->
	<div class="sw-hero__content atr-hero__content absolute bottom-0 left-0 right-0 px-6 sm:px-10 md:px-16 lg:px-20 pb-10 md:pb-14 lg:pb-16">
		<div class="max-w-7xl mx-auto">

			<?php if ( ! empty( $hero_subtitle ) ) : ?>
			<span class="block font-label-caps text-label-caps text-white/90 uppercase tracking-widest mb-2 md:mb-3 drop-shadow-sm">
				<?php echo esc_html( $hero_subtitle ); ?>
			</span>
			<?php endif; ?>

			<?php if ( ! empty( $hero_title ) ) : ?>
			<h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-white leading-tight mb-3 md:mb-4 drop-shadow-md">
				<?php echo wp_kses_post( $hero_title ); ?>
			</h1>
			<?php endif; ?>

			<?php if ( ! empty( $hero_desc ) ) : ?>
			<p class="font-body-md text-body-md text-white/90 mb-6 md:mb-8 max-w-xl drop-shadow-sm">
				<?php echo wp_kses_post( $hero_desc ); ?>
			</p>
			<?php endif; ?>

			<?php if ( ! empty( $hero_btn1_text ) || ! empty( $hero_btn2_text ) ) : ?>
			<div class="flex flex-wrap items-center gap-4">
				<?php if ( ! empty( $hero_btn1_text ) ) : ?>
				<a
					href="<?php echo esc_url( $hero_btn1_url ); ?>"
					class="inline-flex items-center justify-center px-8 py-3.5 bg-primary text-white font-body-md font-bold text-body-md rounded-full shadow-lg hover:opacity-90 transition-opacity"
					style="min-height: 46px;"
				>
					<?php echo esc_html( $hero_btn1_text ); ?>
				</a>
				<?php endif; ?>

				<?php if ( ! empty( $hero_btn2_text ) ) : ?>
				<a
					href="<?php echo esc_url( $hero_btn2_url ); ?>"
					class="inline-flex items-center justify-center px-8 py-3.5 border border-white text-white font-body-md font-bold text-body-md rounded-full shadow-lg hover:bg-white hover:text-black transition-colors"
					style="min-height: 46px;"
				>
					<?php echo esc_html( $hero_btn2_text ); ?>
				</a>
				<?php endif; ?>
			</div>
			<?php endif; ?>

		</div>
	</div>

</section>
