$(document).ready(function() {
    $('#btn_login').click(function() {


        var user = $('#user').val();
        var pass = $('#pass').val();
        if ($('#user').val() === '' || $('#pass').val() === '') {
            //$('input[type="text"]').css({
            //    "background-color": "red",
            //    "border": "1px solid yellow"
            //});
            $('#error').html("Username dan Password harus diisi").fadeIn(500).delay(2500).fadeOut(500);
        }
        else {
            $.post('controller/cont.login.php', $('#frm_login').serialize(), function(data) {
                if (data === 'correct') {
                    window.location = 'main.php';
                } else {
                    $('#error').html(data).fadeIn(500).delay(5000).fadeOut(500);
                }
            });
        }

        //$.post('loginC.php',$('#frm_login').serialize(),function(data){
        //$('#error').html(data).fadeIn(500).delay(5000).fadeOut(500);

        return false;
    });

    $('#btn_reset').click(function() {
        $('#error').html("");
    });
});
