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
        filemtime( get_stylesheet_directory() . '/tokens.css' )
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
 * Helper universal para leer theme_mods estandarizados (sw_*) con fallback a claves legacy (atrevidas_*).
 */
if ( ! function_exists( 'sw_child_get_mod' ) ) {
    function sw_child_get_mod( string $sw_key, $default = '', array $legacy_keys = array() ) {
        $val = get_theme_mod( $sw_key, null );
        if ( null !== $val && '' !== $val ) {
            return $val;
        }
        foreach ( $legacy_keys as $old_key ) {
            $old_val = get_theme_mod( $old_key, null );
            if ( null !== $old_val && '' !== $old_val ) {
                return $old_val;
            }
        }
        return $default;
    }
}

/**
 * Mapa de migración de claves legacy (atrevidas_*) a claves universales (sw_*).
 */
function atrevidas_get_legacy_mods_map(): array {
    return array(
        'sw_hero_image_desktop' => 'atrevidas_hero_banner_img',
        'sw_hero_image'         => 'atrevidas_hero_banner_img_mobile',
        'sw_hero_subtitle'      => 'atrevidas_hero_banner_subtitle',
        'sw_hero_title'         => 'atrevidas_hero_banner_title',
        'sw_hero_desc'          => 'atrevidas_hero_banner_desc',
        'sw_hero_btn1_text'     => 'atrevidas_hero_banner_btn1_text',
        'sw_hero_btn1_url'      => 'atrevidas_hero_banner_btn1_url',
        'sw_hero_btn2_text'     => 'atrevidas_hero_banner_btn2_text',
        'sw_hero_btn2_url'      => 'atrevidas_hero_banner_btn2_url',
        'sw_portal1_img'        => 'atrevidas_hero_lenceria',
        'sw_portal2_img'        => 'atrevidas_hero_juguetes',
        'sw_whatsapp_number'    => 'atrevidas_whatsapp_number',
        'sw_whatsapp_msg'       => 'atrevidas_whatsapp_msg',
        'sw_spotlight_img'      => 'atrevidas_spotlight_img',
        'sw_spotlight_tag'      => 'atrevidas_spotlight_tag',
        'sw_spotlight_title'    => 'atrevidas_spotlight_title',
        'sw_spotlight_desc'     => 'atrevidas_spotlight_desc',
    );
}

/**
 * Migración automática única en base de datos de atrevidas_* a sw_* para preservar datos de producción.
 */
add_action( 'init', 'atrevidas_migrate_legacy_mods_to_sw', 5 );
function atrevidas_migrate_legacy_mods_to_sw() {
    if ( get_option( 'sw_atrevidas_mods_migrated_v1' ) === 'yes' ) {
        return;
    }
    foreach ( atrevidas_get_legacy_mods_map() as $sw_key => $old_key ) {
        $current = get_theme_mod( $sw_key, null );
        if ( null === $current || '' === $current ) {
            $old_val = get_theme_mod( $old_key, null );
            if ( null !== $old_val && '' !== $old_val ) {
                set_theme_mod( $sw_key, $old_val );
            }
        }
    }
    update_option( 'sw_atrevidas_mods_migrated_v1', 'yes' );
}

/**
 * Inyectar defaults comerciales propios de Atrevidas en el motor Core.
 */
add_filter( 'simple_woo_default_options', 'atrevidas_child_default_options' );
function atrevidas_child_default_options( array $defaults ): array {
    return array_merge( $defaults, array(
        'enable_mega_menu'        => 'yes',
        'top_announcement_text'   => '🔥 10% OFF Efectivo (Concepción del Uruguay) | 5% OFF Transferencia | Envíos 100% Discretos a todo el país 🚀',
        'gs_pickup_title'         => 'Retiro sin cargo',
        'gs_pickup_description'   => 'Retirá sin costo en nuestro punto de entrega con total discreción.',
        'gs_express_title'        => 'Envío Rápido y Discreto',
        'gs_express_description'  => 'Recibí tu pedido en <strong>24 a 48 hs hábiles</strong> en empaque 100% reservado.',
        'gs_correo_title'         => 'Envíos 100% Discretos a todo el país',
        'gs_correo_description'   => 'Despachamos en cajas lisas sin logos a domicilio o sucursal de Correo.',
        'gs_cod_description'      => 'en Efectivo / Contrareembolso',
        'gs_show_low_stock_badge' => 'no',
        'gs_new_arrival_days'     => '30',
        'gs_new_arrival_text'     => '✨ Nuevo Ingreso',
        'gs_whatsapp_message'     => sw_child_get_mod( 'sw_whatsapp_msg', 'Hola Atrevidas! Quiero hacer una consulta con total discreción.', array( 'atrevidas_whatsapp_msg' ) ),
        'gs_archive_subtitle'     => 'Colección Exclusiva',
        'gs_cross_sell_subtitle'  => 'Selección Sugerida',
        'gs_cross_sell_title'     => 'Completá tu Experiencia',
    ) );
}

/**
 * Añadir opciones al Personalizador con claves universales (sw_*) y controles completos.
 */
add_action( 'customize_register', 'atrevidas_customize_register' );
function atrevidas_customize_register( $wp_customize ) {
    // --- SECCIÓN HERO PRINCIPAL (BANNER PANORÁMICO) ---
    $wp_customize->add_section( 'sw_hero_section', array(
        'title'    => __( 'Portada: Hero Principal (Banner)', 'theme-simple-woo' ),
        'priority' => 29,
    ) );

    $wp_customize->add_setting( 'sw_hero_image_desktop', array( 'default' => sw_child_get_mod( 'sw_hero_image_desktop', '', array( 'atrevidas_hero_banner_img' ) ), 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sw_hero_image_desktop', array(
        'label'   => __( 'Imagen Desktop (Panorámica)', 'theme-simple-woo' ),
        'section' => 'sw_hero_section',
    ) ) );

    $wp_customize->add_setting( 'sw_hero_image', array( 'default' => sw_child_get_mod( 'sw_hero_image', '', array( 'atrevidas_hero_banner_img_mobile' ) ), 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sw_hero_image', array(
        'label'   => __( 'Imagen Móvil (Vertical)', 'theme-simple-woo' ),
        'section' => 'sw_hero_section',
    ) ) );

    $wp_customize->add_setting( 'sw_hero_subtitle', array( 'default' => 'Nueva Colección · Lencería & Bienestar', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'sw_hero_subtitle', array( 'label' => __( 'Subtítulo Superior', 'theme-simple-woo' ), 'section' => 'sw_hero_section', 'type' => 'text' ) );

    $wp_customize->add_setting( 'sw_hero_title', array( 'default' => 'Viví tu sensualidad<br>con total libertad.', 'transport' => 'refresh', 'sanitize_callback' => 'wp_kses_post' ) );
    $wp_customize->add_control( 'sw_hero_title', array( 'label' => __( 'Título Principal (acepta <br>)', 'theme-simple-woo' ), 'section' => 'sw_hero_section', 'type' => 'textarea' ) );

    $wp_customize->add_setting( 'sw_hero_desc', array( 'default' => 'Diseños exclusivos y accesorios de calidad superior pensados para tu máximo placer y confort.', 'transport' => 'refresh', 'sanitize_callback' => 'wp_kses_post' ) );
    $wp_customize->add_control( 'sw_hero_desc', array( 'label' => __( 'Descripción', 'theme-simple-woo' ), 'section' => 'sw_hero_section', 'type' => 'textarea' ) );

    $wp_customize->add_setting( 'sw_hero_btn1_text', array( 'default' => 'Ver Lencería', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'sw_hero_btn1_text', array( 'label' => 'Botón 1: Texto', 'section' => 'sw_hero_section', 'type' => 'text' ) );
    $wp_customize->add_setting( 'sw_hero_btn1_url', array( 'default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'sw_hero_btn1_url', array( 'label' => 'Botón 1: URL', 'section' => 'sw_hero_section', 'type' => 'url' ) );

    $wp_customize->add_setting( 'sw_hero_btn2_text', array( 'default' => 'Explorar Sexshop ✨', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'sw_hero_btn2_text', array( 'label' => 'Botón 2: Texto', 'section' => 'sw_hero_section', 'type' => 'text' ) );
    $wp_customize->add_setting( 'sw_hero_btn2_url', array( 'default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'sw_hero_btn2_url', array( 'label' => 'Botón 2: URL', 'section' => 'sw_hero_section', 'type' => 'url' ) );

    // --- SECCIÓN PORTALES DUALES ---
    $wp_customize->add_section( 'sw_portals_section', array(
        'title'    => __( 'Portada: Portales Duales (Lencería vs Juguetes)', 'theme-simple-woo' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'sw_portal1_img', array( 'default' => sw_child_get_mod( 'sw_portal1_img', '', array( 'atrevidas_hero_lenceria' ) ), 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sw_portal1_img', array(
        'label' => __( 'Portal 1: Imagen (Lencería)', 'theme-simple-woo' ), 'section' => 'sw_portals_section', 'settings' => 'sw_portal1_img'
    ) ) );
    $wp_customize->add_setting( 'sw_portal1_tag', array( 'default' => 'Colección', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'sw_portal1_tag', array( 'label' => 'Portal 1: Tag', 'section' => 'sw_portals_section', 'type' => 'text' ) );
    $wp_customize->add_setting( 'sw_portal1_title', array( 'default' => 'Lencería Erótica', 'transport' => 'refresh', 'sanitize_callback' => 'wp_kses_post' ) );
    $wp_customize->add_control( 'sw_portal1_title', array( 'label' => 'Portal 1: Título', 'section' => 'sw_portals_section', 'type' => 'text' ) );
    $wp_customize->add_setting( 'sw_portal1_desc', array( 'default' => 'Combiná talles y armá tu outfit perfecto.', 'transport' => 'refresh', 'sanitize_callback' => 'wp_kses_post' ) );
    $wp_customize->add_control( 'sw_portal1_desc', array( 'label' => 'Portal 1: Descripción', 'section' => 'sw_portals_section', 'type' => 'textarea' ) );
    $wp_customize->add_setting( 'sw_portal1_btn', array( 'default' => 'Ver Colección', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'sw_portal1_btn', array( 'label' => 'Portal 1: Botón', 'section' => 'sw_portals_section', 'type' => 'text' ) );
    $wp_customize->add_setting( 'sw_portal1_url', array( 'default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'sw_portal1_url', array( 'label' => 'Portal 1: URL', 'section' => 'sw_portals_section', 'type' => 'url' ) );

    $wp_customize->add_setting( 'sw_portal2_img', array( 'default' => sw_child_get_mod( 'sw_portal2_img', '', array( 'atrevidas_hero_juguetes' ) ), 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sw_portal2_img', array(
        'label' => __( 'Portal 2: Imagen (Juguetes)', 'theme-simple-woo' ), 'section' => 'sw_portals_section', 'settings' => 'sw_portal2_img'
    ) ) );
    $wp_customize->add_setting( 'sw_portal2_tag', array( 'default' => 'Sexshop', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'sw_portal2_tag', array( 'label' => 'Portal 2: Tag', 'section' => 'sw_portals_section', 'type' => 'text' ) );
    $wp_customize->add_setting( 'sw_portal2_title', array( 'default' => 'Sexshop & Juguetes', 'transport' => 'refresh', 'sanitize_callback' => 'wp_kses_post' ) );
    $wp_customize->add_control( 'sw_portal2_title', array( 'label' => 'Portal 2: Título', 'section' => 'sw_portals_section', 'type' => 'text' ) );
    $wp_customize->add_setting( 'sw_portal2_desc', array( 'default' => 'Descubrí diferentes formas de disfrutar.', 'transport' => 'refresh', 'sanitize_callback' => 'wp_kses_post' ) );
    $wp_customize->add_control( 'sw_portal2_desc', array( 'label' => 'Portal 2: Descripción', 'section' => 'sw_portals_section', 'type' => 'textarea' ) );
    $wp_customize->add_setting( 'sw_portal2_btn', array( 'default' => 'Explorar', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'sw_portal2_btn', array( 'label' => 'Portal 2: Botón', 'section' => 'sw_portals_section', 'type' => 'text' ) );
    $wp_customize->add_setting( 'sw_portal2_url', array( 'default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'sw_portal2_url', array( 'label' => 'Portal 2: URL', 'section' => 'sw_portals_section', 'type' => 'url' ) );

    // --- SECCIÓN WHATSAPP & CONTACTO ---
    $wp_customize->add_section( 'sw_whatsapp_section', array(
        'title'    => __( 'Atrevidas: WhatsApp y Atención', 'theme-simple-woo' ),
        'priority' => 31,
    ) );

    $wp_customize->add_setting( 'sw_whatsapp_number', array( 'default' => sw_child_get_mod( 'sw_whatsapp_number', '', array( 'atrevidas_whatsapp_number' ) ), 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'sw_whatsapp_number', array(
        'label'       => __( 'Número de WhatsApp Oficial', 'theme-simple-woo' ),
        'description' => __( 'Ej: 5491123456789 o 11 2345-6789. Se aplicará automáticamente al botón flotante y asesoramiento.', 'theme-simple-woo' ),
        'section'     => 'sw_whatsapp_section',
        'type'        => 'text',
    ) );

    $wp_customize->add_setting( 'sw_whatsapp_msg', array(
        'default'           => 'Hola Atrevidas! Quiero hacer una consulta con total discreción.',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    $wp_customize->add_control( 'sw_whatsapp_msg', array(
        'label'       => __( 'Mensaje predeterminado de WhatsApp', 'theme-simple-woo' ),
        'description' => __( 'Texto con el que iniciará la conversación el cliente.', 'theme-simple-woo' ),
        'section'     => 'sw_whatsapp_section',
        'type'        => 'textarea',
    ) );

    // --- SECCIÓN SPOTLIGHT (CULTURA ATREVIDA) ---
    $wp_customize->add_section( 'sw_spotlight_section', array(
        'title'    => __( 'Portada: Banner Spotlight', 'theme-simple-woo' ),
        'priority' => 32,
    ) );

    $wp_customize->add_setting( 'sw_spotlight_img', array( 'default' => sw_child_get_mod( 'sw_spotlight_img', '', array( 'atrevidas_spotlight_img' ) ), 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sw_spotlight_img', array(
        'label'   => __( 'Imagen de Campaña', 'theme-simple-woo' ),
        'section' => 'sw_spotlight_section',
    ) ) );

    $wp_customize->add_setting( 'sw_spotlight_tag', array( 'default' => '✨ Cultura Atrevida', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'sw_spotlight_tag', array( 'label' => __( 'Tag Superior', 'theme-simple-woo' ), 'section' => 'sw_spotlight_section', 'type' => 'text' ) );

    $wp_customize->add_setting( 'sw_spotlight_title', array( 'default' => 'Explorá tu sensualidad sin tabúes y a tu propio ritmo.', 'transport' => 'refresh', 'sanitize_callback' => 'wp_kses_post' ) );
    $wp_customize->add_control( 'sw_spotlight_title', array( 'label' => __( 'Título Principal', 'theme-simple-woo' ), 'section' => 'sw_spotlight_section', 'type' => 'textarea' ) );

    $wp_customize->add_setting( 'sw_spotlight_desc', array( 'default' => 'Seleccionamos cada prenda y cada accesorio pensando en tu bienestar, seguridad y máximo placer. Calidad superior con asesoramiento personalizado y confidencial.', 'transport' => 'refresh', 'sanitize_callback' => 'wp_kses_post' ) );
    $wp_customize->add_control( 'sw_spotlight_desc', array( 'label' => __( 'Descripción', 'theme-simple-woo' ), 'section' => 'sw_spotlight_section', 'type' => 'textarea' ) );

    $default_spotlight_bullets = array(
        1 => array( 'icon' => 'favorite', 'title' => 'Materiales Seguros para tu Cuerpo', 'desc' => 'Silicona médica grado alimentario, libres de ftalatos y lencería con acabados suaves.' ),
        2 => array( 'icon' => 'lock', 'title' => 'Discreción y Privacidad Garantizada', 'desc' => 'Envío completamente sellado y facturación reservada sin menciones al rubro.' ),
        3 => array( 'icon' => 'forum', 'title' => 'Asesoramiento Sin Prejuicios', 'desc' => 'Consultanos por WhatsApp y te ayudamos a elegir la opción ideal para vos o tu pareja.' ),
    );
    foreach ( $default_spotlight_bullets as $i => $b ) {
        $wp_customize->add_setting( "sw_spotlight_li{$i}_icon", array( 'default' => $b['icon'], 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( "sw_spotlight_li{$i}_icon", array( 'label' => "Viñeta {$i}: Ícono (Material Symbol)", 'section' => 'sw_spotlight_section', 'type' => 'text' ) );
        $wp_customize->add_setting( "sw_spotlight_li{$i}_title", array( 'default' => $b['title'], 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( "sw_spotlight_li{$i}_title", array( 'label' => "Viñeta {$i}: Título", 'section' => 'sw_spotlight_section', 'type' => 'text' ) );
        $wp_customize->add_setting( "sw_spotlight_li{$i}_desc", array( 'default' => $b['desc'], 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( "sw_spotlight_li{$i}_desc", array( 'label' => "Viñeta {$i}: Descripción", 'section' => 'sw_spotlight_section', 'type' => 'text' ) );
    }

    $wp_customize->add_setting( 'sw_spotlight_btn', array( 'default' => 'Explorar Catálogo Completo', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'sw_spotlight_btn', array( 'label' => 'Botón: Texto', 'section' => 'sw_spotlight_section', 'type' => 'text' ) );
    $wp_customize->add_setting( 'sw_spotlight_url', array( 'default' => '', 'transport' => 'refresh', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'sw_spotlight_url', array( 'label' => 'Botón: URL', 'section' => 'sw_spotlight_section', 'type' => 'url' ) );

    // --- SECCIÓN TRUST PILLARS ---
    $wp_customize->add_section( 'sw_trust_section', array( 'title' => 'Portada: Pilares de Confianza', 'priority' => 33 ) );
    $default_pillars = array(
        1 => array( 'icon' => 'inventory_2', 'title' => 'Empaque 100% Discreto', 'desc' => 'Cajas y sobres lisos sin logos ni menciones al rubro. Absoluta reserva.' ),
        2 => array( 'icon' => 'verified_user', 'title' => 'Privacidad en tu Resumen', 'desc' => 'Pagá con tarjetas o transferencias. Razón social neutra en tu estado de cuenta.' ),
        3 => array( 'icon' => 'percent', 'title' => 'Hasta [best_pct]% OFF', 'desc' => 'Ahorrá abonando mediante transferencia bancaria o en efectivo.' ),
        4 => array( 'icon' => 'chat', 'title' => 'Asesoramiento Íntimo', 'desc' => 'Atención y dudas frecuentes vía WhatsApp con total confidencialidad.' ),
    );
    foreach ( $default_pillars as $i => $p ) {
        $wp_customize->add_setting( "sw_trust_pilar{$i}_icon", array( 'default' => $p['icon'], 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( "sw_trust_pilar{$i}_icon", array( 'label' => "Pilar {$i}: Ícono (Material Symbol)", 'section' => 'sw_trust_section', 'type' => 'text' ) );
        $wp_customize->add_setting( "sw_trust_pilar{$i}_title", array( 'default' => $p['title'], 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( "sw_trust_pilar{$i}_title", array( 'label' => "Pilar {$i}: Título", 'section' => 'sw_trust_section', 'type' => 'text' ) );
        $wp_customize->add_setting( "sw_trust_pilar{$i}_desc", array( 'default' => $p['desc'], 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_textarea_field' ) );
        $wp_customize->add_control( "sw_trust_pilar{$i}_desc", array( 'label' => "Pilar {$i}: Descripción", 'section' => 'sw_trust_section', 'type' => 'textarea' ) );
    }
    $wp_customize->add_setting( 'sw_trust_pilar4_link_text', array( 'default' => 'Chatear ahora', 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'sw_trust_pilar4_link_text', array( 'label' => 'Pilar 4: Texto del Enlace', 'section' => 'sw_trust_section', 'type' => 'text' ) );

    // --- SECCIÓN FAQ ---
    $wp_customize->add_section( 'sw_faq_section', array( 'title' => 'Portada: Preguntas Frecuentes', 'priority' => 34 ) );
    $default_faqs = array(
        1 => array(
            'q' => '¿Cómo vienen embalados los paquetes? ¿Se nota qué hay adentro?',
            'a' => 'La discreción es nuestra máxima prioridad. Todos los pedidos se despachan en cajas o sobres lisos, totalmente sellados y sin ningún tipo de logo, inscripción ni mención de Sexshop o Atrevidas. El remitente es una persona o razón social genérica, de modo que nadie sabrá el contenido del paquete.',
        ),
        2 => array(
            'q' => '¿Qué nombre aparece en el resumen de mi tarjeta o banco?',
            'a' => 'Tu privacidad financiera está protegida. En el resumen de tu tarjeta de crédito, débito o cuenta bancaria aparecerá únicamente una razón social neutra o el procesador de pagos utilizado (por ejemplo, Mercado Pago o Gateway de Pagos), sin ninguna referencia al rubro de productos íntimos.',
        ),
        3 => array(
            'q' => '¿Cómo sé cuál es mi talle de lencería y cuál es la política de cambios?',
            'a' => 'En la ficha de cada conjunto encontrás una guía de medidas detallada. Por estrictas normas de higiene y salud pública, las prendas de lencería y bombachas no admiten cambio una vez abiertas. En caso de juguetes o accesorios electrónicos, cuentan con garantía directa ante fallas de fábrica dentro del período establecido.',
        ),
        4 => array(
            'q' => '¿Cuáles son los tiempos de entrega y métodos de envío?',
            'a' => 'Realizamos envíos a todo el país mediante correo privado o encomienda con seguimiento online. Además, podés elegir retirar en sucursal del correo para mayor reserva si preferís no recibirlo en tu domicilio. Los despachos se procesan en 24 a 48 hs hábiles desde la confirmación de la compra.',
        ),
    );
    foreach ( $default_faqs as $i => $faq ) {
        $wp_customize->add_setting( "sw_faq_{$i}_q", array( 'default' => $faq['q'], 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( "sw_faq_{$i}_q", array( 'label' => "Pregunta {$i}", 'section' => 'sw_faq_section', 'type' => 'text' ) );
        $wp_customize->add_setting( "sw_faq_{$i}_a", array( 'default' => $faq['a'], 'transport' => 'refresh', 'sanitize_callback' => 'wp_kses_post' ) );
        $wp_customize->add_control( "sw_faq_{$i}_a", array( 'label' => "Respuesta {$i}", 'section' => 'sw_faq_section', 'type' => 'textarea' ) );
    }
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
    <div class="bg-surface-container-low shadow-sm rounded-2xl">
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

/**
 * Obtener la URL de WhatsApp de Atrevidas con número y mensaje de discreción normalizados.
 */
function atrevidas_get_whatsapp_url() {
    $custom_number = sw_child_get_mod( 'sw_whatsapp_number', '', array( 'atrevidas_whatsapp_number' ) );
    $number = ! empty( $custom_number ) ? preg_replace( '/\D/', '', $custom_number ) : '';

    if ( empty( $number ) && function_exists( 'gs_get_store_whatsapp_number' ) ) {
        $number = gs_get_store_whatsapp_number();
    }

    // Normalización para Argentina
    if ( strlen( $number ) === 10 ) {
        $number = '549' . $number;
    } elseif ( strlen( $number ) === 11 && strpos( $number, '0' ) === 0 ) {
        $number = '549' . substr( $number, 1 );
    } elseif ( strlen( $number ) === 12 && strpos( $number, '54' ) === 0 && strpos( $number, '549' ) !== 0 ) {
        $number = '549' . substr( $number, 2 );
    }

    $raw_msg = sw_child_get_mod( 'sw_whatsapp_msg', 'Hola Atrevidas! Quiero hacer una consulta con total discreción.', array( 'atrevidas_whatsapp_msg' ) );
    $encoded_msg = rawurlencode( $raw_msg );

    if ( empty( $number ) ) {
        return 'https://wa.me/' . ( $encoded_msg ? '?text=' . $encoded_msg : '' );
    }

    return 'https://wa.me/' . $number . ( $encoded_msg ? '?text=' . $encoded_msg : '' );
}

/**
 * Filtro para sobreescribir la URL de WhatsApp en el botón flotante del footer del Core
 */
add_filter( 'gs_store_whatsapp_url', function( $url, $raw_number ) {
    return atrevidas_get_whatsapp_url();
}, 10, 2 );

/**
 * Filtro pre_option para que cualquier consulta de la opción use el número de Atrevidas si está seteado
 */
add_filter( 'pre_option_grow_socks_whatsapp_number', function( $pre ) {
    $custom = sw_child_get_mod( 'sw_whatsapp_number', '', array( 'atrevidas_whatsapp_number' ) );
    return ! empty( $custom ) ? $custom : $pre;
} );

