<?php
/**
 * My Account Navigation — Grow Socks override
 * Mobile: scrollable horizontal tabs
 * Desktop: vertical sidebar list
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

$menu_items = wc_get_account_menu_items();
?>

<nav
	class="woocommerce-MyAccount-navigation"
	aria-label="<?php esc_attr_e( 'Account pages', 'woocommerce' ); ?>"
>
	<?php
	// ── Mobile: horizontal scrollable tabs ──────────────────────────────────
	// Visible below md. Each endpoint becomes a rectangular tab button.
	?>
	<ul class="md:hidden flex gap-0 overflow-x-auto scrollbar-hide -mx-4 px-4 border-b border-surface-container" role="tablist">
		<?php foreach ( $menu_items as $endpoint => $label ) :
			$is_active = wc_is_current_account_menu_item( $endpoint );
			$url       = wc_get_account_endpoint_url( $endpoint );
		?>
			<li role="presentation" class="flex-shrink-0">
				<a
					href="<?php echo esc_url( $url ); ?>"
					role="tab"
					<?php echo $is_active ? 'aria-current="page"' : ''; ?>
					class="gs-myaccount-tab-link block px-4 py-3 font-label-caps text-label-caps uppercase tracking-widest whitespace-nowrap border-b-2 transition-colors
						<?php echo $is_active
							? 'border-primary text-on-surface'
							: 'border-transparent text-secondary hover:text-primary'; ?>"
				><?php echo esc_html( $label ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>

	<?php
	// ── Desktop: vertical sidebar list ──────────────────────────────────────
	// Hidden below md. Active item gets black background + white text.
	?>
	<ul class="hidden md:flex flex-col gap-0 m-0 p-0 list-none">
		<?php foreach ( $menu_items as $endpoint => $label ) :
			$is_active = wc_is_current_account_menu_item( $endpoint );
			$url       = wc_get_account_endpoint_url( $endpoint );
		?>
			<li class="<?php echo esc_attr( wc_get_account_menu_item_classes( $endpoint ) ); ?>">
				<a
					href="<?php echo esc_url( $url ); ?>"
					<?php echo $is_active ? 'aria-current="page"' : ''; ?>
					class="block px-4 py-3 font-label-caps text-label-caps uppercase tracking-widest transition-colors
						<?php echo $is_active
							? 'bg-primary text-on-primary'
							: 'text-secondary hover:text-primary hover:bg-surface-container-high'; ?>"
				><?php echo esc_html( $label ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
