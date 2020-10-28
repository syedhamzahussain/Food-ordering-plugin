<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


$intervals    = get_option( 'wc_food_ordering_plugin_time_interval', true );
$total_slots  = get_option( 'wfop_total_slots', true );
$pieces       = get_option( 'wc_food_ordering_plugin_no_of_pieces', true );
$affected_cat = get_option( 'wc_food_ordering_plugin_add_slots_to_cat', null );
$open_days = get_option('wc_food_ordering_plugin_open_days',true);

?>
<table class="table widefat">
			<thead>
				<tr>
					<th><b>Interval</b></th>
					<th><b>Total Slots</b></th>
					<th><b>Pieces/Slot</sb></th>
					<th><b>Products Affected</sb></th>
					<th><b>Open Days</sb></th>
				</tr>
			</thead>
			<tbody>
				<?php
				if ( ! empty( $intervals ) && ! empty( $total_slots ) && ! empty( $pieces ) && ! empty( $affected_cat ) ) {
					?>
					<tr>
						<td><?php echo $this->all_intervals[ $intervals ]; ?></td>
						<td><?php echo count( $total_slots ); ?></td>
						<td><?php echo $pieces; ?></td>
						<td>
						<?php

						foreach ( $affected_cat as $key => $value ) {

							if ( 'all' == $value ) {
								echo __( 'All' );
							} else {
								echo get_term_by( 'id', $value, 'product_cat' )->name . ' -';
							}
						}

						?>
						</td>
						<td>
							<?php
							foreach ( $open_days as $key => $value ) {

								echo $value.' -';
							}
							?>	
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
