<?php
/**
 * Template part for the Mobile Navigation Drawer (Grow Socks)
 */
defined( 'ABSPATH' ) || exit;

// Get product categories
$args = array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
    'parent'     => 0,
    'orderby'    => 'menu_order',
    'order'      => 'ASC',
);
$categories = get_terms( $args );
$shop_page_url = wc_get_page_permalink( 'shop' );
$myaccount_url = wc_get_page_permalink( 'myaccount' );
?>

<!-- Mobile Menu Backdrop Overlay -->
<div id="mobile-menu-overlay" class="fixed inset-0 bg-black/60 z-[100] hidden backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none" aria-hidden="true"></div>

<!-- Mobile Menu Drawer -->
<aside id="mobile-menu-drawer" class="fixed top-0 left-0 h-full w-[85%] max-w-[360px] bg-surface shadow-2xl z-[101] transform -translate-x-full transition-transform duration-300 ease-out flex flex-col justify-between overflow-hidden" aria-label="Menú de Navegación Principal" aria-hidden="true" inert>
    
    <!-- Top Bar: Logo & Close Button -->
    <div class="p-5 flex items-center justify-between border-b border-surface-container">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/logo.png' ); ?>" width="1416" height="672" loading="lazy" alt="<?php bloginfo( 'name' ); ?>" class="h-10 w-auto object-contain">
        </a>
        <button id="close-mobile-menu" type="button" class="w-11 h-11 flex items-center justify-center text-on-surface hover:text-secondary transition-colors p-2 cursor-pointer bg-transparent border-none" aria-label="Cerrar menú">
            <span class="material-symbols-outlined text-2xl">close</span>
        </button>
    </div>

    <!-- Scrollable Navigation Area -->
    <div class="flex-1 overflow-y-auto px-6 py-6 custom-scrollbar">
        
        <!-- Categorías de Productos -->
        <div class="mb-8">
            <p class="font-label-caps text-label-caps uppercase tracking-[0.2em] text-secondary mb-4">
                Categorías
            </p>
            <nav class="space-y-1">
                <a href="<?php echo esc_url( $shop_page_url ); ?>" class="flex items-center justify-between py-3 text-on-surface font-headline-sm text-headline-sm hover:text-secondary border-b border-surface-container/60 transition-colors">
                    <span>Ver Todo el Catálogo</span>
                    <span class="material-symbols-outlined text-secondary text-sm">arrow_forward_ios</span>
                </a>
                <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
                    <?php foreach ( $categories as $category ) : ?>
                        <?php 
                        if ( $category->slug === 'uncategorized' || $category->slug === 'sin-categorizar' ) {
                            continue;
                        }
                        $cat_link = get_term_link( $category );
                        ?>
                        <a href="<?php echo esc_url( $cat_link ); ?>" class="flex items-center justify-between py-3 text-on-surface font-body-lg text-body-lg hover:text-primary border-b border-surface-container/40 transition-colors">
                            <span><?php echo esc_html( $category->name ); ?></span>
                            <span class="font-label-numeric text-[11px] text-secondary bg-surface-container px-2 py-0.5 rounded-full">
                                <?php echo esc_html( $category->count ); ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </nav>
        </div>

        <!-- Links Secundarios y Cuenta -->
        <div class="mb-6 pt-2">
            <p class="font-label-caps text-label-caps uppercase tracking-[0.2em] text-secondary mb-3">
                Tu Cuenta
            </p>
            <ul class="space-y-2 list-none p-0 m-0 font-body-md text-body-md text-secondary">
                <li>
                    <a href="<?php echo esc_url( $myaccount_url ); ?>" class="flex items-center gap-3 py-2 text-on-surface hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-xl">person</span>
                        <span><?php echo is_user_logged_in() ? 'Mi Perfil & Pedidos' : 'Iniciar Sesión / Registrarse'; ?></span>
                    </a>
                </li>
                <!-- <li>
                    <a href="#" class="flex items-center gap-3 py-2 text-on-surface hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-xl">favorite</span>
                        <span>Lista de Deseos</span>
                    </a>
                </li> -->
                <li>
                    <a href="#" class="flex items-center gap-3 py-2 text-on-surface hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-xl">local_shipping</span>
                        <span>Seguimiento de Envíos</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Drawer Footer Info -->
    <div class="p-5 bg-surface-container-low border-t border-surface-container">
        <p class="font-label-caps text-[10px] uppercase tracking-wider text-secondary m-0 text-center">
            BY <a href="https://francoperdomo.com" target="_blank"><b>KARPI</b></a>
        </p>
    </div>
</aside>
