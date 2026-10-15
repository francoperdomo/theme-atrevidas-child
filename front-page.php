<?php
/**
 * The template for displaying the Front Page (Atrevidas)
 *
 * Orquestador modular limpio que invoca los template-parts del Home.
 *
 * @package SimpleWoo
 */

get_header(); ?>

<main id="main-content" class="bg-surface min-h-screen">

	<?php
	// 1. Hero Split Screen (Lencería vs Sexshop & Juguetes)
	get_template_part( 'template-parts/home/hero' );

	// 2. Category Chips (Acceso Rápido a Categorías Dinámicas)
	get_template_part( 'template-parts/home/category-chips' );

	// 3. Portales Duales (Lencería vs Juguetes)
	get_template_part( 'template-parts/home/dual-portals' );

	// 4. Trust Pillars (4 Pilares: Empaque Discreto, Pagos Privados, Descuentos, Asesoramiento)
	get_template_part( 'template-parts/home/trust-pillars' );

	// 4. Featured Products (Top Más Deseados con Transient Cache)
	get_template_part( 'template-parts/home/featured-products' );

	// 5. Spotlight (Cultura Atrevida y Bienestar Íntimo)
	get_template_part( 'template-parts/home/spotlight' );

	// 6. FAQ Accordion (Preguntas Frecuentes y Discreción)
	get_template_part( 'template-parts/home/faq-accordion' );
	?>

</main>

<?php get_footer(); ?>
