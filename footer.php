</main>

<footer class="w-full bg-surface-container-lowest text-on-surface">
    <div class="w-full px-margin md:px-margin-desktop py-space-2xl">
        <div class="mt-space-2xl pt-space-lg flex flex-col md:flex-row items-center justify-between gap-space-md">
            <p class="font-body-sm text-body-sm text-secondary">© <?php echo date('Y'); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. Todos los derechos reservados. | Desarrollado por <a href="https://francoperdomo.com" target="_blank" class="text-primary hover:underline transition-colors"><b>FrancoPerdomo.com</b></a></p>
        </div>
    </div>
</footer>

<!-- Cart Drawer Overlay -->
<div id="cart-drawer-overlay" class="fixed inset-0 bg-black/50 z-[100] hidden backdrop-blur-sm transition-opacity duration-300"></div>

<!-- Cart Drawer -->
<aside id="cart-drawer" class="fixed top-0 right-0 h-full w-full md:w-[400px] bg-surface-container-lowest shadow-2xl z-[101] transform translate-x-full transition-transform duration-300 flex flex-col" aria-label="Carrito lateral de compras" aria-hidden="true" inert>
    <!-- Header -->
    <div class="px-6 py-4 flex items-center justify-between border-b border-surface-container">
        <h2 class="font-headline-sm text-on-surface uppercase tracking-widest m-0 flex items-center gap-2">
            <span class="material-symbols-outlined">shopping_bag</span>
            Mi Carrito
        </h2>
        <button id="close-cart-drawer" class="text-secondary hover:text-primary transition-colors bg-transparent border-none cursor-pointer flex items-center p-1" aria-label="Cerrar Carrito">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <!-- WooCommerce Mini Cart Widget Content -->
    <div class="flex-1 overflow-y-auto px-6 py-4 custom-scrollbar">
        <div class="widget_shopping_cart_content">
            <?php woocommerce_mini_cart(); ?>
        </div>
    </div>
</aside>

<?php
// Phase 2/3 UI/UX Components
get_template_part( 'template-parts/mobile-menu' );
get_template_part( 'template-parts/search-modal' );
?>

<?php wp_footer(); ?>
</body>
</html>
