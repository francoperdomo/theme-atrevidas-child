<?php
/**
 * Home: Spotlight (Cultura Atrevida)
 * Banner editorial de inspiración y bienestar íntimo.
 *
 * @package SimpleWoo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$spotlight_img   = get_theme_mod( 'atrevidas_spotlight_img' ) ?: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=1000&q=80';
$spotlight_tag   = get_theme_mod( 'atrevidas_spotlight_tag', '✨ Cultura Atrevida' );
$spotlight_title = get_theme_mod( 'atrevidas_spotlight_title', 'Explorá tu sensualidad sin tabúes y a tu propio ritmo.' );
$spotlight_desc  = get_theme_mod( 'atrevidas_spotlight_desc', 'Seleccionamos cada prenda y cada accesorio pensando en tu bienestar, seguridad y máximo placer. Calidad superior con asesoramiento personalizado y confidencial.' );

$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/tienda/' );
?>

<section class="gs-spotlight w-full px-4 sm:px-6 lg:px-8 py-12 md:py-16 bg-surface-container-lowest" aria-label="Cultura Atrevida">
	<div class="max-w-7xl mx-auto">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

			<!-- Imagen de Campaña -->
			<div class="lg:col-span-5 relative overflow-hidden rounded-2xl shadow-lg" style="min-height: 380px;">
				<img
					src="<?php echo esc_url( $spotlight_img ); ?>"
					alt="Cultura Atrevida"
					class="w-full h-full object-cover object-center"
					loading="lazy"
					decoding="async"
					width="600"
					height="750"
				/>
				<div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>
			</div>

			<!-- Bloque de Contenido y Beneficios -->
			<div class="lg:col-span-7 flex flex-col justify-center">
				<span class="font-label-caps text-label-caps text-primary uppercase tracking-widest font-bold mb-3 block">
					<?php echo esc_html( $spotlight_tag ); ?>
				</span>

				<h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-4 leading-tight">
					<?php echo esc_html( $spotlight_title ); ?>
				</h2>

				<p class="font-body-md text-secondary leading-relaxed mb-6">
					<?php echo esc_html( $spotlight_desc ); ?>
				</p>

				<!-- 3 Viñetas clave -->
				<div class="space-y-4 mb-8">
					<div class="flex items-start gap-3">
						<span class="material-symbols-outlined text-primary text-xl shrink-0 mt-0.5">favorite</span>
						<div>
							<strong class="font-body-md font-bold text-on-surface block">Materiales Seguros para tu Cuerpo</strong>
							<span class="font-body-sm text-secondary text-sm">Silicona médica grado alimentario, libres de ftalatos y lencería con acabados suaves.</span>
						</div>
					</div>

					<div class="flex items-start gap-3">
						<span class="material-symbols-outlined text-primary text-xl shrink-0 mt-0.5">lock</span>
						<div>
							<strong class="font-body-md font-bold text-on-surface block">Discreción y Privacidad Garantizada</strong>
							<span class="font-body-sm text-secondary text-sm">Envío completamente sellado y facturación reservada sin menciones al rubro.</span>
						</div>
					</div>

					<div class="flex items-start gap-3">
						<span class="material-symbols-outlined text-primary text-xl shrink-0 mt-0.5">forum</span>
						<div>
							<strong class="font-body-md font-bold text-on-surface block">Asesoramiento Sin Prejuicios</strong>
							<span class="font-body-sm text-secondary text-sm">Consultanos por WhatsApp y te ayudamos a elegir la opción ideal para vos o tu pareja.</span>
						</div>
					</div>
				</div>

				<div>
					<a
						href="<?php echo esc_url( $shop_url ); ?>"
						class="inline-flex items-center px-8 py-4 bg-primary text-white font-bold shadow-md hover:opacity-90 transition-opacity"
						style="border-radius: var(--radius-btn);"
					>
						Explorar Catálogo Completo <span class="ml-2" aria-hidden="true">→</span>
					</a>
				</div>

			</div>

		</div>
	</div>
</section>
