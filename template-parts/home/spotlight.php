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

$shop_url_default = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/tienda/' );

$spotlight_img   = sw_child_get_mod( 'sw_spotlight_img', 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=1000&q=80', array( 'atrevidas_spotlight_img' ) );
$spotlight_tag   = sw_child_get_mod( 'sw_spotlight_tag', '✨ Cultura Atrevida', array( 'atrevidas_spotlight_tag' ) );
$spotlight_title = sw_child_get_mod( 'sw_spotlight_title', 'Explorá tu sensualidad sin tabúes y a tu propio ritmo.', array( 'atrevidas_spotlight_title' ) );
$spotlight_desc  = sw_child_get_mod( 'sw_spotlight_desc', 'Seleccionamos cada prenda y cada accesorio pensando en tu bienestar, seguridad y máximo placer. Calidad superior con asesoramiento personalizado y confidencial.', array( 'atrevidas_spotlight_desc' ) );

$bullets = array(
	array(
		'icon'  => sw_child_get_mod( 'sw_spotlight_li1_icon', 'favorite' ),
		'title' => sw_child_get_mod( 'sw_spotlight_li1_title', 'Materiales Seguros para tu Cuerpo' ),
		'desc'  => sw_child_get_mod( 'sw_spotlight_li1_desc', 'Silicona médica grado alimentario, libres de ftalatos y lencería con acabados suaves.' ),
	),
	array(
		'icon'  => sw_child_get_mod( 'sw_spotlight_li2_icon', 'lock' ),
		'title' => sw_child_get_mod( 'sw_spotlight_li2_title', 'Discreción y Privacidad Garantizada' ),
		'desc'  => sw_child_get_mod( 'sw_spotlight_li2_desc', 'Envío completamente sellado y facturación reservada sin menciones al rubro.' ),
	),
	array(
		'icon'  => sw_child_get_mod( 'sw_spotlight_li3_icon', 'forum' ),
		'title' => sw_child_get_mod( 'sw_spotlight_li3_title', 'Asesoramiento Sin Prejuicios' ),
		'desc'  => sw_child_get_mod( 'sw_spotlight_li3_desc', 'Consultanos por WhatsApp y te ayudamos a elegir la opción ideal para vos o tu pareja.' ),
	),
);

$spotlight_btn = sw_child_get_mod( 'sw_spotlight_btn', 'Explorar Catálogo Completo' );
$shop_url      = sw_child_get_mod( 'sw_spotlight_url', $shop_url_default );
?>

<section class="sw-spotlight gs-spotlight w-full px-4 sm:px-6 lg:px-8 py-12 md:py-16 bg-surface-container-lowest" aria-label="Cultura Atrevida">
	<div class="max-w-7xl mx-auto">
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

			<!-- Imagen de Campaña -->
			<div class="lg:col-span-5 relative overflow-hidden rounded-2xl shadow-lg" style="min-height: 380px;">
				<img
					src="<?php echo esc_url( $spotlight_img ); ?>"
					alt="<?php echo esc_attr( wp_strip_all_tags( $spotlight_title ) ); ?>"
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
					<?php echo wp_kses_post( $spotlight_title ); ?>
				</h2>

				<p class="font-body-md text-secondary leading-relaxed mb-6">
					<?php echo wp_kses_post( $spotlight_desc ); ?>
				</p>

				<!-- 3 Viñetas clave -->
				<div class="space-y-4 mb-8">
					<?php foreach ( $bullets as $b ) : ?>
						<?php if ( ! empty( $b['title'] ) ) : ?>
						<div class="flex items-start gap-3">
							<?php if ( ! empty( $b['icon'] ) ) : ?>
								<span class="material-symbols-outlined text-primary text-xl shrink-0 mt-0.5"><?php echo esc_html( $b['icon'] ); ?></span>
							<?php endif; ?>
							<div>
								<strong class="font-body-md font-bold text-on-surface block"><?php echo esc_html( $b['title'] ); ?></strong>
								<?php if ( ! empty( $b['desc'] ) ) : ?>
									<span class="font-body-sm text-secondary text-sm"><?php echo esc_html( $b['desc'] ); ?></span>
								<?php endif; ?>
							</div>
						</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

				<?php if ( ! empty( $spotlight_btn ) && ! empty( $shop_url ) ) : ?>
				<div>
					<a
						href="<?php echo esc_url( $shop_url ); ?>"
						class="inline-flex items-center px-8 py-4 bg-primary text-white font-bold shadow-md hover:opacity-90 transition-opacity"
						style="border-radius: var(--radius-btn);"
					>
						<?php echo esc_html( $spotlight_btn ); ?> <span class="ml-2" aria-hidden="true">→</span>
					</a>
				</div>
				<?php endif; ?>

			</div>

		</div>
	</div>
</section>
