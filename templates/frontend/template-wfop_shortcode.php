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
			?>
				<button type="button"><?php echo $day; ?></button>
			</span>
		<?php } ?>
		<span class="next_week"><button data-want='next' type="button" id="week_btn">Next 7 Days</button></span>
	</div>
		<?php
		foreach ( $total_slots as $key => $s_time ) {

			require WFOP_TEMP_DIR . '/frontend/template-wfop_indiv_pro_row.php';
		}
		?>
</div>

