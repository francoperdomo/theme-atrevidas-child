<?php
/**
 * Front Page Atrevidas
 */
get_header(); 

$img_lenceria = get_theme_mod( 'atrevidas_hero_lenceria' ) ?: 'https://via.placeholder.com/800x800/222222/dd1a83?text=Sube+tu+imagen+Lenceria+en+Apariencia>Personalizar';
$img_juguetes = get_theme_mod( 'atrevidas_hero_juguetes' ) ?: 'https://via.placeholder.com/800x800/222222/dd1a83?text=Sube+tu+imagen+Juguetes+en+Apariencia>Personalizar';
?>

    
    <!-- 1. Hero Split Screen (Premium Cards) -->
    <section class="w-full px-4 sm:px-6 lg:px-8 py-6 md:py-8 bg-surface">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 gs-hero-split">
            <!-- Mitad: Lencería -->
            <a href="<?php echo home_url('/categoria-producto/lenceria/'); ?>" 
               class="relative group flex flex-col justify-end p-8 md:p-12 overflow-hidden shadow-lg"
               style="background-image: url('<?php echo esc_url($img_lenceria); ?>'); background-size: cover; background-position: center; border-radius: var(--radius-xl);">
                <div class="absolute inset-0 bg-black/40 group-hover:bg-black/30 transition-colors z-10"></div>
                <div class="relative z-20 text-white transform group-hover:-translate-y-1 transition-transform">
                    <h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg mb-2 drop-shadow-md">Lencería Erótica</h2>
                    <p class="font-body-md text-body-md mb-6 opacity-90 drop-shadow-md">Combiná talles y armá tu outfit perfecto.</p>
                    <span class="inline-flex items-center px-8 py-4 bg-primary text-white font-bold shadow-lg hover:opacity-90 transition-opacity" style="border-radius: var(--radius-btn);">Ver Colección</span>
                </div>
            </a>
            
            <!-- Mitad: Juguetes -->
            <a href="<?php echo home_url('/categoria-producto/juguetes/'); ?>" 
               class="relative group flex flex-col justify-end p-8 md:p-12 overflow-hidden shadow-lg"
               style="background-image: url('<?php echo esc_url($img_juguetes); ?>'); background-size: cover; background-position: center; border-radius: var(--radius-xl);">
                <div class="absolute inset-0 bg-black/40 group-hover:bg-black/30 transition-colors z-10"></div>
                <div class="relative z-20 text-white transform group-hover:-translate-y-1 transition-transform">
                    <h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg mb-2 drop-shadow-md">Sexshop & Juguetes</h2>
                    <p class="font-body-md text-body-md mb-6 opacity-90 drop-shadow-md">Descubrí diferentes formas de disfrutar.</p>
                    <span class="inline-flex items-center px-8 py-4 bg-primary text-white font-bold shadow-lg hover:opacity-90 transition-opacity" style="border-radius: var(--radius-btn);">Explorar</span>
                </div>
            </a>
        </div>
    </section>

    <!-- 2. Trust Badges (Garantía y Discreción) -->
    <section class="w-full bg-surface py-10 px-4 sm:px-6 lg:px-8 border-y border-black/5 mt-4">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="flex flex-col items-center">
                <span class="block material-symbols-outlined text-4xl text-on-surface mb-3">local_shipping</span>
                <h3 class="font-bold text-on-surface mb-1">Envíos a todo el país</h3>
                <p class="text-secondary text-sm">Empaques con absoluta reserva y discreción.</p>
            </div>
            <div class="flex flex-col items-center">
                <span class="block material-symbols-outlined text-4xl text-on-surface mb-3">verified</span>
                <h3 class="font-bold text-on-surface mb-1">Pagos Seguros</h3>
                <p class="text-secondary text-sm">Tarjetas de crédito y débito.</p>
            </div>
            <div class="flex flex-col items-center">
                <span class="block material-symbols-outlined text-4xl text-on-surface mb-3">forum</span>
                <h3 class="font-bold text-on-surface mb-1">Asesoramiento</h3>
                <p class="text-secondary text-sm">Atención personalizada vía WhatsApp.</p>
            </div>
        </div>
    </section>

    <!-- 3. Grillas de Productos (Top 10 y Nuevos Ingresos) -->
    <section class="w-full py-16 px-4 sm:px-6 lg:px-8 bg-surface">
        <div class="max-w-7xl mx-auto">
            
            <!-- Bloque: Top 10 Destacados -->
            <div class="mb-16">
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <h2 class="font-headline-md text-headline-md text-on-surface">Top 10 Más Deseados</h2>
                        <p class="text-secondary text-sm mt-1">Selección exclusiva para ti.</p>
                    </div>
                    <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="hidden md:inline-block font-bold text-primary hover:text-primary/80 transition-colors">Ver Todo →</a>
                </div>
                <div class="gs-product-grid-wrapper">
                    <?php echo do_shortcode('[products limit="5" columns="5" orderby="menu_order" order="ASC"]'); ?>
                </div>
            </div>

            <!-- Bloque: Nuevos Ingresos -->
            <div>
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <h2 class="font-headline-md text-headline-md text-on-surface">Nuevos Ingresos</h2>
                        <p class="text-secondary text-sm mt-1">Lo último en tendencia para explorar.</p>
                    </div>
                    <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="hidden md:inline-block font-bold text-primary hover:text-primary/80 transition-colors">Ver Novedades →</a>
                </div>
                <div class="gs-product-grid-wrapper">
                    <?php echo do_shortcode('[products limit="5" columns="5" orderby="date" order="DESC"]'); ?>
                </div>
            </div>

        </div>
    </section>


<?php get_footer(); ?>
