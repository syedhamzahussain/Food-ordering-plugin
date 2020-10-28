<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div id="wfop_shop_wrapper">
	<div id="wfop_calendar">
		<span class='previous_week'><button disabled data-want='previous' type='button' id='week_btn'>Previous 7 Days</button></span>
		<?php
		foreach ( $seven_days as $key => $day ) {
			if ( $key == 0 ) {
				$today = $day;
				echo "<span class='wfop_date active' style='padding-left:8px;' data-date='" . $day . "'>";
			} else {
				echo "<span class='wfop_date' data-date='" . $day . "'>";
			}
			$d = date( 'Y-' ) .$day;
			$day_name  = date('D', strtotime($d) );

			if ( !in_array( (date('l', strtotime($d) ) ), $open_days ) ) {
				echo "<button disabled type='button'>".$day_name."<br>".$day."</button>";
			}
			else{
				echo "<button type='button'>".$day_name."<br>".$day."</button>";
			}
			?>
				
			</span>
		<?php } ?>
		<span class="next_week"><button data-want='next' type="button" id="week_btn">Next 7 Days</button></span>
	</div>
		<?php
		if ( in_array( (date( 'l', strtotime($seven_days[0]) ) ), $open_days ) ) {
			echo "<p style='float:left;'><span class='wfop_not_open'>We're sorry, we are not open this day</span></p>";
		}
		else{
			foreach ( $total_slots as $key => $s_time ) {

				require WFOP_TEMP_DIR . '/frontend/template-wfop_indiv_pro_row.php';
			}
		}
		?>
</div>

