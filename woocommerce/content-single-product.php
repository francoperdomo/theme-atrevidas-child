<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'flex flex-col w-full', $product ); ?>>

    <?php
    $terms = wc_get_product_terms( $product->get_id(), 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) );
    $primary_cat = ! empty( $terms ) && ! is_wp_error( $terms ) ? $terms[0] : null;
    $back_url = $primary_cat ? get_term_link( $primary_cat ) : wc_get_page_permalink( 'shop' );
    $back_title = $primary_cat ? $primary_cat->name : 'la tienda';
    ?>
    <!-- Subtle Breadcrumb & Status Navigation -->
    <div class="w-full px-margin md:px-margin-desktop py-space-xs md:py-space-sm bg-surface">
        <div class="flex items-center justify-between">
            <!-- Mobile: Clean Back Button (← Volver a Medias) -->
            <div class="md:hidden">
                <a href="<?php echo esc_url( $back_url ); ?>" class="inline-flex items-center gap-1.5 font-label-caps text-label-caps uppercase tracking-widest text-on-surface hover:text-secondary transition-colors py-1">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    <span>Volver a <?php echo esc_html( $back_title ); ?></span>
                </a>
            </div>

            <!-- Desktop: Full Breadcrumb -->
            <nav aria-label="Breadcrumb" class="hidden md:flex items-center space-x-space-xs font-label-caps text-label-caps uppercase tracking-widest text-secondary">
                <?php woocommerce_breadcrumb( array('wrap_before' => '', 'wrap_after' => '', 'delimiter' => '<span>/</span>', 'before' => '<span class="hover:text-primary transition-colors">', 'after' => '</span>') ); ?>
            </nav>
            <div class="hidden md:flex items-center gap-space-sm">
                <?php if ( $product->managing_stock() && $product->get_stock_quantity() > 0 ) : ?>
                    <span class="inline-block w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="font-label-caps text-label-caps text-secondary uppercase tracking-widest">En stock • <?php echo $product->get_stock_quantity(); ?> unidades</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Primary Detail Canvas -->
    <section class="w-full px-margin md:px-margin-desktop py-space-md">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter-desktop items-start">
            
            <!-- Gallery Column (60% / 7 cols on lg) -->
            <div class="lg:col-span-7 flex flex-col md:flex-row gap-space-md">
                <?php
                $attachment_ids = $product->get_gallery_image_ids();
                $main_image_id  = $product->get_image_id();
                $all_images     = array_merge( array( $main_image_id ), $attachment_ids );
                $total_photos   = count( $all_images );
                
                if ( $all_images && $main_image_id ) :
                ?>
                <!-- Thumbnail Selector Desktop -->
                <div class="hidden md:flex flex-col gap-space-sm w-20 shrink-0 sticky top-36 self-start">
                    <?php foreach ( $all_images as $index => $image_id ) : ?>
                    <button class="group relative aspect-[4/5] bg-white overflow-hidden focus:outline-none opacity-70 hover:opacity-100 transition-opacity shadow-sm" onclick="scrollToView('photo-<?php echo $index; ?>')" type="button">
                        <?php echo wp_get_attachment_image( $image_id, 'woocommerce_thumbnail', false, array( 'class' => 'w-full h-full object-contain mix-blend-multiply group-hover:opacity-80 transition-opacity' ) ); ?>
                        <span class="absolute bottom-1 right-1 text-[9px] font-label-numeric font-medium px-1 bg-surface/80 text-on-surface"><?php echo sprintf('%02d', $index + 1); ?></span>
                    </button>
                    <?php endforeach; ?>
                </div>

                <!-- Main Imagery: Horizontal Scroll Snap on Mobile, Vertical Stack on Desktop -->
                <div class="flex-1 relative">
                    <div class="pswp-gallery flex overflow-x-auto snap-x snap-mandatory scrollbar-none md:block md:space-y-space-md" id="product-mobile-gallery">
                        <?php 
                        foreach ( $all_images as $index => $image_id ) : 
                            $image_src = wp_get_attachment_image_src( $image_id, 'full' );
                            $img_url   = $image_src ? $image_src[0] : '';
                            $img_w     = $image_src ? $image_src[1] : 1200;
                            $img_h     = $image_src ? $image_src[2] : 1500;
                        ?>
                        <div class="relative bg-white aspect-[4/5] w-full shrink-0 snap-center md:shrink md:w-auto overflow-hidden group shadow-sm" id="photo-<?php echo $index; ?>">
                            <a href="<?php echo esc_url($img_url); ?>" data-pswp-width="<?php echo esc_attr($img_w); ?>" data-pswp-height="<?php echo esc_attr($img_h); ?>" target="_blank" class="block w-full h-full cursor-zoom-in gs-magnifier">
                                <?php echo wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'w-full h-full object-contain mix-blend-multiply transition-transform duration-300 ease-out' ) ); ?>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if ( $total_photos > 1 ) : ?>
                    <!-- Mobile Photo Counter Pill -->
                    <div class="md:hidden absolute bottom-3 right-3 bg-surface/90 backdrop-blur-sm px-2.5 py-1 text-[11px] font-label-numeric text-on-surface shadow-sm">
                        <span id="gallery-current-index">1</span> / <?php echo $total_photos; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php else : ?>
                    <!-- Fallback placeholder si no hay imagen -->
                    <div class="flex-1 space-y-space-md">
                        <div class="relative bg-white aspect-[4/5] w-full overflow-hidden group shadow-sm">
                            <?php echo wc_placeholder_img('full'); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Purchasing & Details Column (40% / 5 cols on lg - Sticky) -->
            <div class="lg:col-span-5 lg:sticky lg:top-36 flex flex-col space-y-space-lg pt-space-xs">
                
                <!-- Header Info -->
                <div class="space-y-space-xs">
                    <div class="flex items-center justify-between">
                        <span class="font-label-caps text-label-caps uppercase tracking-[0.2em] text-secondary">
                            <?php 
                            $cats = wc_get_product_category_list( $product->get_id(), ', ' );
                            echo $cats ? wp_strip_all_tags($cats) : 'Colección Atrevidas'; 
                            ?>
                        </span>
                        <?php if ( wc_product_sku_enabled() && ( $sku = $product->get_sku() ) ) : ?>
                            <span class="font-label-numeric text-label-numeric text-secondary uppercase">SKU: <?php echo esc_html( $sku ); ?></span>
                        <?php endif; ?>
                    </div>
                    <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight font-normal">
                        <?php the_title(); ?>
                    </h1>
                    <div class="font-body-md text-body-md text-secondary line-clamp-3 md:line-clamp-none">
                        <?php the_excerpt(); ?>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="bg-surface-container-low p-space-md space-y-space-xs shadow-sm">
                    <div class="flex items-baseline gap-space-sm">
                        <span class="font-headline-lg text-headline-lg text-on-surface tracking-tight font-medium" id="pdp-main-price">
                            <?php echo $product->get_price_html(); ?>
                        </span>
                    </div>
                    <?php echo gs_get_best_discount_price_html( $product, 'pdp' ); ?>
                </div>

                <!-- WooCommerce Add To Cart (Handles Variations/Simple dynamically) -->
                <div class="space-y-space-sm pt-space-xs my-woo-add-to-cart-wrapper">
                    <?php
                    // This outputs the default WooCommerce form (variations/qty/button)
                    woocommerce_template_single_add_to_cart();
                    ?>
                </div>

                <!-- Accordions of Information (Dynamic store value promises) -->
                <?php
                $free_shipping_threshold = (float) get_option( 'free_shipping_threshold', 100000 );
                $transfer_pct            = (float) get_option( 'transfer_discount_percentage', 5 );
                $cod_pct                 = (float) get_option( 'cod_discount_percentage', 10 );
                $transfer_pct_label      = rtrim( rtrim( number_format( $transfer_pct, 1 ), '0' ), '.' );
                $cod_pct_label           = rtrim( rtrim( number_format( $cod_pct, 1 ), '0' ), '.' );
                ?>
                <div class="space-y-space-xs pt-space-xs">
                    <!-- Acordeón 1: Composición y Cuidados -->
                    <div class="bg-surface-container-low shadow-sm">
                        <button class="w-full p-space-md flex items-center justify-between text-left" onclick="toggleAccordion('acc-1')" type="button">
                            <span class="font-label-caps text-label-caps uppercase tracking-widest text-on-surface font-semibold flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">texture</span>
                                Composición & Cuidados
                            </span>
                            <span class="material-symbols-outlined text-[20px] text-on-surface transition-transform duration-300" id="acc-1-icon">expand_more</span>
                        </button>
                        <div class="grid transition-[grid-template-rows] duration-300 ease-in-out grid-rows-[0fr]" id="acc-1">
                            <div class="overflow-hidden">
                                <div class="px-space-md pb-space-md space-y-space-xs text-secondary font-body-sm text-body-sm">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Acordeón 2: Medios de Pago & Promociones -->
                    <div class="bg-surface-container-low shadow-sm">
                        <button class="w-full p-space-md flex items-center justify-between text-left" onclick="toggleAccordion('acc-2')" type="button">
                            <span class="font-label-caps text-label-caps uppercase tracking-widest text-on-surface font-semibold flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">payments</span>
                                Medios de Pago & Promociones
                            </span>
                            <span class="material-symbols-outlined text-[20px] text-on-surface transition-transform duration-300" id="acc-2-icon">expand_more</span>
                        </button>
                        <div class="grid transition-[grid-template-rows] duration-300 ease-in-out grid-rows-[0fr]" id="acc-2">
                            <div class="overflow-hidden">
                                <div class="px-space-md pb-space-md space-y-3 text-secondary font-body-sm text-body-sm">
                                    <div class="flex items-start gap-2.5">
                                        <span class="material-symbols-outlined text-[18px] text-on-surface shrink-0 mt-0.5">credit_card</span>
                                        <div>
                                            <strong class="text-primary block font-medium">Cuotas con Mercado Pago</strong>
                                            <span>Aceptamos todas las tarjetas de crédito y débito a través de la pasarela segura de Mercado Pago.</span>
                                        </div>
                                    </div>
                                    <?php if ( $transfer_pct > 0 ) : ?>
                                    <div class="flex items-start gap-2.5">
                                        <span class="material-symbols-outlined text-[18px] text-on-surface shrink-0 mt-0.5">account_balance</span>
                                        <div>
                                            <strong class="text-primary block font-medium"><?php echo esc_html( $transfer_pct_label ); ?>% OFF por Transferencia</strong>
                                            <span>Descuento automático aplicado directamente al seleccionar transferencia bancaria como medio de pago.</span>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ( $cod_pct > 0 ) : ?>
                                    <div class="flex items-start gap-2.5">
                                        <span class="material-symbols-outlined text-[18px] text-on-surface shrink-0 mt-0.5">payments</span>
                                        <div>
                                            <strong class="text-primary block font-medium"><?php echo esc_html( $cod_pct_label ); ?>% OFF en Efectivo (Contrareembolso)</strong>
                                            <span>Válido abonando en efectivo contra entrega únicamente para pedidos con destino en CABA y Gran Buenos Aires.</span>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Acordeón 3: Envíos & Retiro en Sucursal -->
                    <div class="bg-surface-container-low shadow-sm">
                        <button class="w-full p-space-md flex items-center justify-between text-left" onclick="toggleAccordion('acc-3')" type="button">
                            <span class="font-label-caps text-label-caps uppercase tracking-widest text-on-surface font-semibold flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">local_shipping</span>
                                Envíos & Retiro en Sucursal
                            </span>
                            <span class="material-symbols-outlined text-[20px] text-on-surface transition-transform duration-300" id="acc-3-icon">expand_more</span>
                        </button>
                        <div class="grid transition-[grid-template-rows] duration-300 ease-in-out grid-rows-[0fr]" id="acc-3">
                            <div class="overflow-hidden">
                                <div class="px-space-md pb-space-md space-y-3 text-secondary font-body-sm text-body-sm">
                                    <?php if ( $free_shipping_threshold > 0 ) : ?>
                                    <div class="flex items-start gap-2.5">
                                        <span class="material-symbols-outlined text-[18px] text-on-surface shrink-0 mt-0.5">redeem</span>
                                        <div>
                                            <strong class="text-primary block font-medium">Envío Bonificado desde <?php echo wc_price( $free_shipping_threshold ); ?></strong>
                                            <span>Superando este monto en tu carrito, el envío gratis a toda la Argentina se activa de forma automática.</span>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="flex items-start gap-2.5">
                                        <span class="material-symbols-outlined text-[18px] text-on-surface shrink-0 mt-0.5">local_shipping</span>
                                        <div>
                                            <strong class="text-primary block font-medium">Envíos a todo el país</strong>
                                            <span>Despachos diarios a través de Correo Argentino con código de seguimiento en tiempo real.</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-2.5">
                                        <span class="material-symbols-outlined text-[18px] text-on-surface shrink-0 mt-0.5">two_wheeler</span>
                                        <div>
                                            <strong class="text-primary block font-medium">Moto Express (CABA & GBA)</strong>
                                            <span>Servicio de mensajería rápida para entregas directas en el día o dentro de las 24-48 hs hábiles.</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-2.5">
                                        <span class="material-symbols-outlined text-[18px] text-on-surface shrink-0 mt-0.5">storefront</span>
                                        <div>
                                            <strong class="text-primary block font-medium">Retiro sin cargo en Haedo</strong>
                                            <span>Podés retirar tu pedido sin costo en nuestro punto de entrega oficial ubicado en Haedo, Gran Buenos Aires.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Complete The Look / Frequently Paired With Section (Up-sells) -->
    <?php
    $upsells = $product->get_upsell_ids();
    if ( $upsells ) : ?>
    <section class="w-full px-margin md:px-margin-desktop py-space-2xl bg-surface-container-lowest mt-space-xl">
        <div class="max-w-7xl mx-auto space-y-space-lg">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-sm">
                <div>
                    <span class="font-label-caps text-label-caps uppercase tracking-[0.2em] text-secondary">Styling Sugerido</span>
                    <h2 class="font-headline-md text-headline-md tracking-tight text-on-surface font-normal">Completa tu experiencia</h2>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter-desktop">
                <?php
                foreach ( $upsells as $upsell_id ) {
                    $upsell = wc_get_product( $upsell_id );
                    if ( ! $upsell ) continue;
                    ?>
                    <div class="group bg-surface-container-low p-space-md flex flex-col justify-between shadow-sm">
                        <div class="space-y-space-sm">
                            <a href="<?php echo esc_url( $upsell->get_permalink() ); ?>" class="relative aspect-square w-full bg-surface-container overflow-hidden block">
                                <?php echo $upsell->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500' ) ); ?>
                            </a>
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="font-headline-sm text-headline-sm font-medium text-on-surface"><?php echo esc_html( $upsell->get_name() ); ?></h3>
                                </div>
                                <span class="font-label-numeric text-label-numeric text-on-surface font-medium"><?php echo $upsell->get_price_html(); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Verified Client Reviews Section -->
    <?php if ( comments_open() || get_comments_number() ) : ?>
    <section class="w-full px-margin md:px-margin-desktop py-space-2xl bg-surface border-t border-surface-container mt-space-xl" id="product-reviews-section">
        <div class="max-w-6xl mx-auto">
            <?php comments_template(); ?>
        </div>
    </section>
    <?php endif; ?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
