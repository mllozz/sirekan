$(document).ready(function(){
    $('#frm_login').submit(function(){
        $.post('loginC.php',$('#frm_login').serialize(),function(data){
            $('#error').html(data).fadeIn(500).delay(5000).fadeOut(500);
        });
        return false;
    });
});