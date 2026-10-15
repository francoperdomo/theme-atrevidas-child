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

$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/tienda/' );

// Obtener categorías dinámicas de nivel superior con productos
$terms = get_terms( array(
	'taxonomy'   => 'product_cat',
	'parent'     => 0,
	'hide_empty' => true,
	'orderby'    => 'menu_order',
	'order'      => 'ASC',
) );

$chips = array();
$chips[] = array(
	'name' => 'Todo el Catálogo',
	'url'  => $shop_url,
);

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	foreach ( $terms as $term ) {
		if ( in_array( $term->slug, array( 'uncategorized', 'sin-categorizar' ), true ) ) {
			continue;
		}
		$chips[] = array(
			'name' => $term->name,
			'url'  => get_term_link( $term ),
		);
	}
}
?>

<nav class="gs-category-chips w-full py-4 px-4 sm:px-6 lg:px-8 bg-surface border-b border-surface-container" aria-label="Categorías rápidas">
	<div class="max-w-7xl mx-auto flex items-center gap-2 overflow-x-auto scroll-smooth py-1" style="scrollbar-width: none; -ms-overflow-style: none;">
		<?php foreach ( $chips as $chip ) : ?>
			<a
				href="<?php echo esc_url( $chip['url'] ); ?>"
				class="inline-flex items-center px-4 py-2 rounded-full border border-surface-container-highest bg-surface-container-lowest text-on-surface font-body-sm text-body-sm font-medium whitespace-nowrap hover:border-primary hover:bg-primary hover:text-white transition-all duration-150"
				style="min-height: 38px;"
			>
				<?php echo esc_html( $chip['name'] ); ?>
			</a>
		<?php endforeach; ?>
	</div>
</nav>
