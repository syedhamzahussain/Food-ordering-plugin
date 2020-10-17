<?php

function total_slots( $StartTime, $EndTime, $Duration = '60' ) {

			$ReturnArray = array();// Define output
			$StartTime   = strtotime( $StartTime ); // Get Timestamp
			$EndTime     = strtotime( $EndTime ); // Get Timestamp

			$AddMins = $Duration * 60;

	while ( $StartTime <= $EndTime ) {
		$ReturnArray[] = date( 'G:i', $StartTime );
		$StartTime    += $AddMins; // Endtime check
	}
			return $ReturnArray;

}

function get_dates_for_calendar() {

			$dates[0] = date( 'm-d' );
	for ( $i = 1; $i <= 7; $i++ ) {
		$dates[ $i ] = date( 'm-d', strtotime( '+' . $i . ' days' ) );
	}

			return $dates;

}

function get_all_eligible_products() {

			$affected_cat = get_option( 'wc_food_ordering_plugin_add_slots_to_cat', null );

			$all_affected_cat_names = array();

	foreach ( $affected_cat as $key => $value ) {
		array_push( $all_affected_cat_names, get_term_by( 'id', $value, 'product_cat' )->name );
	}

	if ( 'all' == $affected_cat[0] ) {
		$args['posts_per_page'] = -1;
	} else {
		$args['category'] = $all_affected_cat_names;
	}

			return $all_products = wc_get_products( $args );

}

function get_products_details(){
	$total_slots = get_option( 'wfop_total_slots', true );
	$all_products = get_all_eligible_products();
	$new_array =array();

	foreach ($all_products as $key => $value) {

		$pieces = $value->get_meta( 'wfop_ind_piece', true );

		if(empty($pieces)){
			$pieces = get_option( 'wc_food_ordering_plugin_no_of_pieces', true );
		}

		foreach ($total_slots as $t_key => $time) {
			array_push($new_array, array('id' => $value->get_id(),'pieces' => $pieces,'slot' => $time ));
		}
	}
	
	return $new_array;
}