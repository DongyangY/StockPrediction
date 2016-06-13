$(document).ready(function() {

    $('a#logoff').click(function(e) {
		e.preventDefault();
		$.ajax({
            type: "GET",
            url: 'backend/ajaxFollower.php',
            data: {
				'action': 'logoff'
            },
            success: function(data)
            {
				window.location.replace('/~dyyao/stock');
            }
			
        });
       

    });
	

});