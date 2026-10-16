<?php
/**
 * Home: Category Chips
 * Barra horizontal deslizante de acceso rápido a las categorías principales de Atrevidas.
 *
 * @package SimpleWoo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$chips = function_exists( 'gs_get_home_category_chips' ) ? gs_get_home_category_chips() : array();

if ( empty( $chips ) ) {
	return;
}
?>

<nav class="gs-category-chips w-full py-4 px-4 sm:px-6 lg:px-8 bg-surface border-b border-surface-container" aria-label="<?php esc_attr_e( 'Categorías rápidas', 'theme-simple-woo' ); ?>">
	<div class="max-w-7xl mx-auto flex items-center gap-2 overflow-x-auto scroll-smooth py-1" style="scrollbar-width: none; -ms-overflow-style: none;">
		<?php foreach ( $chips as $chip ) : ?>
			<a
				href="<?php echo esc_url( $chip['url'] ); ?>"
				class="inline-flex items-center px-4 py-2 rounded-full border border-surface-container-highest bg-surface-container-lowest text-on-surface font-body-sm text-body-sm font-medium whitespace-nowrap hover:border-primary hover:bg-primary hover:text-on-primary transition-all duration-150"
				style="min-height: 38px;"
			>
				<?php echo esc_html( $chip['name'] ); ?>
			</a>
		<?php endforeach; ?>
	</div>
</nav>
