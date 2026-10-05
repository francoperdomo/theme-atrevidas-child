<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) ) {
    $product = wc_get_product( get_the_ID() );
}

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<div <?php wc_product_class( 'group flex flex-col bg-surface-container-lowest shadow-sm overflow-hidden relative', $product ); ?>>
    <div class="relative w-full aspect-[4/5] bg-white overflow-hidden group/gallery">
        <?php 
        global $woocommerce_loop;
        $loop_idx = isset( $woocommerce_loop['loop'] ) ? (int) $woocommerce_loop['loop'] : 0;
        
        $img_attrs = array(
            'class' => 'w-full h-full object-contain transition-transform duration-700 group-hover:scale-105 mix-blend-multiply',
        );

        // Optimize LCP candidate: first product loads eagerly
        if ( $loop_idx <= 1 ) {
            $img_attrs['loading']       = 'eager';
            $img_attrs['fetchpriority'] = 'high';
            $img_attrs['decoding']      = 'async';
        } else {
            $img_attrs['loading']       = 'lazy';
            $img_attrs['decoding']      = 'async';
        }

        // Se usa 'medium_large' (768px) para garantizar nitidez en Mobile Retina y Desktop
        $main_image_html = $product->get_image( 'medium_large', $img_attrs ); 
        
        // Mobile gallery: Extraemos hasta 3 imágenes adicionales
        $gallery_image_ids = $product->get_gallery_image_ids();
        $gallery_image_ids = array_slice( $gallery_image_ids, 0, 3 );
        $has_gallery       = ! empty( $gallery_image_ids );
        ?>
        
        <?php if ( $has_gallery ) : ?>
        <div class="flex overflow-x-auto snap-x snap-mandatory h-full w-full scrollbar-none custom-scrollbar-hide" style="scrollbar-width: none; -ms-overflow-style: none;">
            <!-- Main Image -->
            <div class="snap-center w-full h-full flex-shrink-0 relative transition-opacity duration-700 md:group-hover/gallery:opacity-0">
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block w-full h-full">
                    <?php echo $main_image_html; ?>
                </a>
            </div>
            <!-- Gallery Images -->
            <?php 
            foreach ( $gallery_image_ids as $i => $attachment_id ) : 
                $gallery_attrs = $img_attrs;
                $gallery_attrs['loading']       = 'lazy';
                $gallery_attrs['fetchpriority'] = 'auto';
                
                // Desktop: Solo la primera foto de la galería hace el efecto flip. El resto se oculta.
                $desktop_classes = ( $i === 0 ) 
                    ? 'md:absolute md:inset-0 md:opacity-0 md:group-hover/gallery:opacity-100 transition-opacity duration-700 pointer-events-none md:pointer-events-auto' 
                    : 'md:hidden';
            ?>
                <div class="snap-center w-full h-full flex-shrink-0 relative <?php echo $desktop_classes; ?>">
                    <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block w-full h-full">
                        <?php echo wp_get_attachment_image( $attachment_id, 'medium_large', false, $gallery_attrs ); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Indicador visual (puntitos) -->
        <div class="absolute bottom-2 left-0 right-0 flex justify-center gap-1.5 pointer-events-none opacity-60 md:opacity-0 md:group-hover/gallery:opacity-100 transition-opacity duration-300">
            <!-- Primer punto (Activo por defecto, inactivo en hover en Desktop) -->
            <div class="w-1.5 h-1.5 rounded-full bg-primary md:group-hover/gallery:bg-outline-variant transition-colors duration-500"></div>
            
            <?php foreach ( $gallery_image_ids as $i => $attachment_id ) : ?>
                <!-- Segundo punto (Se activa en hover en Desktop, los demás quedan inactivos en mobile) -->
                <div class="w-1.5 h-1.5 rounded-full bg-outline-variant <?php echo ($i === 0) ? 'md:group-hover/gallery:bg-primary transition-colors duration-500' : 'md:hidden'; ?>"></div>
            <?php endforeach; ?>
        </div>

        <?php else : ?>
        <!-- Single Image fallback -->
        <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block w-full h-full">
            <?php echo $main_image_html; ?>
        </a>
        <?php endif; ?>
        
        <?php 
        $stock_badge_html = function_exists( 'gs_get_product_stock_badge_html' ) ? gs_get_product_stock_badge_html( $product ) : '';
        $is_on_sale       = $product->is_on_sale();
        ?>
        <?php if ( $is_on_sale || ! empty( $stock_badge_html ) ) : ?>
            <div class="absolute top-space-xs left-space-xs z-10 flex flex-col items-start gap-1 pointer-events-none">
                <?php if ( $is_on_sale ) : ?>
                    <span class="bg-primary text-on-primary font-label-caps text-[10px] uppercase tracking-wider px-2 py-0.5 shadow-xs">OFERTA</span>
                <?php endif; ?>
                <?php echo $stock_badge_html; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="p-space-md flex flex-col flex-1 justify-between gap-space-xs">
        <div class="space-y-1">
            <?php 
            $categories = wc_get_product_category_list( $product->get_id(), ', ' );
            if ( $categories ) {
                echo '<span class="font-label-caps text-[10px] uppercase tracking-widest text-secondary block">' . wp_strip_all_tags($categories) . '</span>';
            }
            ?>
            <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
                <h2 class="font-headline-sm text-headline-sm text-on-surface tracking-tight font-medium"><?php echo wp_kses_post( $product->get_title() ); ?></h2>
            </a>
        </div>
        
        <div class="pt-space-xs space-y-space-sm flex flex-col items-start w-full">
            <div class="space-y-1 w-full">
                <span class="font-headline-sm text-headline-sm font-semibold text-on-surface block w-full">
                    <?php echo $product->get_price_html(); ?>
                </span>
                <?php // echo gs_get_best_discount_price_html( $product ); ?>
            </div>
            
            <div class="w-full woocommerce-loop-btn-wrapper">
                <?php
                // Output the actual add to cart button/options button here
                woocommerce_template_loop_add_to_cart();
                ?>
            </div>
        </div>
    </div>
</div>
