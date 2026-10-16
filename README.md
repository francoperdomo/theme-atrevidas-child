# Atrevidas Child Theme (`theme-atrevidas-child`)

> **Skin oficial de producción para Atrevidas (Lencería, Corsetería y Bienestar Íntimo) montado sobre el Core Engine `theme-simple-woo`.**

---

## 1. Visión y Propósito

Este tema hijo (*Child Theme*) desacopla la identidad de marca, estética visual, discreción de compra y portada editorial de **Atrevidas** respecto a la lógica transaccional y optimizaciones de rendimiento provistas por el tema padre (`theme-simple-woo`).

Hereda del Core:
- Compatibilidad nativa con WooCommerce y HPOS (High-Performance Order Storage).
- Filtros asíncronos y buscador en vivo (Live AJAX Search).
- Suite de checkout argentino (DNI con IMask, normalización telefónica E.164, etc.).
- Motor de compilación Tailwind CSS y sistema de tokens de diseño.
- Helper central y control en el Personalizador para chips de categorías dinámicos (`gs_get_home_category_chips()`).

---

## 2. Estructura del Child Theme

```plaintext
theme-atrevidas-child/
├── template-parts/
│   └── home/
│       ├── hero.php            # Banner panorámico responsive con soporte sw_* y clases neutrales
│       ├── dual-portals.php    # Banners de Portales Duales configurables (Lencería vs Juguetes & Bienestar)
│       ├── featured-products.php# Grilla de productos más deseados con transient cache
│       ├── spotlight.php       # Destacado editorial de Cultura Atrevida con 3 viñetas dinámicas
│       ├── trust-pillars.php   # 4 Pilares de confianza (Empaque Discreto, Pagos Privados, Descuentos, Asesoramiento)
│       └── faq-accordion.php   # Acordeón de dudas frecuentes dinámico sobre privacidad y envíos (<details> nativo)
├── front-page.php              # Orquestador modular limpio de la portada de Atrevidas
├── functions.php               # Encolado de tokens, personalizador sw_*, migración y hooks de WooCommerce
├── tokens.css                  # Overrides de variables CSS (paleta fucsia, header tokens, geometría y radios suaves)
├── style.css                   # Declaración del Child Theme (Template: theme-simple-woo)
└── README.md                   # Esta documentación
```
*Nota:* `header.php`, `index.php` y `category-chips.php` se eliminaron del Child Theme para ser gestionados directamente por el Core Engine `theme-simple-woo`, eliminando 140 líneas de CSS duplicado y habilitando herencia transparente de mejoras de rendimiento y accesibilidad.

---

## 3. Opciones del Personalizador de WordPress

Desde el panel de administración (**Apariencia > Personalizar**), el tema expone paneles unificados bajo el estándar universal `sw_*`:

### 3.1. Estandarización Universal (`sw_*`) y Migración Transparente
- Todas las opciones se gestionan con el prefijo neutral `sw_*` y se leen mediante `sw_child_get_mod( $sw_key, $default, $legacy_keys )`.
- En el evento `init`, la función `atrevidas_migrate_legacy_mods_to_sw()` migra automáticamente en un solo paso cualquier valor previo guardado bajo `atrevidas_*` en la base de datos de producción, garantizando **cero pérdida de datos**.

### 3.2. Defaults Comerciales Inyectados (`simple_woo_default_options`)
Mediante el filtro `atrevidas_child_default_options` conectado a `simple_woo_default_options`, Atrevidas inyecta sus textos y configuraciones propias en el Core:
- **Mega Menú:** `enable_mega_menu = 'yes'`.
- **Anuncio Superior:** `🔥 10% OFF Efectivo (Concepción del Uruguay) | 5% OFF Transferencia | Envíos 100% Discretos a todo el país 🚀`.
- **Retiro y Envíos:** `Retiro sin cargo`, `Envío Rápido y Discreto` (24 a 48 hs hábiles), `Envíos 100% Discretos a todo el país` (cajas lisas sin logos).
- **Insignias y Catálogo:** `gs_show_low_stock_badge = 'no'`, `gs_new_arrival_days = '30'`, `gs_archive_subtitle = 'Colección Exclusiva'`.

### 3.3. Controles del Personalizador Disponibles
1. **Portada: Hero Principal (Banner) (`sw_hero_section`):** Imagen desktop panorámica (`sw_hero_image_desktop`), imagen móvil vertical (`sw_hero_image`), subtítulo, título, descripción y botones 1 y 2 con URLs (si no hay imágenes configuradas, se oculta automáticamente).
2. **Portada: Portales Duales (`sw_portals_section`):** Imágenes, tags, títulos, descripciones, botones y URLs para Portal 1 (Lencería) y Portal 2 (Juguetes).
3. **Atrevidas: WhatsApp y Atención (`sw_whatsapp_section`):** Número de WhatsApp oficial y mensaje predeterminado con discreción.
4. **Portada: Banner Spotlight (`sw_spotlight_section`):** Imagen de campaña, tag superior, título, descripción, 3 viñetas con íconos Material Symbols configurables y botón con URL.
5. **Portada: Pilares de Confianza (`sw_trust_section`):** Íconos, títulos y descripciones para los 4 pilares, soporte para placeholders de descuento y enlace/texto de chat en el Pilar 4.
6. **Portada: Preguntas Frecuentes (`sw_faq_section`):** Edición completa de las 4 preguntas (`sw_faq_1..4_q`) y respuestas (`sw_faq_1..4_a`).

---

## 4. Personalizaciones de Negocio y Hooks WooCommerce (`functions.php`)

1. **Ocultamiento de SKU en PDP:**
   Filtro `wc_product_sku_enabled` desactivado para mantener la ficha de producto limpia y libre de códigos técnicos internos.
2. **Acordeón de Cuidado y Discreción en Producto (`atrevidas_custom_care_accordion`):**
   Enganchado a `gs_after_single_product_accordions`, inyecta el 4.º acordeón *"Ritual de Cuidados"* con recomendaciones sobre higiene de juguetes, cuidado de baterías, lencería fina y almacenamiento.
3. **Barra Educativa en Catálogo (`atrevidas_archive_educational_bar`):**
   Enganchado a `gs_archive_benefits_bar`, sustituye la barra genérica por la sección educativa *"La Cultura Atrevida: Cuidá tu placer y tus prendas"* (Higiene de Juguetes, Motores y Baterías, Delicadeza en Lencería).
4. **Mega Menú Nativo del Core:**
   Aprovecha el motor `.gs-mega` y `simple_woo_get_category_tree()` del Core Engine con activación por filtro, sin código duplicado en el Child Theme.
5. **Desacople de Datos de Contacto:**
   Filtros `gs_store_whatsapp_url` y `pre_option_grow_socks_whatsapp_number` para sobreescribir el número y mensaje del Core de forma transparente.

---

## 5. Tokens de Diseño y Estilos (`tokens.css`)

- **Paleta Sensual y Femenina:**
  - Primario: `--color-primary-rgb: 221 26 131;` (#dd1a83).
  - Superficie: `--color-surface-rgb: 255 255 255;` (Blanco puro).
- **Tokens de Header (Herencia sin Duplicación):**
  - `--color-header-bar-bg-rgb: 0 0 0;` (Barra superior negra).
  - `--color-header-bar-text-rgb: 255 255 255;`
  - `--color-header-icon-rgb: var(--color-on-surface-rgb);` (Íconos oscuros).
  - `--color-header-icon-hover-rgb: var(--color-primary-rgb);` (Hover fucsia).
- **Bordes y Redondeos:**
  - Píldora: `--radius-btn: 9999px;`, `--radius-badge: 9999px;`
  - Superficies: `--radius-default: 0.75rem;`, `--radius-lg: 1rem;`, `--radius-xl: 1.5rem;`
- **Geometría de Medios:**
  - Hero: `.sw-hero__media, .atr-hero__media` (`aspect-ratio: 3/4` en móvil, `height: 380px` en desktop).
  - Portales: `.sw-hero-split, .gs-hero-split` (`min-height: 400px` en móvil, `height: 480px` en desktop).

---

## 6. Despliegue a Producción

Para desplegar actualizaciones en el servidor productivo de Atrevidas:

```bash
cd /ruta-a-tu-web/wp-content/themes/theme-atrevidas-child
git pull origin main
```

