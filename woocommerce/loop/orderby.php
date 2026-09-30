<?php
/**
 * Show options for ordering (Grow Socks Hybrid Minimalist Icon)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form class="woocommerce-ordering relative flex items-center justify-center m-0 p-0" method="get">
    <!-- Icon Button (Mobile & Desktop Unified) -->
    <div class="flex items-center justify-center p-space-xs text-secondary hover:text-primary transition-colors cursor-pointer w-7 h-7 sm:w-8 sm:h-8" title="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
        <span class="material-symbols-outlined text-[18px]">sort</span>
    </div>

	<select name="orderby" class="orderby appearance-none absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10 m-0 p-0" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
		<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
    
	<input type="hidden" name="paged" value="1" />
	<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
</form>
