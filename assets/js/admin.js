jQuery( document ).ready(
	function ($) {

		url = wfop_ajax.ajaxurl;
		

		$( document ).on(
			"click",
			".wfop_delete",
			function(event){
				var order_id          = $( this ).attr( 'data-id' );

				var done = confirm('Are you sure you want to delete order#'+ order_id +' ?');
				if(done == true){
					jQuery.ajax(
						{
							url: url,
							type: "post",
							data: {action: "wfop_delete_order", order_id: order_id,},
							success: function (response) {
								location.reload();
							}
						}
					);
				}

			}
		);

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
