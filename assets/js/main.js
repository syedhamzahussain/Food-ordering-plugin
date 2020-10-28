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
							location.reload();
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

				jQuery.ajax(
					{
						url: url,
						type: "post",
						data: {action: "get_pieces_by_date", date: date},
						success: function (response) {
							obj = JSON.parse( response );

							$( obj ).each(
								function( index, value ) {

									$( '.pieces_' + value.id + '_' + value.slot.replace( ":", "-" ) ).text( value.pieces );

								}
							);
						}
					}
				);

			}
		);

		$( document ).on(
			"click",
			"#week_btn",
			function(event){
				want = $( this ).attr('data-want');
				if(want == 'next'){
					date = $( ".wfop_date" ).last().text().trim();
				}
				if(want == 'previous'){
					date = $( ".wfop_date" ).first().text().trim();
				}
				
				$('#wfop_calendar').empty();

				jQuery.ajax(
					{
						url: url,
						type: "post",
						data: {action: "change_calendar",want:want,date:date},
						success: function (response) {
							$('#wfop_calendar').html(response);
							$('.wfop_date.active').click();
						}
					}
				);

			}
		);

	}
);
