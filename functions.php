<?php
/**
 * Funciones del Child Theme
 */

add_action( 'wp_enqueue_scripts', 'simple_woo_child_enqueue_styles', 20 );
function simple_woo_child_enqueue_styles() {
    // Inyectamos la sobreescritura ligera de nuestras variables CSS.
    wp_enqueue_style(
        'simple-woo-child-tokens',
        get_stylesheet_directory_uri() . '/tokens.css',
        array('simple-woo-style'),
        wp_get_theme()->get('Version')
    );

    // Encolar estilo principal del child theme para overrides CSS
    wp_enqueue_style(
        'simple-woo-child-style',
        get_stylesheet_uri(),
        array('simple-woo-child-tokens'),
        filemtime( get_stylesheet_directory() . '/style.css' )
    );
}

/**
 * Añadir opciones al Personalizador para gestionar imágenes dinámicas.
 */
add_action( 'customize_register', 'atrevidas_customize_register' );
function atrevidas_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'atrevidas_hero_section', array(
        'title'    => __( 'Portada: Imágenes del Hero', 'theme-simple-woo' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'atrevidas_hero_lenceria', array( 'default' => '', 'transport' => 'refresh' ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'atrevidas_hero_lenceria', array(
        'label' => __( 'Imagen Mitad Lencería', 'theme-simple-woo' ), 'section' => 'atrevidas_hero_section', 'settings' => 'atrevidas_hero_lenceria'
    ) ) );

    $wp_customize->add_setting( 'atrevidas_hero_juguetes', array( 'default' => '', 'transport' => 'refresh' ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'atrevidas_hero_juguetes', array(
        'label' => __( 'Imagen Mitad Juguetes', 'theme-simple-woo' ), 'section' => 'atrevidas_hero_section', 'settings' => 'atrevidas_hero_juguetes'
    ) ) );
}

/**
 * Función Recursiva para automatizar el Mega Menú de WooCommerce.
 * Extrae toda la jerarquía de categorías respetando el orden manual (menu_order).
 */
function atrevidas_get_category_tree( $parent_id = 0 ) {
    $terms = get_terms( array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'parent'     => $parent_id,
        'orderby'    => 'menu_order',
        'order'      => 'ASC',
    ) );
    
    $tree = array();
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        foreach ( $terms as $term ) {
            // Excluir la categoría por defecto de WooCommerce
            if ( $term->slug === 'uncategorized' || $term->slug === 'sin-categorizar' ) {
                continue;
            }
            $tree[] = array(
                'term'     => $term,
                'children' => atrevidas_get_category_tree( $term->term_id ),
            );
        }
    }
    return $tree;
}

/**
 * Ocultar SKU en el frontend (pero mantenerlo en el backend para inventario)
 */
if ( ! is_admin() ) {
    add_filter( 'wc_product_sku_enabled', '__return_false' );
}
add_action( 'init', function() {
    if ( ! get_option( 'gs_badges_updated_once' ) ) {
        update_option( 'gs_show_low_stock_badge', 'no' );
        update_option( 'gs_new_arrival_days', '30' );
        update_option( 'gs_new_arrival_text', '✨ Nuevo Ingreso' );
        update_option( 'gs_badges_updated_once', true );
    }
});

/**
 * Añadir "Ritual de Cuidados" al final de los acordeones del producto.
 */
add_action( 'gs_after_single_product_accordions', 'atrevidas_custom_care_accordion' );
function atrevidas_custom_care_accordion() {
    ?>
    <!-- Acordeón 4: Guía de Cuidados (Atrevidas) -->
    <div class="bg-surface-container-low shadow-sm">
        <button class="w-full p-space-md flex items-center justify-between text-left" onclick="toggleAccordion('acc-4')" type="button">
            <span class="font-label-caps text-label-caps uppercase tracking-widest text-primary font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">favorite</span>
                Ritual de Cuidados
            </span>
            <span class="material-symbols-outlined text-[20px] text-primary transition-transform duration-300" id="acc-4-icon">expand_more</span>
        </button>
        <div class="grid transition-[grid-template-rows] duration-300 ease-in-out grid-rows-[0fr]" id="acc-4">
            <div class="overflow-hidden">
                <div class="px-space-md pb-space-md space-y-4 text-secondary font-body-sm text-body-sm">
                    <p class="font-body-md text-primary font-medium">Prolongá el placer. Seguí estos simples consejos para el cuidado de tus productos:</p>
                    
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-xl shrink-0 mt-0.5">water_drop</span>
                        <div>
                            <strong class="text-primary font-medium block">Higiene de Juguetes</strong>
                            <span>Laválos siempre antes y después de cada uso con jabón neutro o un limpiador especializado (Toy Cleaner). Usá agua tibia, nunca muy caliente.</span>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-xl shrink-0 mt-0.5">battery_charging_full</span>
                        <div>
                            <strong class="text-primary font-medium block">Carga y Baterías</strong>
                            <span>Para no dañar los motores recargables, no los dejes enchufados toda la noche. Una vez que la luz deje de parpadear (1-2 hs aprox), desconectalos.</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-xl shrink-0 mt-0.5">dry_cleaning</span>
                        <div>
                            <strong class="text-primary font-medium block">Lencería Fina</strong>
                            <span>Lavado a mano con agua fría y jabón suave. Si usás lavarropas, que sea en bolsa protectora y sin centrifugado para proteger encajes y elásticos.</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary text-xl shrink-0 mt-0.5">inventory_2</span>
                        <div>
                            <strong class="text-primary font-medium block">Almacenamiento</strong>
                            <span>Guardá los juguetes en sus fundas originales o bolsas de tela (nunca plástico). Evitá que los juguetes de silicona se toquen entre sí.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Reemplazar la barra de beneficios genérica por una sección educativa en el Archive de Atrevidas.
 */

add_action( 'gs_archive_benefits_bar', 'atrevidas_archive_educational_bar' );
function atrevidas_archive_educational_bar() {
    ?>
    <section class="w-full bg-surface-container-low py-space-xl px-margin md:px-margin-desktop mt-space-2xl border-t border-surface-container">
        <div class="max-w-7xl mx-auto space-y-space-xl">
            <div class="text-center max-w-2xl mx-auto">
                <span class="font-label-caps text-label-caps uppercase tracking-[0.2em] text-secondary">La Cultura Atrevida</span>
                <h3 class="font-headline-md text-headline-md text-primary mt-2">Cuidá tu placer y tus prendas</h3>
                <p class="font-body-md text-body-md text-secondary mt-3">Prolongá la vida útil de tus juguetes y lencería con estos tres simples hábitos.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-lg">
                <div class="flex flex-col items-center text-center p-space-lg bg-surface shadow-sm hover:shadow-md transition-shadow group border border-surface-container-lowest rounded-3xl">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[32px]">water_drop</span>
                    </div>
                    <h4 class="font-label-large uppercase tracking-wider text-primary font-bold mb-2">Higiene de Juguetes</h4>
                    <p class="font-body-sm text-secondary">Lavá tus juguetes antes y después de usar con agua tibia y jabón neutro. Secalos al aire libre sobre una toalla limpia.</p>
                </div>

                <div class="flex flex-col items-center text-center p-space-lg bg-surface shadow-sm hover:shadow-md transition-shadow group border border-surface-container-lowest rounded-3xl">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[32px]">battery_charging_full</span>
                    </div>
                    <h4 class="font-label-large uppercase tracking-wider text-primary font-bold mb-2">Motores y Baterías</h4>
                    <p class="font-body-sm text-secondary">Nunca dejes los vibradores cargando toda la noche. Una o dos horas son suficientes para cuidar la vida útil del motor.</p>
                </div>

                <div class="flex flex-col items-center text-center p-space-lg bg-surface shadow-sm hover:shadow-md transition-shadow group border border-surface-container-lowest rounded-3xl">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[32px]">dry_cleaning</span>
                    </div>
                    <h4 class="font-label-large uppercase tracking-wider text-primary font-bold mb-2">Delicadeza en Lencería</h4>
                    <p class="font-body-sm text-secondary">Lavá tus prendas a mano con agua fría. Si usás lavarropas, hacelo en bolsa protectora y sin usar centrifugado fuerte.</p>
                </div>
            </div>
        </div>
    </section>
    <?php
}
add_action( 'after_setup_theme', function() {
    remove_action( 'gs_archive_benefits_bar', 'simple_woo_archive_benefits_bar' );
}, 20 );
