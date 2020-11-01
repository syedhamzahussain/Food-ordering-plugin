<?php

$args = array();

$orders          = wc_get_orders( $args );
$all_valid_order = array();

foreach ( $orders as $key => $value ) {
	foreach ( $value->get_items() as $item_id => $item ) {

		$date = $item->get_meta( 'date', true );
		$time = $item->get_meta( 'time', true );

		if ( ( ! empty( $date ) && ! empty( $time ) ) && $date == date( 'Y-m-d' ) ) {

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

	$sorted_orders_array = wfop_get_sorted_results( $all_valid_order, $total_slots );
	echo '<pre>';
	print_r( $sorted_orders_array );
	echo '</pre>';
	foreach ( $total_slots as $key => $time ) {
		?>
	<br>
	<div class="slot_row_back">
		<span class="wfop_back_slot"><?php echo $time; ?></span>
		<?php

		foreach ( $sorted_orders_array[ $time ] as $result_array ) {
			?>
		<div class="single_order_row">
			<p style="float: right;"><b><button type="button" class='wfop_delete' data-id='<?php echo $result_array['order']; ?>'>X</button></b></p>
			<br>
			<b>
		</div>
		<?php } ?>
	</div>
		<?php
	}
}

?>
</div>

