<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<!-- Progress Free Shipping Banner (Propuesta: Dinamizar con PHP) -->
<section class="w-full bg-surface-container-high py-space-sm px-margin md:px-margin-desktop mb-space-lg">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-space-xs md:gap-space-md">
        <?php
        // LOGICA: Obtener total del carrito y calcular contra el umbral configurado en backend
        $threshold = (float) get_option('free_shipping_threshold', 100000);
        $current_total = WC()->cart->get_subtotal();
        $percentage = ( $current_total / $threshold ) * 100;
        $percentage = $percentage > 100 ? 100 : $percentage;
        $missing = $threshold - $current_total;
        ?>
        <div class="flex items-center gap-space-xs text-left">
            <span class="material-symbols-outlined text-[18px] text-on-surface">local_shipping</span>
            <p class="font-body-sm text-body-sm text-on-surface">
                <?php if ( $missing > 0 ) : ?>
                    Te faltan <span class="font-semibold text-on-surface"><?php echo wc_price( $missing ); ?></span> para acceder a <strong class="tracking-wide">ENVÍO BONIFICADO</strong> a toda la Argentina.
                <?php else : ?>
                    <strong class="tracking-wide text-on-surface">¡Has alcanzado el ENVÍO BONIFICADO!</strong>
                <?php endif; ?>
            </p>
        </div>
        <div class="w-full md:w-64 flex items-center gap-space-sm">
            <div class="flex-1 h-1.5 bg-surface-variant overflow-hidden">
                <div class="h-full bg-primary transition-all duration-500 ease-out" id="shipping-progress-bar" style="width: <?php echo esc_attr( $percentage ); ?>%;"></div>
            </div>
            <span class="font-label-numeric text-[11px] text-secondary tracking-wider"><?php echo round($percentage); ?>%</span>
        </div>
    </div>
</section>

<!-- Page Editorial Header -->
<section class="w-full px-margin md:px-margin-desktop pb-space-lg bg-surface">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row md:items-end justify-between gap-space-sm">
        <div class="space-y-space-xs">
            <span class="font-label-caps text-label-caps uppercase tracking-[0.25em] text-secondary">SELECCIÓN TEXTIL</span>
            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight uppercase">Tu Bolsa de Compras</h1>
            <p class="font-body-md text-body-md text-secondary">
                <?php echo WC()->cart->get_cart_contents_count(); ?> piezas seleccionadas listas para embalaje artesanal.
            </p>
        </div>
    </div>
</section>

<!-- Main Content Layout -->
<section class="w-full px-margin md:px-margin-desktop pb-space-2xl bg-surface">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-start">
        
        <!-- Left Column: Items -->
        <div class="lg:col-span-7 space-y-space-xl">
            <form class="woocommerce-cart-form space-y-space-lg" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                <?php do_action( 'woocommerce_before_cart_table' ); ?>
                
                <?php
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                        ?>
                        <article class="bg-surface-container-lowest p-space-md shadow-sm transition-all hover:shadow-md flex flex-col sm:flex-row gap-space-md items-start relative group">
                            <!-- Image -->
                            <div class="w-full sm:w-36 h-48 bg-surface-container-low overflow-hidden flex-shrink-0 relative">
                                <?php
                                $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_thumbnail', array('class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-105')), $cart_item, $cart_item_key );
                                if ( ! $product_permalink ) {
                                    echo $thumbnail;
                                } else {
                                    printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                                }
                                ?>
                            </div>
                            
                            <div class="flex-1 flex flex-col justify-between h-full w-full space-y-space-sm">
                                <div class="flex justify-between items-start gap-space-sm">
                                    <div>
                                        <h2 class="font-headline-sm text-headline-sm text-on-surface">
                                            <?php
                                            if ( ! $product_permalink ) {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                            } else {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                            }
                                            ?>
                                        </h2>
                                        <div class="font-body-sm text-body-sm text-secondary mt-0.5">
                                            <?php echo wc_get_formatted_cart_item_data( $cart_item ); // Muestra variaciones como Talle y Color ?>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-label-numeric text-[17px] font-semibold text-on-surface block">
                                            <?php
                                            echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); 
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="pt-space-sm mt-auto flex items-center justify-between flex-wrap gap-space-sm">
                                    <!-- Qty -->
                                    <div class="flex items-center bg-surface-container-low px-space-xs py-1">
                                        <?php
                                        if ( $_product->is_sold_individually() ) {
                                            $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                        } else {
                                            $product_quantity = woocommerce_quantity_input(
                                                array(
                                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                                    'input_value'  => $cart_item['quantity'],
                                                    'max_value'    => $_product->get_max_purchase_quantity(),
                                                    'min_value'    => '0',
                                                    'product_name' => $_product->get_name(),
                                                    'classes'      => 'w-8 text-center font-label-numeric text-[13px] font-semibold text-on-surface bg-transparent outline-none border-none', // Tailwind class override
                                                ),
                                                $_product,
                                                false
                                            );
                                        }
                                        echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
                                        ?>
                                    </div>
                                    <!-- Remove -->
                                    <div class="flex items-center gap-space-md">
                                        <?php
                                        echo apply_filters(
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a href="%s" class="flex items-center gap-1 font-label-caps text-label-caps uppercase text-secondary hover:text-error transition-colors" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span class="material-symbols-outlined text-[15px]">delete</span><span>Quitar</span></a>',
                                                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                esc_html__( 'Remove this item', 'woocommerce' ),
                                                esc_attr( $product_id ),
                                                esc_attr( $_product->get_sku() )
                                            ),
                                            $cart_item_key
                                        );
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <?php
                    }
                }
                ?>
                <button type="submit" class="hidden" name="update_cart" value="Update cart">Update cart</button>
                <?php do_action( 'woocommerce_cart_actions' ); ?>
                <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
            </form>



            <!-- Cross-sells -->
            <?php woocommerce_cross_sell_display(); ?>

        </div>

        <!-- Right Column: Order Summary -->
        <div class="lg:col-span-5 lg:sticky lg:top-28 space-y-space-md">
            <div class="bg-surface-container-lowest p-space-lg shadow-md space-y-space-md">
                <?php woocommerce_cart_totals(); ?>
                
                <div class="pt-space-md space-y-space-sm">
                    <div class="flex items-center gap-space-sm text-secondary">
                        <span class="material-symbols-outlined text-[18px] text-on-surface">lock</span>
                        <span class="font-body-sm text-[12px]">Operación 100% encriptada y protegida</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php do_action( 'woocommerce_after_cart' ); ?>
