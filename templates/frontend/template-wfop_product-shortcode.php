<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$product_id    = $_GET['product_id'];
$time          = $_GET['time'];
$date          = date( 'Y' ) . '-' . $_GET['date'];
$pieces_global = get_option( 'wc_food_ordering_plugin_no_of_pieces', true );

$product = wc_get_product( $product_id );
?>
<div id="wfop_product_wrapper_div">
	<div class="img_single_wfop_product">
		<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' ); ?>
		<img src="<?php echo $image[0]; ?>">
		
	</div>
	<div class="wfop_single_pro_title_n_price">
		<span class="wfop_single_title_p"><b><?php echo $product->get_name(); ?></b></span>
		
	</div>
	<div class="wfop_single_pro_excerpt">
		<p><?php echo get_the_excerpt( $product_id ); ?></p>
	</div>
	<div>
		<input type="number" min="1" max="<?php echo $pieces_global; ?>" value='1' name="wfop_qty" id="wfop_qty"><span><?php echo __( $pieces_global . ' Available' ); ?></span><span class="wfop_single_price_p"><b><?php echo wc_price( $product->get_price() ); ?></b></span>
	</div>
	<br>
	<div>
		<button type="button" id='btn_wfop_sinlge_cart' data-id='<?php echo $product_id; ?>' data-date='<?php echo $date; ?>' data-time='<?php echo $time; ?>'>Add To Cart</button>	
	</div>
</div>
