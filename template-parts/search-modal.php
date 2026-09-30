<?php
/**
 * Template part for the Live AJAX Search Overlay (Grow Socks)
 * Strictly focused on products.
 */
defined( 'ABSPATH' ) || exit;

// Fetch popular categories for quick suggestion chips
$quick_cats = get_terms( array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
    'number'     => 6,
    'orderby'    => 'count',
    'order'      => 'DESC',
) );
?>

<!-- Search Fullscreen Overlay -->
<div id="search-modal" class="fixed inset-0 bg-surface/98 backdrop-blur-md z-[110] hidden opacity-0 transition-opacity duration-300 flex flex-col justify-start" role="dialog" aria-modal="true" aria-label="Búsqueda de productos" aria-hidden="true" inert>
    
    <!-- Top Bar: Header & Close Button -->
    <div class="w-full border-b border-surface-container bg-surface/80">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
            <span class="font-label-caps text-label-caps uppercase tracking-[0.2em] text-secondary">
                Buscador de Productos
            </span>
            <button id="close-search-modal" type="button" class="w-11 h-11 flex items-center justify-center text-on-surface hover:text-secondary transition-colors cursor-pointer bg-transparent border-none p-1" aria-label="Cerrar buscador">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>
    </div>

    <!-- Search Input Section -->
    <div class="w-full bg-surface border-b border-surface-container py-6">
        <div class="max-w-4xl mx-auto px-4">
            <div class="relative flex items-center border-b-2 border-on-surface pb-3 transition-colors focus-within:border-on-surface">
                <span class="material-symbols-outlined text-on-surface text-3xl mr-3 shrink-0">search</span>
                <input 
                    type="search" 
                    id="live-search-input" 
                    placeholder="BUSCAR PRODUCTOS..." 
                    autocomplete="off" 
                    spellcheck="false" 
                    class="w-full bg-transparent text-base md:text-2xl font-medium text-on-surface placeholder:text-outline uppercase tracking-wider focus:outline-none border-none p-0"
                />
                <!-- Clear button -->
                <button id="clear-search-btn" type="button" class="hidden text-secondary hover:text-primary p-2 cursor-pointer bg-transparent border-none shrink-0" aria-label="Limpiar búsqueda">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
                <!-- Loading spinner -->
                <div id="search-spinner" class="hidden shrink-0 ml-2 animate-spin rounded-full h-5 w-5 border-2 border-on-surface border-t-transparent" aria-label="Cargando"></div>
            </div>

            <!-- Quick Suggestions / Chips -->
            <div id="search-quick-tags" class="mt-4 flex flex-wrap items-center gap-2">
                <span class="font-label-caps text-[10px] uppercase tracking-wider text-secondary mr-1">Sugerencias:</span>
                <?php if ( ! empty( $quick_cats ) && ! is_wp_error( $quick_cats ) ) : ?>
                    <?php foreach ( $quick_cats as $cat ) : ?>
                        <?php if ( $cat->slug === 'uncategorized' || $cat->slug === 'sin-categorizar' ) continue; ?>
                        <button type="button" class="search-tag-btn font-label-caps text-label-caps uppercase tracking-wider px-3 py-1 bg-surface-container-low hover:bg-on-surface hover:text-surface text-on-surface transition-colors border-none cursor-pointer" data-term="<?php echo esc_attr( $cat->name ); ?>">
                            <?php echo esc_html( $cat->name ); ?>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Live Results Container -->
    <div class="flex-1 overflow-y-auto w-full custom-scrollbar py-8">
        <div class="max-w-4xl mx-auto px-4">
            
            <!-- Default Placeholder Info -->
            <div id="search-initial-state" class="py-12 text-center space-y-2">
                <span class="material-symbols-outlined text-4xl text-outline mb-2">manage_search</span>
                <p class="font-headline-sm text-headline-sm text-on-surface">Encontrá tus medias y accesorios</p>
                <p class="font-body-md text-body-md text-secondary max-w-md mx-auto">Escribí al menos 2 caracteres para buscar entre todos nuestros modelos exclusivos en stock.</p>
            </div>

            <!-- No results message -->
            <div id="search-no-results" class="hidden py-12 text-center space-y-2">
                <span class="material-symbols-outlined text-4xl text-secondary mb-2">sentiment_dissatisfied</span>
                <p class="font-headline-sm text-headline-sm text-on-surface">Sin resultados</p>
                <p class="font-body-md text-body-md text-secondary" id="search-no-results-msg">No encontramos productos que coincidan con tu búsqueda.</p>
            </div>

            <!-- Product Cards Results Grid -->
            <div id="live-search-results-grid" class="hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Dynamically populated via JavaScript -->
            </div>

        </div>
    </div>
</div>
