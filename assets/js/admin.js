jQuery( document ).ready(
	function ($) {

		$( '#wc_food_ordering_plugin_add_slots_to_cat' ).select2(
			{
				closeOnSelect: false,
				placeholder: "Select Columns",
				allowHtml: true,
				allowClear: true,
				tags: false
			}
		);

		$( '#wc_food_ordering_plugin_open_days' ).select2(
			{
				closeOnSelect: false,
				placeholder: "Select Open Days",
				allowHtml: true,
				allowClear: true,
				tags: false
			}
		);

		$( '.single_order_row' ).each(
			function() {
				if ( ! $.trim( $( this ).html() ).length ) {
					  $( this ).parent().css( 'min-height','50px' );
					  $( this ).remove();
				}
			}
		);

	}
);
