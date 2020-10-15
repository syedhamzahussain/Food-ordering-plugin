<?php

$args = array(
	'date_created' => date( 'Y-m-d' ),
);

$orders          = wc_get_orders( $args );
$all_valid_order = array();

foreach ( $orders as $key => $value ) {
	foreach ( $value->get_items() as $item_id => $item ) {

		$date = $item->get_meta( 'date', true );
		$time = $item->get_meta( 'time', true );

		if ( ! empty( $date ) && ! empty( $time ) ) {

			//$product = wc_get_product( $item->get_id() );
			echo $item->get_product_id();
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->get_product_id() ), 'single-post-thumbnail' );


			array_push(
				$all_valid_order,
				array(
					'slot'      => $time,
					'product'   => $item->get_name(),
					'quantity'  => $item->get_quantity(),
					'name'      => $value->get_billing_first_name() . ' ' . $value->get_billing_last_name(),
					'image_url' => $image[0],
					'order'     => $value->get_id(),
				)
			);
		} else {
			continue;
		}
	}
}
?>
<div id="todays_orders_backend">
	<h1 style="text-align: center;">Today's Order's</h1>
<?php
if ( $all_valid_order ) {

	$total_slots = get_option( 'wfop_total_slots', true );
	asort( $all_valid_order );
	foreach ( $total_slots as $key => $time ) {
		?>
	<br>
	<div class="slot_row_back">
		
	<span class="wfop_back_slot"><?php echo $time; ?></span>
		<?php

		foreach ( $all_valid_order as $result_array ) {

			if ( $result_array['slot'] != $time ) {
				continue;
			}

			?>
		<div class="single_order_row">
			<b>
			<?php
			foreach ( $result_array as $key => $value ) {

				if ( $key == 'product' ) {
					?>

			<p><span class="wfop_back_name"><?php echo $value; ?></span>
					<?php
				} elseif ( $key == 'quantity' ) {
					?>
			<span class="wfop_back_quantity"><?php echo $value; ?></span></p>
					<?php
				} elseif ( $key == 'name' ) {
					?>
				<p><span class="wfop_back_customer"><?php echo $value; ?></span>
					<?php
				} elseif ( $key == 'image_url' ) {
					?>
			<span class="wfop_back_image"><img src="<?php echo $value; ?>"></span></p>
					<?php
				} elseif ( $key == 'order' ) {
					?>
				<span class="wfop_back_order">Order# <?php echo $value; ?></span>
					<?php
				}
			}
			?>
		</b>
	</div>
			<?php
		}
		?>
	</div>
	<br>
		<?php
	}
}

?>
</div>
