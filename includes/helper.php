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


