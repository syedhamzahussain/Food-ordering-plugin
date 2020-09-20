<?php
/**
 *
 * Contain frontend view of attachment for admin
 *
 * @package Wholesale Product Page Customizer For WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$heading = $this->cwppe_get_title( $this->visible_type_attachment );
$icon    = $this->cwppe_get_file_icon( $this->visible_type_attachment );
?>
<br>
<div class="product-attachment-div">
	<h3><?php echo esc_html_e( $heading, 'codup_wc_product_page_enhancement' ); ?></h3>
	<img src="<?php echo esc_html( $icon ); ?>" alt="file icon">
	<br>
	<span class="download-att-file"><?php echo wp_kses_post( $file_array ); ?></span>
</div>	
<?php
