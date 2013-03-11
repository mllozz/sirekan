$(document).ready(function(){
    
    $('#btn_ubah').click(function(){
        if($('#password').val()==='' || $('#password_baru').val()==='' || $('#password_ulangi').val()===''){
            $('input[type="text"]').css({
                "border": "1px solid red"
            });
            $('span#error').html('Semua harus diisi').fadeIn(500).delay(2500).fadeOut(500);
        }
        return false;
    });
    
});


