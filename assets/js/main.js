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
				back         = $( "#btn_wfop_sinlge_cart" ).attr( 'data-ref' );

				jQuery.ajax(
					{
						url: url,
						type: "post",
						data: {action: "wfop_add_to_cart", product_id: id, quantity: quantity,date: date,time: time},
						success: function (response) {
							location.href = back;
						}
					}
				);
			}
		);

		$( document ).on(
			"click",
			".add_and_go_checkout",
			function(event){
				var quantity = $( '#wfop_qty' ).val();
				var id       = $( "#btn_wfop_sinlge_cart" ).attr( 'data-id' );
				var date     = $( "#btn_wfop_sinlge_cart" ).attr( 'data-date' );
				var time     = $( "#btn_wfop_sinlge_cart" ).attr( 'data-time' );

				checkout = $( this ).attr( 'data-url' );

				jQuery.ajax(
					{
						url: url,
						type: "post",
						data: {action: "wfop_add_to_cart", product_id: id, quantity: quantity,date: date,time: time},
						success: function (response) {
							location.href = checkout;
						}
					}
				);
			}
		);

		$( document ).on(
			"click",
			".wfop_date",
			function(event){
				$( '.wfop_date' ).removeClass( 'active' );
				$( this ).addClass( 'active' );
				var date = $( this ).text();
				not_open = false;
				if ( $( ".wfop_not_open" )[0] ) {
					not_open = true;
				}

				if ( typeof $( this ).attr( 'disabled' ) == 'undefined') {
					return;
				} else {
					$( ".wfop_not_open" ).remove();
					$( "#wfop_shop_wrapper" ).append( '<span id="wait"><h3>Please wait .....</h3></span>' );
				}

				jQuery.ajax(
					{
						url: url,
						type: "post",
						data: {action: "get_pieces_by_date", date: date,not_open:not_open},
						success: function (response) {
							if (not_open == true) {
								$( '#wait' ).remove();
								$( "#wfop_shop_wrapper" ).append( response );
								$( ".wfop_date" ).click();
							} else {
								obj = JSON.parse( response );

								$( obj ).each(
									function( index, value ) {

										$( '.pieces_' + value.id + '_' + value.slot.replace( ":", "-" ) ).text( value.pieces );

									}
								);
							}
						}
					}
				);

			}
		);

		$( document ).on(
			"click",
			"#week_btn",
			function(event){
				want = $( this ).attr( 'data-want' );
				if (want == 'next') {
					date = $( ".wfop_date" ).last().text().trim();
				}
				if (want == 'previous') {
					date = $( ".wfop_date" ).first().text().trim();
				}

				$( '#wfop_calendar' ).empty();

				jQuery.ajax(
					{
						url: url,
						type: "post",
						data: {action: "change_calendar",want:want,date:date},
						success: function (response) {
							$( '#wfop_calendar' ).html( response );
							$( '.wfop_date.active' ).click();
						}
					}
				);

			}
		);

	}
);
