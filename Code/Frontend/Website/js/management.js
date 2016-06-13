$(document).ready(function() {

    $('form').submit(function(e) {
		e.preventDefault();
		var action;
		if($('#action-buy').is(':checked')) action = "buy";
		else action = "sell";
		
		//alert($("#symbol option:selected").text());
		//alert($('#action-buy').is(':checked'));
		//alert($('#amount').val())
		//alert($('p.session_name').text());
		
		$.ajax({
            type: 'GET',
            url: 'backend/usr_interact.php',
            data: {
				'action': action,
                'usr': $('p.session_name').text(),
                'symbol': $('#symbol option:selected').text(),
				'amount': $('#amount').val()
            },
            success: function(data)
            {
                if (data == 'ok') {
                    alert("Done :)");
					window.location.reload();
                }
                else {
                    alert("Operation failed :(");
                }
            }
			
        });       
        
    });

});