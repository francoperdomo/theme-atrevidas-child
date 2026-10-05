<?php
/**
 * Lost password form — Grow Socks override
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>

<div class="gs-login-wrapper max-w-2xl mx-auto px-4 py-10 md:py-16">
	<div class="bg-surface-container-low p-6 md:p-10">

		<p class="font-label-caps text-label-caps uppercase tracking-widest text-secondary mb-2">
			<?php esc_html_e( 'Mi cuenta', 'woocommerce' ); ?>
		</p>

		<h1 class="font-headline-md text-headline-md text-on-surface mb-2">
			<?php esc_html_e( 'Recuperar contraseña', 'woocommerce' ); ?>
		</h1>

		<p class="font-body-md text-body-md text-secondary mb-8">
			<?php echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				'woocommerce_lost_password_message',
				esc_html__( 'Ingresá tu usuario o correo electrónico y te enviaremos un enlace para crear una nueva contraseña.', 'woocommerce' )
			); ?>
		</p>

		<form method="post" class="woocommerce-ResetPassword lost_reset_password flex flex-col gap-5">

			<div class="flex flex-col gap-1.5">
				<label for="user_login" class="font-label-caps text-label-caps uppercase tracking-widest text-secondary">
					<?php esc_html_e( 'Usuario o correo electrónico', 'woocommerce' ); ?>
					<span class="text-error" aria-hidden="true">*</span>
				</label>
				<input
					type="text"
					name="user_login"
					id="user_login"
					autocomplete="username"
					required
					aria-required="true"
					class="w-full bg-surface-container-lowest px-4 py-3 font-body-md text-body-md text-on-surface focus:outline-none focus:bg-surface-container-high transition-colors"
				/>
			</div>

			<?php do_action( 'woocommerce_lostpassword_form' ); ?>

			<input type="hidden" name="wc_reset_password" value="true" />

			<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

			<button
				type="submit"
				class="w-full bg-primary text-on-primary py-4 px-6 font-label-caps text-label-caps uppercase tracking-[0.16em] font-bold hover:bg-neutral-800 transition-colors border-none cursor-pointer mt-2"
			><?php esc_html_e( 'Enviar enlace', 'woocommerce' ); ?></button>

		</form>

		<div class="mt-6 pt-6 border-t border-surface-container">
			<a
				href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"
				class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors flex items-center gap-1"
			>← <?php esc_html_e( 'Volver a Mi cuenta', 'woocommerce' ); ?></a>
		</div>

	</div>
</div>

<?php do_action( 'woocommerce_after_lost_password_form' ); ?>
