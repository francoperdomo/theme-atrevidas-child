<?php
/**
 * My Account page — Grow Socks override
 * Mobile: stacked (nav tabs on top, content below)
 * Desktop: 2-col grid (sidebar 1/4 + content 3/4)
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

$current_user = wp_get_current_user();
?>

<div class="woocommerce-my-account-wrapper max-w-7xl mx-auto px-4 py-8 md:py-16">

	<?php if ( is_user_logged_in() ) : ?>
		<!-- User greeting — visible on mobile above the tabs, hidden on desktop (shown in sidebar) -->
		<div class="md:hidden mb-6">
			<p class="font-label-caps text-label-caps uppercase tracking-widest text-secondary mb-1">
				<?php esc_html_e( 'Mi cuenta', 'woocommerce' ); ?>
			</p>
			<h1 class="font-headline-md text-headline-md text-on-surface">
				<?php
				/* translators: %s: user display name */
				printf( esc_html__( 'Hola, %s', 'theme-simple-woo' ), esc_html( $current_user->display_name ) );
				?>
			</h1>
			<p class="font-body-sm text-body-sm text-secondary mt-1"><?php echo esc_html( $current_user->user_email ); ?></p>
		</div>
	<?php endif; ?>

	<!-- Layout: stacked on mobile, 4-col grid on desktop -->
	<div class="flex flex-col md:grid md:grid-cols-4 gap-0 md:gap-8">

		<!-- Sidebar / Nav -->
		<aside class="md:col-span-1">
			<div class="bg-surface-container-low md:p-6">

				<?php if ( is_user_logged_in() ) : ?>
					<!-- User greeting — desktop only -->
					<div class="hidden md:block mb-6">
						<h1 class="font-headline-md text-headline-md text-on-surface">
							<?php printf( esc_html__( 'Hola, %s', 'theme-simple-woo' ), esc_html( $current_user->display_name ) ); ?>
						</h1>
						<p class="font-body-sm text-body-sm text-secondary mt-1"><?php echo esc_html( $current_user->user_email ); ?></p>
						<hr class="border-surface-container mt-4">
					</div>
				<?php endif; ?>

				<?php
				/**
				 * My Account navigation.
				 * @since 2.6.0
				 */
				do_action( 'woocommerce_account_navigation' );
				?>
			</div>
		</aside>

		<!-- Main Content -->
		<div class="woocommerce-MyAccount-content md:col-span-3 bg-surface-container-low p-4 md:p-8 mt-4 md:mt-0">
			<?php
			/**
			 * My Account content.
			 * @since 2.6.0
			 */
			do_action( 'woocommerce_account_content' );
			?>
		</div>

	</div>
</div>
