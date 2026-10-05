<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<meta name="description" content="<?php 
		if ( is_single() || is_page() ) {
			echo esc_attr( wp_strip_all_tags( get_the_excerpt() ? get_the_excerpt() : get_bloginfo( 'description' ) ) );
		} elseif ( is_product_taxonomy() ) {
			$term_desc = term_description();
			echo esc_attr( wp_strip_all_tags( $term_desc ? $term_desc : get_bloginfo( 'description' ) ) );
		} else {
			echo esc_attr( get_bloginfo( 'description' ) ? get_bloginfo( 'description' ) : 'Grow Socks - Calcetines y prendas de diseño con estándares textiles premium.' );
		}
	?>">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php wp_head(); ?>
    <?php if ( ! file_exists( get_template_directory() . '/assets/css/style.css' ) ) : ?>
        <script>
            // Tailwind config fallback for dev without CLI
            tailwind.config = <?php echo file_get_contents( get_template_directory() . '/tailwind.config.js' ); ?>;
            // Hack to remove module.exports for the CDN
            tailwind.config = Object.values(tailwind.config)[0];
        </script>
    <?php endif; ?>
</head>

<body <?php body_class('bg-surface font-body-md text-on-surface antialiased'); ?>>
<?php wp_body_open(); ?>

<header class="fixed top-0 left-0 w-full z-50 bg-surface/95 backdrop-blur-md">
    <div class="w-full bg-black text-white py-1.5 md:py-space-xs px-margin md:px-margin-desktop flex items-center justify-center">
        <?php
        $gs_threshold       = (float) get_option( 'free_shipping_threshold', 100000 );
        $gs_transfer        = (float) get_option( 'transfer_discount_percentage', 5 );
        $gs_cod             = (float) get_option( 'cod_discount_percentage', 10 );
        $gs_best_disc       = max( $gs_transfer, $gs_cod );
        $gs_best_disc_label = rtrim( rtrim( number_format( $gs_best_disc, 1 ), '0' ), '.' );
        $gs_thresh_clean    = function_exists('wc_price') ? wp_strip_all_tags( wc_price( $gs_threshold ) ) : '$' . number_format( $gs_threshold, 0, ',', '.' );
        ?>
        <p class="font-label-caps text-[9px] sm:text-[10px] md:text-label-caps uppercase text-center tracking-[0.06em] md:tracking-[0.14em] leading-tight">
            Envío Bonificado desde <?php echo esc_html( $gs_thresh_clean ); ?> • Retiro en Concepción del Uruguay • Tarjetas de Crédito y Débito
        </p>
    </div>
    <div class="h-16 md:h-20 lg:h-24 w-full px-margin md:px-margin-desktop flex items-center justify-between relative">
        <div class="flex-1 flex items-center">
            <nav class="hidden xl:flex items-center gap-space-md xl:gap-space-lg">
                <?php
                $category_tree = function_exists('atrevidas_get_category_tree') ? atrevidas_get_category_tree() : array();
                if ( ! empty( $category_tree ) ) {
                    echo '<ul class="flex items-center h-full m-0 p-0 list-none">';
                    foreach ( $category_tree as $node ) {
                        $term = $node['term'];
                        $has_children = ! empty( $node['children'] );
                        $link = get_term_link( $term );
                        
                        echo '<li class="group flex items-center h-full">';
                        // Botón Parent
                        echo '<a href="' . esc_url( $link ) . '" class="font-label-caps text-label-caps uppercase tracking-widest text-on-surface-variant hover:text-primary transition-colors py-6 px-3 whitespace-nowrap flex items-center gap-1">';
                        echo esc_html( $term->name );
                        if ($has_children) {
                            echo '<span class="material-symbols-outlined text-[16px]">expand_more</span>';
                        }
                        echo '</a>';
                        
                        // Panel Mega Menu Hover (Hijos & Nietos)
                        if ( $has_children ) {
                            echo '<div class="absolute top-full left-0 w-full hidden group-hover:block bg-surface shadow-2xl z-[100] border-t-2 border-primary overflow-hidden px-margin md:px-margin-desktop py-10" style="border-bottom-left-radius: var(--radius-xl); border-bottom-right-radius: var(--radius-xl);">';
                            echo '<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-x-12 gap-y-10 max-w-[1400px] mx-auto">';
                            
                            foreach ( $node['children'] as $child_node ) {
                                $child_term = $child_node['term'];
                                $child_link = get_term_link( $child_term );
                                $has_grandchildren = ! empty( $child_node['children'] );

                                echo '<div class="flex flex-col gap-3">';
                                // Título de la columna (Nivel 2)
                                if ( $has_grandchildren ) {
                                    echo '<a href="' . esc_url( $child_link ) . '" class="font-headline-sm text-[16px] text-on-surface font-semibold hover:text-primary transition-colors border-b border-surface-variant pb-2 mb-1 flex items-center justify-between group/title">';
                                    echo esc_html( $child_term->name );
                                    echo '<span class="material-symbols-outlined text-[16px] text-secondary group-hover/title:text-primary transition-colors">chevron_right</span>';
                                    echo '</a>';
                                    
                                    // Lista de sub-subcategorías (Nivel 3)
                                    echo '<ul class="m-0 p-0 list-none flex flex-col gap-2">';
                                    foreach ( $child_node['children'] as $grandchild_node ) {
                                        $grandchild_term = $grandchild_node['term'];
                                        $grandchild_link = get_term_link( $grandchild_term );
                                        echo '<li><a href="' . esc_url( $grandchild_link ) . '" class="font-body-md text-secondary hover:text-primary transition-colors block py-0.5">' . esc_html( $grandchild_term->name ) . '</a></li>';
                                    }
                                    echo '</ul>';
                                } else {
                                    // Nivel 2 simple (sin hijos)
                                    echo '<a href="' . esc_url( $child_link ) . '" class="font-headline-sm text-[16px] text-on-surface font-medium hover:text-primary transition-colors inline-block pb-2">';
                                    echo esc_html( $child_term->name );
                                    echo '</a>';
                                }
                                echo '</div>'; // End column
                            }
                            
                            echo '</div>'; // End grid

                            // Call to action de la categoría principal
                            echo '<div class="mt-8 pt-6 border-t border-surface-variant flex justify-end max-w-[1400px] mx-auto">';
                            echo '<a href="' . esc_url( $link ) . '" class="inline-flex items-center gap-2 font-label-caps text-label-caps uppercase tracking-widest text-primary hover:opacity-80 transition-opacity font-bold">Ver toda la colección ' . esc_html( $term->name ) . ' <span class="material-symbols-outlined text-[18px]">arrow_forward</span></a>';
                            echo '</div>';

                            echo '</div>'; // End mega menu panel
                        }
                        echo '</li>';
                    }
                    echo '</ul>';
                }
                ?>
            </nav>
            <button aria-label="Menu" class="xl:hidden text-on-surface hover:text-primary p-2 -ml-2 flex items-center justify-center min-w-[44px] min-h-[44px] cursor-pointer bg-transparent border-none transition-colors" type="button" id="open-mobile-menu">
                <span class="material-symbols-outlined text-[24px]">menu</span>
            </button>
        </div>
        
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 flex justify-center z-10 pointer-events-none">
            <?php
            $logo_src = get_stylesheet_directory_uri() . '/assets/logo.png';
            if ( has_custom_logo() ) {
                $custom_logo_id = get_theme_mod( 'custom_logo' );
                $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                if ( $image ) {
                    $logo_src = $image[0];
                }
            }
            ?>
            <a class="flex items-center group pointer-events-auto" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <img alt="<?php bloginfo( 'name' ); ?>" fetchpriority="high" class="max-h-10 md:max-h-12 lg:max-h-14 w-auto max-w-[150px] md:max-w-[200px] object-contain transition-transform duration-300 group-hover:scale-105" src="<?php echo esc_url( $logo_src ); ?>"/>
            </a>
        </div>
        
        <div class="flex-1 flex items-center justify-end gap-1 sm:gap-2 md:gap-space-md">
            <button aria-label="Buscar" class="text-on-surface hover:text-primary transition-colors p-2 flex items-center justify-center min-w-[40px] min-h-[40px] cursor-pointer bg-transparent border-none" type="button" id="open-search-modal">
                <span class="material-symbols-outlined text-[20px] md:text-[22px]">search</span>
            </button>
            <a aria-label="Mi Cuenta" class="hidden md:flex text-on-surface hover:text-primary transition-colors p-2 items-center justify-center" href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>">
                <span class="material-symbols-outlined text-[20px] md:text-[22px]">person</span>
            </a>
            <a aria-label="Carrito de compras" class="text-on-surface hover:text-primary transition-colors p-2 flex items-center gap-1 sm:gap-space-xs group toggle-cart-drawer cursor-pointer min-h-[40px]" href="#">
                <span class="material-symbols-outlined text-[20px] md:text-[22px]">shopping_bag</span>
                <span class="font-label-numeric text-label-numeric bg-primary text-white w-4 h-4 rounded-full flex items-center justify-center text-[10px]"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            </a>
        </div>
    </div>
</header>

<main class="w-full pt-[94px] sm:pt-[96px] md:pt-[118px] bg-surface min-h-screen">
