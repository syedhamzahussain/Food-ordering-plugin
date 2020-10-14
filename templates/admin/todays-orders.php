<?php

$args = array(
    'date_created' => date('Y-m-d'),
);

$orders = wc_get_orders( $args );
$all_valid_order = array();
		
foreach ($orders as $key => $value) {
	foreach ( $value->get_items() as $item_id => $item ) {

		$date = $item->get_meta( 'date', true );
		$time = $item->get_meta( 'time', true );

		if (!empty($date) && !empty($time)) {
			array_push($all_valid_order,array('slot' => $time,'order' => $value->get_id(),'name' => $value->get_billing_first_name().' '.$value->get_billing_last_name(),'product' => $item->get_name(),'quantity' => $item->get_quantity() ));
		}
		else{
			continue;
		}
	}
}

if($all_valid_order){
	$total_slots  = get_option( 'wfop_total_slots', true );
	asort($all_valid_order);
	foreach ($total_slots as $key => $time) {
	
	foreach ($all_valid_order as $result_array) {
		foreach ($result_array as $key => $value) {
			if($time == $value->slot){
				echo $value;
			}
			
		}
	}

}

}



?>