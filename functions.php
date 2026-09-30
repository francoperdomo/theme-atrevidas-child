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
