<?php
/**
 * Shared filter controls (Used in Desktop Sidebar and Mobile Bottom Sheet)
 * — Hierarchical category tree (parent → children with indentation)
 */
defined( 'ABSPATH' ) || exit;

// ─── Context Detection ─────────────────────────────────────────────────────
$current_term     = is_product_category() ? get_queried_object() : null;
$current_cat_slug = $current_term ? $current_term->slug : '';

// ─── Build Hierarchical Category Tree ──────────────────────────────────────
// Get ALL non-empty categories
$all_cats = get_terms( array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
) );

// Index by term_id and group children under parents
$cats_by_parent = array();
$cats_by_id     = array();

if ( ! empty( $all_cats ) && ! is_wp_error( $all_cats ) ) {
    foreach ( $all_cats as $cat ) {
        if ( $cat->slug === 'uncategorized' || $cat->slug === 'sin-categorizar' ) {
            continue;
        }
        $cats_by_id[ $cat->term_id ]              = $cat;
        $cats_by_parent[ $cat->parent ][]          = $cat;
    }
}

// ─── Get Price Range ────────────────────────────────────────────────────────
global $wpdb;
$price_query = $wpdb->get_row( "
    SELECT MIN(CAST(meta_value AS DECIMAL(10,2))) as min_price, 
           MAX(CAST(meta_value AS DECIMAL(10,2))) as max_price 
    FROM {$wpdb->postmeta} 
    WHERE meta_key = '_price' AND meta_value > 0
" );

$min_price_store = $price_query && $price_query->min_price ? floor( $price_query->min_price ) : 0;
$max_price_store = $price_query && $price_query->max_price ? ceil( $price_query->max_price )  : 15000;
?>

<div class="space-y-6 gs-filter-controls">

    <!-- Categorías — Árbol Jerárquico -->
    <div class="border-b border-surface-container pb-5">
        <div class="flex items-center justify-between mb-3">
            <span class="font-label-caps text-label-caps uppercase tracking-[0.16em] text-on-surface font-bold">
                Categorías
            </span>
            <span class="text-xs text-secondary font-label-numeric" id="selected-cats-count"></span>
        </div>

        <?php
        // Determine active top-level category for Accordion expansion
        $active_top_level_id = 0;
        if ( $current_term ) {
            if ( $current_term->parent > 0 ) {
                $ancestors = get_ancestors( $current_term->term_id, 'product_cat' );
                $active_top_level_id = empty( $ancestors ) ? $current_term->term_id : end( $ancestors );
            } else {
                $active_top_level_id = $current_term->term_id;
            }
        }
        ?>

        <div class="space-y-0.5 max-h-72 overflow-y-auto custom-scrollbar pr-1" id="gs-category-accordion">
            <?php
            // Render TOP-LEVEL categories (parent = 0)
            $top_level = isset( $cats_by_parent[0] ) ? $cats_by_parent[0] : array();

            // Sort top-level by count DESC
            usort( $top_level, function( $a, $b ) {
                return $b->count - $a->count;
            });

            foreach ( $top_level as $parent_cat ) :
                $is_parent_checked = ( $current_cat_slug === $parent_cat->slug );
                
                $first_children = isset( $cats_by_parent[ $parent_cat->term_id ] ) ? $cats_by_parent[ $parent_cat->term_id ] : array();
                $has_children = ! empty( $first_children );
                
                // If there's an active top level, only expand that one. If no active top level, expand none.
                $is_expanded = ( $active_top_level_id === $parent_cat->term_id );
                $branch_slug = $parent_cat->slug;

                gs_render_cat_row( $parent_cat, $is_parent_checked, 0, $has_children, $is_expanded, $branch_slug );

                if ( $has_children ) :
                    usort( $first_children, function( $a, $b ) {
                        return $b->count - $a->count;
                    });
                    ?>
                    <div class="gs-cat-children <?php echo $is_expanded ? '' : 'hidden'; ?>">
                    <?php
                    foreach ( $first_children as $child_cat ) :
                        $is_child_checked = ( $current_cat_slug === $child_cat->slug );
                        
                        $second_children = isset( $cats_by_parent[ $child_cat->term_id ] ) ? $cats_by_parent[ $child_cat->term_id ] : array();
                        $has_gc = ! empty( $second_children );
                        
                        gs_render_cat_row( $child_cat, $is_child_checked, 1, false, false, $branch_slug );

                        if ( $has_gc ) :
                            usort( $second_children, function( $a, $b ) {
                                return $b->count - $a->count;
                            });
                            foreach ( $second_children as $grandchild_cat ) :
                                $is_gc_checked = ( $current_cat_slug === $grandchild_cat->slug );
                                gs_render_cat_row( $grandchild_cat, $is_gc_checked, 2, false, false, $branch_slug );
                            endforeach;
                        endif;

                    endforeach;
                    ?>
                    </div>
                    <?php
                endif;

            endforeach;
            ?>
        </div>
    </div>

    <!-- Rango de Precio -->
    <div class="border-b border-surface-container pb-5">
        <div class="flex items-center justify-between mb-3">
            <span class="font-label-caps text-label-caps uppercase tracking-[0.16em] text-on-surface font-bold">
                Precio Máximo
            </span>
            <span class="font-label-numeric text-on-surface font-semibold text-[13px]" id="price-slider-display">
                Hasta $<?php echo number_format( $max_price_store, 0, ',', '.' ); ?>
            </span>
        </div>
        <div class="space-y-2">
            <input
                type="range"
                id="filter-max-price-range"
                name="filter_max_price"
                min="<?php echo esc_attr( $min_price_store ); ?>"
                max="<?php echo esc_attr( $max_price_store ); ?>"
                step="500"
                value="<?php echo esc_attr( $max_price_store ); ?>"
                class="gs-filter-input w-full accent-primary cursor-pointer h-1.5 bg-surface-container rounded-none"
                data-min="<?php echo esc_attr( $min_price_store ); ?>"
                data-max="<?php echo esc_attr( $max_price_store ); ?>"
            />
            <div class="flex items-center justify-between font-label-numeric text-[11px] text-secondary">
                <span>$<?php echo number_format( $min_price_store, 0, ',', '.' ); ?></span>
                <span>$<?php echo number_format( $max_price_store, 0, ',', '.' ); ?></span>
            </div>
        </div>
    </div>

    <!-- Filtros de Estado / Promoción -->
    <div class="space-y-2">
        <span class="font-label-caps text-label-caps uppercase tracking-[0.16em] text-on-surface font-bold block mb-2">
            Disponibilidad
        </span>
        <label class="flex items-center gap-2.5 py-1.5 px-2 hover:bg-surface-container-low transition-colors cursor-pointer group select-none">
            <input
                type="checkbox"
                name="filter_in_stock"
                value="1"
                class="gs-filter-input w-4 h-4 accent-primary cursor-pointer rounded-none"
            />
            <span class="font-body-md text-body-md text-on-surface">En Stock Inmediato</span>
        </label>
        <label class="flex items-center gap-2.5 py-1.5 px-2 hover:bg-surface-container-low transition-colors cursor-pointer group select-none">
            <input
                type="checkbox"
                name="filter_on_sale"
                value="1"
                class="gs-filter-input w-4 h-4 accent-primary cursor-pointer rounded-none"
            />
            <span class="font-body-md text-body-md text-on-surface">En Oferta</span>
        </label>
    </div>

    <!-- Limpiar Filtros -->
    <div class="pt-2">
        <button
            type="button"
            id="clear-all-filters-btn"
            class="w-full py-2.5 px-4 font-label-caps text-[11px] uppercase tracking-widest text-secondary hover:text-primary hover:bg-surface-container transition-colors border border-surface-container bg-transparent cursor-pointer hidden text-center"
        >
            Limpiar Todos los Filtros
        </button>
    </div>

</div>
