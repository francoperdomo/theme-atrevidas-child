<?php
/**
 * Mobile Filter Bottom Sheet (Grow Socks)
 */
defined( 'ABSPATH' ) || exit;
?>

<!-- Bottom Sheet Backdrop Overlay -->
<div id="filter-sheet-overlay" class="fixed inset-0 bg-black/60 z-[100] hidden backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none" aria-hidden="true"></div>

<!-- Mobile Bottom Sheet Drawer -->
<div id="filter-bottom-sheet" class="fixed bottom-0 left-0 right-0 max-h-[88vh] bg-surface rounded-t-2xl z-[101] shadow-2xl flex flex-col transform translate-y-full transition-transform duration-300 ease-out overflow-hidden" role="dialog" aria-modal="true" aria-label="Filtros del catálogo" aria-hidden="true" inert>
    
    <!-- Drag Handle Indicator -->
    <div class="pt-3 pb-1 flex justify-center cursor-pointer select-none" id="filter-sheet-handle">
        <div class="w-12 h-1 bg-outline-variant rounded-full"></div>
    </div>

    <!-- Header -->
    <div class="px-6 py-3 flex items-center justify-between border-b border-surface-container">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-on-surface text-xl">tune</span>
            <h3 class="font-headline-sm text-headline-sm text-on-surface uppercase tracking-wider m-0">Filtros y Categorías</h3>
        </div>
        <button id="close-filter-sheet" type="button" class="w-10 h-10 flex items-center justify-center text-on-surface hover:text-secondary p-1 cursor-pointer bg-transparent border-none" aria-label="Cerrar filtros">
            <span class="material-symbols-outlined text-2xl">close</span>
        </button>
    </div>

    <!-- Scrollable Controls -->
    <div class="flex-1 overflow-y-auto px-6 py-5 custom-scrollbar" id="filter-sheet-content">
        <?php get_template_part( 'template-parts/filter-controls' ); ?>
    </div>

    <!-- Sticky Bottom Bar -->
    <div class="p-4 bg-surface-container-low border-t border-surface-container flex items-center gap-3">
        <button type="button" id="apply-filters-sheet-btn" class="flex-1 bg-on-surface text-surface py-3.5 px-6 font-label-caps text-label-caps uppercase tracking-[0.16em] font-bold text-center border-none cursor-pointer hover:bg-neutral-800 transition-colors">
            Ver Resultados
        </button>
    </div>
</div>
