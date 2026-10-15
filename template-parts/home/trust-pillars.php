<?php
/**
 * Home: Trust Pillars (Atrevidas)
 * 4 pilares de confianza y discreción para Sexshop y Lencería.
 *
 * @package SimpleWoo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$transfer_pct = function_exists( 'gs_get_transfer_discount' ) ? gs_get_transfer_discount() : (float) get_option( 'transfer_discount_percentage', 5 );
$cod_pct      = function_exists( 'gs_get_cod_discount' ) ? gs_get_cod_discount() : (float) get_option( 'cod_discount_percentage', 10 );
$best_pct     = max( (int) $transfer_pct, (int) $cod_pct );
$wa_url       = function_exists( 'atrevidas_get_whatsapp_url' ) ? atrevidas_get_whatsapp_url() : 'https://wa.me/';

$pillars = array(
	array(
		'icon'  => 'inventory_2',
		'title' => 'Empaque 100% Discreto',
		'desc'  => 'Cajas y sobres lisos sin logos ni menciones al rubro. Absoluta reserva.',
		'link'  => '',
	),
	array(
		'icon'  => 'verified_user',
		'title' => 'Privacidad en tu Resumen',
		'desc'  => 'Pagá con tarjetas o transferencias. Razón social neutra en tu estado de cuenta.',
		'link'  => '',
	),
	array(
		'icon'  => 'percent',
		'title' => ( $best_pct > 0 ? "Hasta {$best_pct}% OFF" : 'Descuentos Especiales' ),
		'desc'  => 'Ahorrá abonando mediante transferencia bancaria o en efectivo.',
		'link'  => '',
	),
	array(
		'icon'  => 'chat',
		'title' => 'Asesoramiento Íntimo',
		'desc'  => 'Atención y dudas frecuentes vía WhatsApp con total confidencialidad.',
		'link'  => $wa_url,
	),
);
?>

<section class="gs-trust-pillars w-full px-4 sm:px-6 lg:px-8 py-8 md:py-12 bg-surface border-y border-surface-container" aria-label="Garantías y confianza">
	<div class="max-w-7xl mx-auto">
		<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
			<?php foreach ( $pillars as $pillar ) : ?>
				<?php $has_link = ! empty( $pillar['link'] ); ?>
				<<?php echo $has_link ? 'a href="' . esc_url( $pillar['link'] ) . '" target="_blank" rel="noopener noreferrer"' : 'div'; ?> 
					class="flex flex-col items-center text-center p-5 rounded-2xl bg-surface-container-lowest border border-surface-container-highest shadow-sm hover:shadow-md transition-shadow group">
					<div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mb-3 text-primary group-hover:scale-110 transition-transform">
						<span class="material-symbols-outlined text-[26px]"><?php echo esc_html( $pillar['icon'] ); ?></span>
					</div>
					<h3 class="font-headline-sm text-sm md:text-base font-bold text-on-surface mb-1.5">
						<?php echo esc_html( $pillar['title'] ); ?>
					</h3>
					<p class="font-body-sm text-xs md:text-sm text-secondary leading-relaxed m-0">
						<?php echo esc_html( $pillar['desc'] ); ?>
					</p>
					<?php if ( $has_link ) : ?>
						<span class="inline-flex items-center gap-1 font-body-sm text-xs font-bold text-primary mt-2">
							Chatear ahora <span aria-hidden="true">→</span>
						</span>
					<?php endif; ?>
				</<?php echo $has_link ? 'a' : 'div'; ?>>
			<?php endforeach; ?>
		</div>
	</div>
</section>
