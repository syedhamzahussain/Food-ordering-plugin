<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<p>
				<select name="wfop_product" id="wfop_product">
					<option value="">Select Product</option>
					<?php foreach ( $all_products as $key => $value ) { ?>
					<option value="<?php echo $value->id; ?>"><?php echo 'ID ' . $value->id . '-' . $value->name; ?></option>
					<?php } ?>
				</select>

				<select name="wfop_adding_slot" id="wfop_adding_slot">
					<option value="">Select Slot</option>
					<?php foreach ( $temp_slot as $key => $value ) { ?>
					<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
					<?php } ?>
				</select>
				<input placeholder="Number Of available Stock" type="number" name="wfop_qty" id="wfop_qty" min='1'>
				<button type="button" class="button btn btn-primary" id="add_new_slot_to_product_btn">Add</button>
			</p>
			<hr>
