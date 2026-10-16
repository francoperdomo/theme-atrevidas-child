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
│       ├── hero.php            # Banner panorámico responsive con ocultamiento automático si no hay imagen
│       ├── category-chips.php  # Accesos rápidos a categorías dinámicas de WooCommerce vía gs_get_home_category_chips()
│       ├── dual-portals.php    # Banners de Portales Duales (Lencería vs Juguetes & Bienestar)
│       ├── featured-products.php# Grilla de productos más deseados con transient cache
│       ├── spotlight.php       # Destacado editorial de Cultura Atrevida y Bienestar Íntimo
│       ├── trust-pillars.php   # 4 Pilares de confianza (Empaque Discreto, Pagos Privados, Descuentos, Asesoramiento)
│       └── faq-accordion.php   # Acordeón de dudas frecuentes sobre privacidad y envíos (<details> nativo)
├── front-page.php              # Orquestador modular limpio de la portada de Atrevidas
├── header.php                  # Header personalizado con anuncio de retiro en Concepción del Uruguay y Mega Menú
├── functions.php               # Encolado de tokens, personalizador, filtros de privacidad y hooks de WooCommerce
├── tokens.css                  # Overrides de variables CSS (paleta fucsia/magenta, superficies y radios suaves)
├── style.css                   # Declaración del Child Theme (Template: theme-simple-woo)
└── README.md                   # Esta documentación
```

---

## 3. Opciones del Personalizador de WordPress

Desde el panel de administración (**Apariencia > Personalizar**), el tema expone paneles dedicados para gestionar imágenes, textos y llamadas a la acción en tiempo real:

### 3.1. Portada: Hero Principal (Banner) (`atrevidas_banner_section`)
- **Imagen Desktop (Panorámica):** Fotografía horizontal de alto impacto para pantallas grandes.
- **Imagen Móvil (Vertical):** Fotografía vertical optimizada para smartphones entregada mediante `<picture>`.
- **Subtítulo Superior:** Etiqueta superior (ej: *Nueva Colección · Lencería & Bienestar*).
- **Título Principal:** Titular de impacto (admite saltos de línea `<br>`).
- **Descripción:** Texto complementario del hero.
- *Nota de rendimiento:* Si no se configuran imágenes, la sección se oculta automáticamente para priorizar el catálogo.

### 3.2. Portada: Accesos Rápidos (Categorías) (`simple_woo_category_chips_section`)
- **Heredado del Core:** Permite tildar qué categorías mostrar en la barra deslizante debajo del Hero.
- **Fallback Automático:** Si no se marca ninguna, lista automáticamente todas las categorías principales con stock publicado (`hide_empty => true`) ordenadas por `menu_order`.
- **Destino del Enlace:** Enlaces canónicos directos a la categoría nativa (`get_term_link()`).

### 3.3. Portada: Portales Duales (`atrevidas_hero_section`)
- **Imagen Mitad Lencería:** Fotografía del portal de lencería y corsetería.
- **Imagen Mitad Juguetes:** Fotografía del portal de juguetes y bienestar íntimo.

### 3.4. Atrevidas: WhatsApp y Atención (`atrevidas_whatsapp_section`)
- **Número de WhatsApp Oficial:** Teléfono de atención confidencial aplicado al botón flotante y asesoramiento.
- **Mensaje Predeterminado:** Texto inicial automático al abrir el chat (ej: *"Hola Atrevidas! Quiero hacer una consulta con total discreción"*).

### 3.5. Portada: Spotlight Cultura Atrevida (`atrevidas_spotlight_section`)
- Fotografía editorial de bienestar y empoderamiento íntimo.
- Tag superior, título editorial, descripción y 3 viñetas de valores de marca.

---

## 4. Personalizaciones de Negocio y Hooks WooCommerce (`functions.php`)

1. **Ocultamiento de SKU en PDP:**
   Filtro `wc_product_sku_enabled` desactivado para mantener la ficha de producto limpia y libre de códigos técnicos internos.
2. **Acordeón de Cuidado y Discreción en Producto (`atrevidas_custom_care_accordion`):**
   Enganchado a `gs_after_single_product_accordions`, inyecta un acordeón adicional con garantía de empaque neutro sin logotipos y recomendaciones de cuidado y sanitización de productos íntimos.
3. **Barra Educativa en Catálogo (`atrevidas_archive_educational_bar`):**
   Enganchado a `gs_archive_benefits_bar`, sustituye la barra genérica por 3 pilares clave de la marca: *Envíos 100% Discretos*, *Pagos Privados* y *Asesoramiento Reservado*.
4. **Mega Menú Multinivel en Escritorio (`atrevidas_get_category_tree`):**
   En `header.php`, genera un menú de navegación horizontal para pantallas XL con desplegables automáticos de categorías y subcategorías reales de WooCommerce.
5. **Desacople de Datos de Contacto:**
   Filtros `gs_store_whatsapp_url` y `pre_option_grow_socks_whatsapp_number` para sobreescribir el número del Core sin generar dependencias cruzadas.

---

## 5. Tokens de Diseño y Estilos (`tokens.css`)

- **Paleta Sensual y Femenina:**
  - Primario: `--color-primary-rgb: 187 36 94` (Magenta / Fucsia intenso).
  - Superficies: Fondos suaves y luminosos con tinte cálido (`--color-surface-rgb: 254 247 249`).
  - Superficie contenedora: `--color-surface-container-rgb: 252 235 240`.
- **Bordes y Redondeos:**
  - Botones y chips con curvaturas suaves: `--radius-btn: 9999px` (estilo píldora).
  - Contenedores con radio suave: `--radius-default: 8px`.

---

## 6. Despliegue a Producción

Para desplegar actualizaciones en el servidor productivo de Atrevidas:

```bash
cd /ruta-a-tu-web/wp-content/themes/theme-atrevidas-child
git pull origin main
```
