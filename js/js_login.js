$(document).ready(function(){
    $('#btn_login').click(function(){

    		
    		var user= $('#user').val();
    		var pass= $('#pass').val();

    		if( $('#user').val()=='' || $('#pass').val()=='') {
    			$('input[type="text"]').css({
    				"background-color": "red",
    				"border": "1px solid yellow"
    			}).after("Required");
    			$('input[type="password"]').css({
    				"background-color": "red",
    				"border": "1px solid yellow"
    			}).after("Required");
    			$('#error').html("Username dan Password harus diisi").fadeIn(500).delay(2500).fadeOut(500);
    		}


    		
        	//$.post('loginC.php',$('#frm_login').serialize(),function(data){
            //$('#error').html(data).fadeIn(500).delay(5000).fadeOut(500);
       
        return false;
    });

    $('#btn_reset').click(function(){
    	$('#error').html("");
    });
});
