jQuery( document ).ready(
	function ($) {

		url = wfop_ajax.ajaxurl;

		$( document ).on(
			"click",
			".wfop_indi_pro_url",
			function(event){
				event.preventDefault();
				var pro_url          = $( this ).attr( 'href' );
				$active_date         = $( '#wfop_calendar' ).find( '.wfop_date.active' ).attr( 'data-date' );
				new_url              = pro_url + $active_date;
				window.location.href = new_url;

			}
		);

		$( document ).on(
			"click",
			"#btn_wfop_sinlge_cart",
			function(event){
				var quantity = $( '#wfop_qty' ).val();
				var id       = $( this ).attr( 'data-id' );
				var date     = $( this ).attr( 'data-date' );
				var time     = $( this ).attr( 'data-time' );

				jQuery.ajax(
					{
						url: url,
						type: "post",
						data: {action: "wfop_add_to_cart", product_id: id, quantity: quantity,date: date,time: time},
						success: function (response) {
							window.location.href;
						}
								}
				);
			}
		);

	}
);
