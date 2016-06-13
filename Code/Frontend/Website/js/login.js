$(document).ready(function() {

    $('form').submit(function(e) {
		e.preventDefault();
		
		if($("a.signup").attr("style") == "color: #649ecf; text-decoration: underline;"){
			$.ajax({
            type: "POST",
            url: 'backend/ajaxFollower.php',
            data: {
				'action': 'login',
                'usr': $("#name").val(),
                'pwd': $("#pwd").val()
            },
            success: function(data)
            {
                if (data == 'ok') {
                    window.location.replace('/~dyyao/stock');
                }
                else {
                    alert("Your username or password is not right :(");
                }
            }
			
        	});
		}
		
		if($("a.login").attr("style") == "color: #649ecf; text-decoration: underline;"){
			$.ajax({
            type: "POST",
            url: 'backend/ajaxFollower.php',
            data: {
				'action': 'signup',
                'usr': $("#name").val(),
                'pwd': $("#pwd").val()
            },
            success: function(data)
            {
				
                if (data == 'ok') {
                    window.location.replace('/~dyyao/stock');
                }
                else {
                    alert("Sign up failed :(");
                }
            }
			
        	});
		
		}
       

    });
	
	$("a.login").click(function() {
		$("a.signup").attr("style", "color: #649ecf; text-decoration: underline;");
		$("a.login").attr("style", "");
    });
	
	$("a.signup").click(function() {
        $("a.login").attr("style", "color: #649ecf; text-decoration: underline;");
		$("a.signup").attr("style", "");
    });

});