<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
?>

<div class="w-full bg-surface-container-low px-margin md:px-margin-desktop py-space-sm">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <a class="inline-flex items-center gap-space-xs font-label-caps text-label-caps uppercase tracking-wider text-secondary hover:text-primary transition-colors" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Volver a la bolsa de compras
        </a>
    </div>
</div>

<!-- HIDDEN NATIVE COUPON FORM (Triggered via JS from custom UI) -->
<div class="hidden">
    <?php woocommerce_checkout_coupon_form(); ?>
</div>

<div class="w-full max-w-7xl mx-auto px-margin md:px-margin-desktop py-space-lg md:py-space-xl">
    
    <!-- BLOQUE DE LOGIN (Fuera del form.checkout para evitar anidamiento HTML) -->
    <?php if ( ! is_user_logged_in() && 'yes' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) : ?>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-start mb-space-xl">
            <div class="lg:col-span-12">
                <div class="bg-surface-container-lowest p-space-lg shadow-sm border-l-4 border-black">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex flex-col">
                            <h3 class="font-headline-sm text-[16px] uppercase tracking-tight text-on-surface">¿Ya sos cliente?</h3>
                            <p class="font-body-sm text-secondary mt-1">Iniciá sesión para autocompletar tus datos y comprar más rápido.</p>
                        </div>
                        <button type="button" class="gs-toggle-login bg-surface-container-high hover:bg-surface-variant text-on-surface px-6 py-3 font-label-caps uppercase text-[12px] tracking-wider transition-colors shrink-0">Ingresar</button>
                    </div>
                    
                    <div class="gs-login-wrapper hidden mt-space-md pt-space-md border-t border-surface-variant">
                        <?php 
                        // Mostramos el form de login nativo, pero estilizado vía Tailwind en form-login.php o por clases
                        woocommerce_login_form( array( 'redirect' => wc_get_checkout_url() ) ); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- FORMULARIO PRINCIPAL DE CHECKOUT -->
    <form name="checkout" method="post" class="checkout woocommerce-checkout w-full" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-start">
            
            <!-- COLUMNA IZQUIERDA: FLUJO DE CHECKOUT -->
            <section class="lg:col-span-7 flex flex-col gap-space-lg">
                
                <!-- STEPPER MINIMALISTA EDITORIAL -->
                <nav aria-label="Progreso de Checkout" class="bg-surface-container-lowest p-space-md shadow-sm">
                    <div class="grid grid-cols-3 gap-space-xs">
                        <div class="flex flex-col gap-1">
                            <span class="font-label-caps text-[9px] uppercase tracking-widest text-on-surface font-bold">01 / Identificación</span>
                            <div class="h-[1px] w-full bg-black/20"></div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="font-label-caps text-[9px] uppercase tracking-widest text-on-surface font-bold">02 / Envío</span>
                            <div class="h-[1px] w-full bg-black/20"></div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="font-label-caps text-[9px] uppercase tracking-widest text-secondary">03 / Pago</span>
                            <div class="h-[2px] w-full bg-surface-variant"></div>
                        </div>
                    </div>
                </nav>

                <?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>

                <?php if ( $checkout->get_checkout_fields() ) : ?>

                    <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                    <!-- PASO 1 y 2: DATOS PERSONALES Y ENVÍO -->
                    <div class="bg-surface-container-lowest p-space-lg shadow-sm flex flex-col gap-space-md" id="customer_details">
                        <div class="flex items-baseline justify-between">
                            <div class="flex items-center gap-2">
                                <span class="font-label-caps text-label-caps bg-black text-white px-2 py-0.5">02</span>
                                <h2 class="font-headline-sm text-headline-sm uppercase text-on-surface tracking-tight">Datos de Entrega & Contacto</h2>
                            </div>
                        </div>
                        
                        <?php do_action( 'woocommerce_checkout_billing' ); ?>
                        <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                    </div>

                    <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

                <?php endif; ?>

                <!-- PASO 3: MÉTODO DE PAGO -->
                <div class="bg-surface-container-lowest p-space-lg shadow-sm flex flex-col gap-space-md">
                    <div class="flex items-baseline justify-between">
                        <div class="flex items-center gap-2">
                            <span class="font-label-caps text-label-caps bg-black text-white px-2 py-0.5">03</span>
                            <h2 class="font-headline-sm text-headline-sm uppercase text-on-surface tracking-tight">Forma de Pago</h2>
                        </div>
                    </div>
                    
                    <div id="order_review" class="woocommerce-checkout-payment-wrapper">
                        <?php woocommerce_checkout_payment(); ?>
                    </div>
                </div>
                
            </section>

            <!-- COLUMNA DERECHA: RESUMEN DE COMPRA & CUPÓN -->
            <aside class="lg:col-span-5 flex flex-col gap-space-md lg:sticky lg:top-24">
                
                <div class="bg-surface-container-lowest p-space-lg shadow-sm flex flex-col gap-space-md">
                    <div class="flex items-center justify-between pb-space-sm border-b border-surface-variant">
                        <h3 class="font-headline-sm text-[18px] uppercase tracking-tight text-on-surface">Resumen del Pedido</h3>
                    </div>
                    
                    <!-- WooCommerce Native Order Review (Cart items + Totals) -->
                    <div class="woocommerce-checkout-review-order">
                        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                    </div>
                </div>

                <!-- BLOQUE DE CUPÓN CUSTOM (Integrado en el resumen) -->
                <?php if ( wc_coupons_enabled() ) : ?>
                <div class="bg-surface-container-lowest p-space-lg shadow-sm flex flex-col gap-3 border border-surface-variant">
                    <label class="font-headline-sm text-[14px] uppercase tracking-tight text-on-surface">¿Tenés un código de descuento?</label>
                    <div class="flex gap-0">
                        <input type="text" id="gs-fake-coupon-input" class="w-full bg-surface px-4 py-3 border-y border-l border-surface-variant text-body-md focus:outline-none focus:border-black transition-colors" placeholder="Ej. GROW2026">
                        <button type="button" id="gs-fake-coupon-btn" class="bg-black text-on-primary px-6 py-3 font-label-caps uppercase text-[12px] tracking-wider hover:bg-secondary transition-colors shrink-0">Aplicar</button>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Bloque de Compromisos y Confianza (HTML Fijo) -->
                <div class="bg-surface-container-low p-space-lg flex flex-col gap-space-md">
                    <span class="font-label-caps text-label-caps uppercase tracking-widest text-on-surface font-bold">Información Importante</span>
                    <div class="flex flex-col gap-space-sm">
                        <div class="flex items-start gap-space-sm">
                            <span class="material-symbols-outlined text-[20px] text-on-surface mt-0.5">two_wheeler</span>
                            <div class="flex flex-col">
                                <span class="font-body-md text-body-md font-medium text-on-surface">Envíos rápidos en Moto</span>
                                <span class="text-[12px] text-secondary">Disponibles para CABA y GBA.</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-space-sm">
                            <span class="material-symbols-outlined text-[20px] text-on-surface mt-0.5">payments</span>
                            <div class="flex flex-col">
                                <span class="font-body-md text-body-md font-medium text-on-surface">Pagos en Efectivo</span>
                                <span class="text-[12px] text-secondary">Válido únicamente para Retiro en Local o Moto Envío.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            
        </div>
    </form>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Interacción del Login
    const loginBtn = document.querySelector('.gs-toggle-login');
    const loginWrapper = document.querySelector('.gs-login-wrapper');
    if(loginBtn && loginWrapper) {
        loginBtn.addEventListener('click', function(e) {
            e.preventDefault();
            loginWrapper.classList.toggle('hidden');
        });
    }

    // Interacción del Cupón Fake -> Native
    const fakeBtn = document.getElementById('gs-fake-coupon-btn');
    const fakeInput = document.getElementById('gs-fake-coupon-input');
    if (fakeBtn && fakeInput) {
        fakeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const nativeInput = document.querySelector('form.checkout_coupon input[name="coupon_code"]');
            const nativeForm = document.querySelector('form.checkout_coupon');
            if (nativeInput && nativeForm) {
                nativeInput.value = fakeInput.value;
                const btn = nativeForm.querySelector('button[name="apply_coupon"]');
                if (btn) {
                    btn.click();
                } else {
                    nativeForm.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
                }
            }
        });
    }
});
</script>
