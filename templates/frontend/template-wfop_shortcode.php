<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div id="wfop_shop_wrapper">
	<div id="wfop_calendar">
		<?php
		foreach ( $seven_days as $key => $day ) {
			if ( $key == 0 ) {
				echo "<span class='wfop_date active'>";
			} else {
				echo "<span class='wfop_date'>";
			}
			?>
				<button type="button"><?php echo $day; ?></button>
			</span>
		<?php } ?>
	</div>
		<?php
		foreach ( $total_slots as $key => $s_time ) {

			require WFOP_TEMP_DIR . '/frontend/template-wfop_indiv_pro_row.php';
		}
		?>
</div>

