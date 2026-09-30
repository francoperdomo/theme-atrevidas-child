<?php
/**
 * Front Page Atrevidas
 */
get_header(); 

// Recuperamos las imágenes dinámicas del personalizador. Fallback genérico si están vacías.
$img_lenceria = get_theme_mod( 'atrevidas_hero_lenceria' ) ?: 'https://via.placeholder.com/800x800/222222/dd1a83?text=Sube+tu+imagen+Lenceria+en+Apariencia>Personalizar';
$img_juguetes = get_theme_mod( 'atrevidas_hero_juguetes' ) ?: 'https://via.placeholder.com/800x800/222222/dd1a83?text=Sube+tu+imagen+Juguetes+en+Apariencia>Personalizar';
?>

<main class="pt-[96px] md:pt-[118px] bg-surface min-h-screen">
    
    <!-- 1. Hero Split Screen (Dinámico) -->
    <section class="w-full grid grid-cols-1 md:grid-cols-2 h-[65vh] min-h-[500px]">
        <!-- Mitad: Lencería -->
        <a href="<?php echo home_url('/categoria-producto/lenceria/'); ?>" 
           class="relative group flex flex-col justify-end p-margin md:p-margin-desktop bg-surface-container overflow-hidden"
           style="background-image: url('<?php echo esc_url($img_lenceria); ?>'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-black/40 group-hover:bg-black/30 transition-colors z-10"></div>
            <div class="relative z-20 text-white transform group-hover:-translate-y-2 transition-transform">
                <h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg mb-2">Lencería Erótica</h2>
                <p class="font-body-md text-body-md mb-6 opacity-90">Combiná talles y armá tu outfit perfecto.</p>
                <span class="inline-flex items-center px-6 py-3 bg-white text-primary font-bold rounded-full" style="border-radius: var(--radius-btn);">Ver Colección</span>
            </div>
        </a>
        
        <!-- Mitad: Juguetes -->
        <a href="<?php echo home_url('/categoria-producto/juguetes/'); ?>" 
           class="relative group flex flex-col justify-end p-margin md:p-margin-desktop bg-surface-container overflow-hidden"
           style="background-image: url('<?php echo esc_url($img_juguetes); ?>'); background-size: cover; background-position: center;">
            <div class="absolute inset-0 bg-black/40 group-hover:bg-black/30 transition-colors z-10"></div>
            <div class="relative z-20 text-white transform group-hover:-translate-y-2 transition-transform">
                <h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg mb-2">Sexshop & Juguetes</h2>
                <p class="font-body-md text-body-md mb-6 opacity-90">Descubrí diferentes formas de disfrutar.</p>
                <span class="inline-flex items-center px-6 py-3 bg-white text-primary font-bold rounded-full" style="border-radius: var(--radius-btn);">Explorar</span>
            </div>
        </a>
    </section>

    <!-- 2. Trust Badges (Garantía y Discreción) -->
    <section class="w-full bg-surface-container py-10 px-margin md:px-margin-desktop border-y border-black/5">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
            <div>
                <span class="block material-symbols-outlined text-4xl text-primary mb-2">local_shipping</span>
                <h3 class="font-bold text-primary mb-1">Envíos a todo el país</h3>
                <p class="text-secondary text-sm">Empaques con absoluta reserva y discreción.</p>
            </div>
            <div>
                <span class="block material-symbols-outlined text-4xl text-primary mb-2">verified</span>
                <h3 class="font-bold text-primary mb-1">Pagos Seguros</h3>
                <p class="text-secondary text-sm">Transferencia, tarjetas y efectivo.</p>
            </div>
            <div>
                <span class="block material-symbols-outlined text-4xl text-primary mb-2">forum</span>
                <h3 class="font-bold text-primary mb-1">Asesoramiento</h3>
                <p class="text-secondary text-sm">Atención personalizada vía WhatsApp.</p>
            </div>
        </div>
    </section>

    <!-- 3. Grillas de Productos (Top 10 y Nuevos Ingresos) -->
    <section class="w-full py-16 px-margin md:px-margin-desktop bg-surface">
        <div class="max-w-7xl mx-auto">
            
            <!-- Bloque: Top 10 Destacados (Soporta Orden Personalizado) -->
            <div class="mb-16">
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <h2 class="font-headline-md text-headline-md text-primary">Top 10 Más Deseados</h2>
                        <p class="text-secondary text-sm">Selección exclusiva para ti.</p>
                    </div>
                    <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="hidden md:inline-block font-bold text-primary hover:text-primary/80 transition-colors">Ver Todo →</a>
                </div>
                <!-- El parámetro orderby="menu_order" garantiza que se respete el orden que el cliente configure manualmente en WP -->
                <div class="gs-product-grid-wrapper">
                    <?php echo do_shortcode('[products limit="5" columns="5" orderby="menu_order" order="ASC"]'); ?>
                </div>
            </div>

            <!-- Bloque: Nuevos Ingresos -->
            <div>
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <h2 class="font-headline-md text-headline-md text-primary">Nuevos Ingresos</h2>
                        <p class="text-secondary text-sm">Lo último en tendencia para explorar.</p>
                    </div>
                    <a href="<?php echo wc_get_page_permalink('shop'); ?>" class="hidden md:inline-block font-bold text-primary hover:text-primary/80 transition-colors">Ver Novedades →</a>
                </div>
                <!-- orderby="date" asegura que los productos recién creados aparezcan primero -->
                <div class="gs-product-grid-wrapper">
                    <?php echo do_shortcode('[products limit="5" columns="5" orderby="date" order="DESC"]'); ?>
                </div>
            </div>

        </div>
    </section>

</main>

<?php get_footer(); ?>
