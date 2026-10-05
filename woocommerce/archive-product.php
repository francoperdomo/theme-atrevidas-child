<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<div class="flex flex-col w-full">
    <!-- 1. Encabezado de Colección (Hero PLP sobrio y refinado) -->
    <section class="w-full bg-surface-container-low px-margin md:px-margin-desktop py-space-xl">
        <div class="max-w-7xl mx-auto flex flex-col gap-space-sm">
            <nav aria-label="Migas de pan" class="flex items-center gap-space-xs text-on-surface-variant font-label-caps text-label-caps uppercase tracking-widest">
                <?php woocommerce_breadcrumb( array('wrap_before' => '', 'wrap_after' => '', 'delimiter' => '<span class="text-outline">/</span>') ); ?>
            </nav>
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-space-md pt-space-xs">
                <div class="max-w-3xl space-y-space-xs">
                    <span class="font-label-caps text-label-caps uppercase tracking-[0.2em] text-secondary"></span>
                    <h1 class="font-headline-lg text-headline-lg tracking-tight text-on-surface uppercase"><?php woocommerce_page_title(); ?></h1>
                    <p class="font-body-lg text-body-lg text-secondary leading-relaxed max-w-2xl">
                        <?php do_action( 'woocommerce_archive_description' ); ?>
                    </p>
                </div>
                <div class="flex items-center gap-space-sm self-start lg:self-end bg-surface-container px-space-md py-space-xs rounded-none">
                    <span class="material-symbols-outlined text-[18px] text-on-surface">inventory_2</span>
                    <span class="font-label-caps text-label-caps uppercase tracking-widest text-on-surface"><?php echo wc_get_loop_prop('total'); ?> Productos</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Barra de control superior / Quick filters -->
    <section class="w-full bg-surface-container-lowest sticky top-[94px] sm:top-[96px] md:top-[118px] z-30 shadow-sm px-margin md:px-margin-desktop py-space-sm">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-space-md">

            <?php
            // Get contextual pill data from our helper
            $gs_nav = gs_get_contextual_category_pills();
            $gs_context     = $gs_nav['context'];
            $gs_active_term = $gs_nav['active_term'];
            $gs_pills       = $gs_nav['pills'];
            $gs_back_url    = $gs_nav['back_url'];
            $gs_back_label  = $gs_nav['back_label'];
            ?>

            <!-- Contextual Category Pills Navigation -->
            <div class="gs-cat-pills-wrapper relative flex items-center gap-space-xs w-full md:w-auto overflow-x-auto pb-space-xs md:pb-0 scrollbar-none transition-all duration-300 ease-in-out" id="quick-category-pills" aria-label="Categorías">

                <?php if ( $gs_back_url ) : ?>
                <!-- Back / Up navigation pill -->
                <a href="<?php echo esc_url( $gs_back_url ); ?>"
                   class="gs-cat-back-btn flex-shrink-0 flex items-center gap-1 whitespace-nowrap px-space-md py-space-xs font-label-caps text-label-caps uppercase tracking-wider bg-surface-container text-secondary hover:bg-surface-container-high hover:text-primary transition-colors border-none cursor-pointer no-underline"
                   aria-label="Volver a <?php echo esc_attr( $gs_back_label ); ?>">
                    <span class="material-symbols-outlined text-[14px] leading-none">arrow_back_ios</span>
                    <?php echo esc_html( $gs_back_label ); ?>
                </a>
                <?php endif; ?>

                <?php if ( $gs_context === 'root' ) : ?>
                <!-- ROOT: "Todas" pill as active -->
                <span class="gs-cat-pill-active flex-shrink-0 whitespace-nowrap px-space-md py-space-xs font-label-caps text-label-caps uppercase tracking-wider bg-primary text-on-primary border-none">
                    Todas
                </span>
                <?php elseif ( $gs_active_term ) :
                    // Use the actual loop total (includes products in sub-categories) instead of term->count
                    $gs_loop_total = (int) wc_get_loop_prop( 'total' );
                ?>
                <!-- PARENT or CHILD: current term pill as active -->
                <span class="gs-cat-pill-active flex-shrink-0 whitespace-nowrap px-space-md py-space-xs font-label-caps text-label-caps uppercase tracking-wider bg-primary text-on-primary border-none">
                    <?php echo esc_html( $gs_active_term->name ); ?>
                    <?php if ( $gs_loop_total > 0 ) : ?>
                    <span class="opacity-60 ml-1 font-label-numeric">(<?php echo esc_html( $gs_loop_total ); ?>)</span>
                    <?php endif; ?>
                </span>
                <?php endif; ?>

                <?php if ( ! empty( $gs_pills ) && ! is_wp_error( $gs_pills ) ) :
                    foreach ( $gs_pills as $pill ) :
                        if ( $pill->slug === 'uncategorized' || $pill->slug === 'sin-categorizar' ) continue;
                        $pill_url = get_term_link( $pill );
                ?>
                <a href="<?php echo esc_url( $pill_url ); ?>"
                   class="flex-shrink-0 whitespace-nowrap px-space-md py-space-xs font-label-caps text-label-caps uppercase tracking-wider bg-surface-container-high text-on-surface hover:bg-surface-container-highest transition-colors border-none cursor-pointer no-underline"
                   data-slug="<?php echo esc_attr( $pill->slug ); ?>">
                    <?php echo esc_html( $pill->name ); ?>
                    <span class="opacity-50 ml-1 font-label-numeric"><?php echo esc_html( $pill->count ); ?></span>
                </a>
                <?php
                    endforeach;
                endif;
                ?>

            </div>

            <div class="flex items-center justify-between md:justify-end gap-space-sm sm:gap-space-md w-full md:w-auto">
                <button class="flex items-center gap-space-xs bg-surface-container-high hover:bg-surface-container-highest px-space-md py-space-xs font-label-caps text-label-caps uppercase tracking-wider text-on-surface transition-all duration-200 cursor-pointer border-none relative select-none" id="toggle-filter-sidebar" type="button">
                    <span class="material-symbols-outlined text-[16px]" id="toggle-filter-icon">tune</span>
                    <span id="toggle-filter-label">Filtros y Categorías</span>
                    <span id="active-filters-count-badge" class="hidden font-label-numeric text-[10px] bg-primary text-on-primary w-4 h-4 rounded-full flex items-center justify-center">0</span>
                </button>

                <!-- Integrated Controls Cluster: Sort Icon + Grid Switcher -->
                <div class="flex items-center bg-surface-container-high p-0.5">
                    <?php woocommerce_catalog_ordering(); ?>

                    <!-- Subtle Vertical Divider (Desktop only) -->
                    <div class="hidden sm:block w-px h-4 bg-outline/20 mx-0.5"></div>

                    <!-- Desktop column toggles (3 vs 4 columns — 4 is default in exploration mode) -->
                    <div class="hidden sm:flex items-center">
                        <button class="flex items-center justify-center p-space-xs text-secondary hover:text-primary transition-colors cursor-pointer bg-transparent border-none" id="grid-col-3" title="Vista de 3 columnas" type="button"><span class="material-symbols-outlined text-[18px]">view_module</span></button>
                        <button class="flex items-center justify-center p-space-xs text-on-surface bg-surface-container-lowest transition-colors cursor-pointer border-none" id="grid-col-4" title="Vista de 4 columnas" type="button"><span class="material-symbols-outlined text-[18px]">grid_view</span></button>
                    </div>

                    <!-- Mobile column toggles (1 vs 2 columns) -->
                    <div class="flex sm:hidden items-center">
                        <button class="flex items-center justify-center p-space-xs text-on-surface bg-surface-container-lowest transition-colors cursor-pointer border-none" id="grid-col-1-mobile" title="Vista de 1 columna" type="button"><span class="material-symbols-outlined text-[18px]">splitscreen</span></button>
                        <button class="flex items-center justify-center p-space-xs text-secondary hover:text-primary transition-colors cursor-pointer border-none" id="grid-col-2-mobile" title="Vista de 2 columnas" type="button"><span class="material-symbols-outlined text-[18px]">grid_view</span></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Catalog Space (Sidebar + Grid) -->
    <section class="w-full px-margin md:px-margin-desktop py-space-lg">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-start">
            
            <!-- 3. Sidebar de Filtros Lateral (Desktop) — Inicia colapsado en Modo Exploración -->
            <aside class="w-full shrink-0 bg-surface-container-lowest shadow-sm transition-all duration-300 ease-in-out hidden lg:block sticky top-[180px] overflow-hidden lg:w-0 lg:p-0 lg:opacity-0 lg:border-none lg:mr-0" id="filter-sidebar">
                <?php get_template_part( 'template-parts/filter-controls' ); ?>
            </aside>

            <!-- 4. Grilla de Productos (PLP Grid) — Inicia en 4 columnas en Modo Exploración -->
            <div class="flex-1 w-full relative" id="shop-results-container"
                 data-total-products="<?php echo esc_attr( wc_get_loop_prop( 'total' ) ); ?>"
                 data-total-pages="<?php echo esc_attr( wc_get_loop_prop( 'total_pages' ) ); ?>"
                 data-current-page="<?php echo esc_attr( wc_get_loop_prop( 'current_page' ) ); ?>"
                 data-per-page="12">
                
                <!-- Loading Overlay (para filtros globales) -->
                <div id="shop-loading-overlay" class="absolute inset-0 bg-surface/70 backdrop-blur-[2px] z-20 flex items-center justify-center hidden opacity-0 transition-opacity duration-200">
                    <div class="flex flex-col items-center gap-3">
                        <div class="animate-spin rounded-full h-8 w-8 border-2 border-primary border-t-transparent"></div>
                        <span class="font-label-caps text-label-caps uppercase tracking-widest text-on-surface">Actualizando catálogo...</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md transition-opacity duration-200" id="product-grid">
                    <?php
                    if ( woocommerce_product_loop() ) {
                        woocommerce_product_loop_start( false );
                        if ( wc_get_loop_prop( 'total' ) ) {
                            while ( have_posts() ) {
                                the_post();
                                wc_get_template_part( 'content', 'product' );
                            }
                        }
                        woocommerce_product_loop_end( false );
                    } else {
                        do_action( 'woocommerce_no_products_found' );
                    }
                    ?>
                </div>

                <!-- 5. Infinite Scroll & Progress Status UI (Grow Socks Minimalist) -->
                <div id="infinite-scroll-status" class="w-full mt-space-xl flex flex-col items-center justify-center gap-space-md">
                    <!-- Barra de Progreso y Contador -->
                    <div id="infinite-scroll-progress" class="flex flex-col items-center gap-space-xs w-full max-w-xs text-center <?php echo ( wc_get_loop_prop( 'total' ) > 0 ) ? '' : 'hidden'; ?>">
                        <span class="font-label-caps text-label-caps uppercase tracking-widest text-secondary" id="infinite-scroll-count">
                            Mostrando <span id="current-visible-count"><?php echo min( 12, (int) wc_get_loop_prop( 'total' ) ); ?></span> de <span id="total-catalog-count"><?php echo esc_html( wc_get_loop_prop( 'total' ) ); ?></span> productos
                        </span>
                        <div class="w-full h-1 bg-surface-container-high rounded-full overflow-hidden">
                            <div id="infinite-scroll-progress-bar" class="h-full bg-primary transition-all duration-300" style="width: <?php echo esc_attr( min( 100, round( ( min( 12, (int) wc_get_loop_prop( 'total' ) ) / max( 1, (int) wc_get_loop_prop( 'total' ) ) ) * 100 ) ) ); ?>%;"></div>
                        </div>
                    </div>

                    <!-- Loader Spinner (visible exclusivamente al cargar la siguiente tanda por scroll) -->
                    <div id="infinite-scroll-loader" class="hidden flex items-center gap-space-sm text-on-surface py-space-sm">
                        <div class="animate-spin rounded-full h-5 w-5 border-2 border-primary border-t-transparent"></div>
                        <span class="font-label-caps text-label-caps uppercase tracking-widest">Cargando más prendas...</span>
                    </div>

                    <!-- Botón "Cargar Más" manual (aparece tras 4 tandas si aún restan productos) -->
                    <div id="infinite-scroll-action" class="hidden flex flex-col items-center gap-space-xs">
                        <button type="button" id="load-more-btn" class="px-space-xl py-space-md bg-primary text-on-primary font-label-caps text-label-caps uppercase tracking-widest hover:bg-neutral-800 active:scale-[0.98] transition-all cursor-pointer border-none shadow-sm flex items-center gap-space-xs">
                            <span>Cargar más prendas</span>
                            <span class="material-symbols-outlined text-[18px]">expand_more</span>
                        </button>
                    </div>

                    <!-- Mensaje Fin de Catálogo -->
                    <div id="infinite-scroll-end" class="<?php echo ( (int) wc_get_loop_prop( 'total_pages' ) <= 1 && (int) wc_get_loop_prop( 'total' ) > 0 ) ? '' : 'hidden'; ?> flex flex-col items-center gap-space-xs py-space-sm text-secondary">
                        <span class="material-symbols-outlined text-[22px] text-outline">check_circle</span>
                        <span class="font-label-caps text-label-caps uppercase tracking-widest">Has visto toda la colección</span>
                    </div>
                </div>

                <!-- Sentinel para IntersectionObserver -->
                <div id="infinite-scroll-sentinel" class="w-full h-4 pointer-events-none opacity-0"></div>

                <!-- Fallback de Paginación Accesible (SEO / No-JS) -->
                <div class="hidden" id="shop-pagination-container">
                    <?php 
                    woocommerce_pagination(array(
                        'prev_text' => '<span class="material-symbols-outlined text-[16px]">chevron_left</span>',
                        'next_text' => '<span class="material-symbols-outlined text-[16px]">chevron_right</span>'
                    )); 
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. Barra de beneficios -->
    <section class="w-full bg-surface-container-high py-space-lg px-margin md:px-margin-desktop mt-space-xl">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-space-md">
            <div class="flex items-center gap-space-md bg-surface-container-lowest p-space-md shadow-sm">
                <span class="material-symbols-outlined text-on-surface text-[32px]">local_shipping</span>
                <div class="space-y-0.5">
                    <h4 class="font-label-caps text-label-caps uppercase tracking-widest text-on-surface font-bold">Envíos a todo el país</h4>
                    <p class="font-body-sm text-body-sm text-secondary">Despacho diario vía Correo Argentino con código de seguimiento en vivo.</p>
                </div>
            </div>
            <!-- ... otros beneficios ... -->
        </div>
    </section>
</div>

<?php 
// Mobile Filter Bottom Sheet
get_template_part( 'template-parts/filter-bottom-sheet' ); 

get_footer( 'shop' ); 
?>
