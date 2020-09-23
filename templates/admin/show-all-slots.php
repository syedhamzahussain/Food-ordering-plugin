<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$all_intervals = array(
	'15'  => '15min',
	'30'  => '30min',
	'45'  => '45min',
	'60'  => '1hr',
	'120' => '2hrs',
	'180' => '3hrs',
);

$intervals    = get_option( 'wc_food_ordering_plugin_time_interval', true );
$total_slots  = get_option( 'wfop_total_slots', true );
$pieces       = get_option( 'wc_food_ordering_plugin_no_of_pieces', true );
$affected_cat = get_option( 'wc_food_ordering_plugin_add_slots_to_cat', null );

?>
<table class="table widefat">
			<thead>
				<tr>
					<th><b>Interval</b></th>
					<th><b>Total Slots</b></th>
					<th><b>Pieces/Slot</sb></th>
					<th><b>Products Affected</sb></th>
				</tr>
			</thead>
			<tbody>
					<tr>
						<td><?php echo $all_intervals[ $intervals ]; ?></td>
						<td><?php echo count( $total_slots ); ?></td>
						<td><?php echo $pieces; ?></td>
						<td>
						<?php
						foreach ( $affected_cat as $key => $value ) {
							echo get_term_by( 'id', $value, 'product_cat' )->name . ' -';
						}
						?>
						</td>
					</tr>
			</tbody>
		</table>
