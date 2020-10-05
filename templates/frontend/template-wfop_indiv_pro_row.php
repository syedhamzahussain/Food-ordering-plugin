<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div class="wfop_row">
		<p><span class="wfop_time_title"><b><?php echo $s_time; ?></b></span></p>
		<?php foreach ( $all_eligible_products as $key => $value ) { ?>
		<a class='wfop_indi_pro_url' href="<?php echo $Single_Food_Product_page->guid . '?product_id=' . $value->id . '&time=' . $s_time . '&date='; ?>">
			<div class="wfop_product">
					<div class="img_div_wfop_product">
						<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $value->id ), 'single-post-thumbnail' ); ?>
						<img src="<?php echo $image[0]; ?>">
						<span><?php echo $pieces; ?></span>
					</div>
					<div class="wfop_indi_pro_title_n_price">
						<span class="wfop_title_p"><b><?php echo $value->get_name(); ?></b></span>
						<span class="wfop_price_p"><b><?php echo wc_price( $value->get_price() ); ?></b></span>
					</div>
					<div class="wfop_pro_excerpt">
						<p><?php echo substr( get_the_excerpt( $value->id ), 0, 70 ); ?></p>
					</div>
			</div>
		</a>
	<?php } ?>
</div>
<br>
