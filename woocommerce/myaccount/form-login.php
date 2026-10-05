<?php
/**
 * Login Form — Grow Socks override
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_customer_login_form' );
?>

<div class="gs-login-wrapper max-w-2xl mx-auto px-4 py-10 md:py-16">
	<div class="bg-surface-container-low p-6 md:p-10">

		<p class="font-label-caps text-label-caps uppercase tracking-widest text-secondary mb-2">
			<?php esc_html_e( 'Mi cuenta', 'woocommerce' ); ?>
		</p>

		<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
			<!-- Login / Registro tabs -->
			<div class="gs-auth-tabs flex border-b border-surface-container mb-8" role="tablist">
				<button
					class="gs-tab-btn font-label-caps text-label-caps uppercase tracking-widest px-4 py-3 transition-colors border-b-2 -mb-px"
					data-tab="login"
					role="tab"
					aria-selected="true"
				><?php esc_html_e( 'Acceder', 'woocommerce' ); ?></button>
				<button
					class="gs-tab-btn font-label-caps text-label-caps uppercase tracking-widest px-4 py-3 transition-colors border-b-2 -mb-px"
					data-tab="register"
					role="tab"
					aria-selected="false"
				><?php esc_html_e( 'Crear cuenta', 'woocommerce' ); ?></button>
			</div>
		<?php else : ?>
			<h1 class="font-headline-md text-headline-md text-on-surface mb-8">
				<?php esc_html_e( 'Acceder', 'woocommerce' ); ?>
			</h1>
		<?php endif; ?>

		<!-- Login Form -->
		<div class="gs-tab-panel" id="gs-panel-login">
			<?php if ( 'yes' !== get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
				<!-- sin tabs: el título ya está arriba -->
			<?php else : ?>
				<h2 class="sr-only"><?php esc_html_e( 'Acceder', 'woocommerce' ); ?></h2>
			<?php endif; ?>

			<form class="woocommerce-form woocommerce-form-login login flex flex-col gap-5" method="post" novalidate>

				<?php do_action( 'woocommerce_login_form_start' ); ?>

				<!-- Username -->
				<div class="flex flex-col gap-1.5">
					<label for="username" class="font-label-caps text-label-caps uppercase tracking-widest text-secondary">
						<?php esc_html_e( 'Usuario o correo electrónico', 'woocommerce' ); ?>
						<span class="text-error" aria-hidden="true">*</span>
					</label>
					<input
						type="text"
						name="username"
						id="username"
						autocomplete="username"
						required
						aria-required="true"
						value="<?php echo ( ! empty( $_POST['username'] ) && is_string( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; // phpcs:ignore WordPress.Security ?>"
						class="w-full bg-surface-container-lowest px-4 py-3 font-body-md text-body-md text-on-surface focus:outline-none focus:bg-surface-container-high transition-colors"
					/>
				</div>

				<!-- Password -->
				<div class="flex flex-col gap-1.5">
					<label for="password" class="font-label-caps text-label-caps uppercase tracking-widest text-secondary">
						<?php esc_html_e( 'Contraseña', 'woocommerce' ); ?>
						<span class="text-error" aria-hidden="true">*</span>
					</label>
					<input
						type="password"
						name="password"
						id="password"
						autocomplete="current-password"
						required
						aria-required="true"
						class="w-full bg-surface-container-lowest px-4 py-3 font-body-md text-body-md text-on-surface focus:outline-none focus:bg-surface-container-high transition-colors"
					/>
				</div>

				<?php do_action( 'woocommerce_login_form' ); ?>

				<!-- Remember me + Lost password -->
				<div class="flex items-center justify-between flex-wrap gap-2">
					<label class="flex items-center gap-2 cursor-pointer">
						<input
							class="accent-primary"
							name="rememberme"
							type="checkbox"
							id="rememberme"
							value="forever"
						/>
						<span class="font-body-sm text-body-sm text-secondary">
							<?php esc_html_e( 'Recuérdame', 'woocommerce' ); ?>
						</span>
					</label>
					<a
						href="<?php echo esc_url( wp_lostpassword_url() ); ?>"
						class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors underline underline-offset-2"
					><?php esc_html_e( '¿Olvidaste la contraseña?', 'woocommerce' ); ?></a>
				</div>

				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>

				<!-- Submit -->
				<button
					type="submit"
					name="login"
					value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"
					class="w-full bg-primary text-on-primary py-4 px-6 font-label-caps text-label-caps uppercase tracking-[0.16em] font-bold hover:bg-neutral-800 transition-colors border-none cursor-pointer mt-2"
				><?php esc_html_e( 'Acceder', 'woocommerce' ); ?></button>

				<?php do_action( 'woocommerce_login_form_end' ); ?>

			</form>
		</div>

		<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

			<!-- Register Form -->
			<div class="gs-tab-panel hidden" id="gs-panel-register">
				<h2 class="sr-only"><?php esc_html_e( 'Crear cuenta', 'woocommerce' ); ?></h2>

				<form method="post" class="woocommerce-form woocommerce-form-register register flex flex-col gap-5" <?php do_action( 'woocommerce_register_form_tag' ); ?>>

					<?php do_action( 'woocommerce_register_form_start' ); ?>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
						<div class="flex flex-col gap-1.5">
							<label for="reg_username" class="font-label-caps text-label-caps uppercase tracking-widest text-secondary">
								<?php esc_html_e( 'Usuario', 'woocommerce' ); ?>
								<span class="text-error" aria-hidden="true">*</span>
							</label>
							<input
								type="text"
								name="username"
								id="reg_username"
								autocomplete="username"
								required
								aria-required="true"
								value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; // phpcs:ignore WordPress.Security ?>"
								class="w-full bg-surface-container-lowest px-4 py-3 font-body-md text-body-md text-on-surface focus:outline-none focus:bg-surface-container-high transition-colors"
							/>
						</div>
					<?php endif; ?>

					<div class="flex flex-col gap-1.5">
						<label for="reg_email" class="font-label-caps text-label-caps uppercase tracking-widest text-secondary">
							<?php esc_html_e( 'Correo electrónico', 'woocommerce' ); ?>
							<span class="text-error" aria-hidden="true">*</span>
						</label>
						<input
							type="email"
							name="email"
							id="reg_email"
							autocomplete="email"
							required
							aria-required="true"
							value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; // phpcs:ignore WordPress.Security ?>"
							class="w-full bg-surface-container-lowest px-4 py-3 font-body-md text-body-md text-on-surface focus:outline-none focus:bg-surface-container-high transition-colors"
						/>
					</div>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
						<div class="flex flex-col gap-1.5">
							<label for="reg_password" class="font-label-caps text-label-caps uppercase tracking-widest text-secondary">
								<?php esc_html_e( 'Contraseña', 'woocommerce' ); ?>
								<span class="text-error" aria-hidden="true">*</span>
							</label>
							<input
								type="password"
								name="password"
								id="reg_password"
								autocomplete="new-password"
								required
								aria-required="true"
								class="w-full bg-surface-container-lowest px-4 py-3 font-body-md text-body-md text-on-surface focus:outline-none focus:bg-surface-container-high transition-colors"
							/>
						</div>
					<?php else : ?>
						<p class="font-body-sm text-body-sm text-secondary">
							<?php esc_html_e( 'Te enviaremos un enlace para crear tu contraseña.', 'woocommerce' ); ?>
						</p>
					<?php endif; ?>

					<?php do_action( 'woocommerce_register_form' ); ?>

					<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>

					<button
						type="submit"
						name="register"
						value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"
						class="w-full bg-primary text-on-primary py-4 px-6 font-label-caps text-label-caps uppercase tracking-[0.16em] font-bold hover:bg-neutral-800 transition-colors border-none cursor-pointer mt-2"
					><?php esc_html_e( 'Crear cuenta', 'woocommerce' ); ?></button>

					<?php do_action( 'woocommerce_register_form_end' ); ?>

				</form>
			</div>

		<?php endif; ?>

	</div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
