$(document).ready(function(){
    
    $('#btn_ubah').click(function(){
        if($('#password').val()==='' || $('#password_baru').val()==='' || $('#password_ulangi').val()===''){
            $('input[type="password"]').next('span').fadeIn(500).html('<img src="img/wrong.png" alt="loader" />').delay(2500).fadeOut(500);
            $('span#error').html('Semua harus diisi').fadeIn(500).delay(2500).fadeOut(500);
        } else if($('#password_baru').val().length<8){
            $('span#password_baru').fadeIn(500).html('<img src="img/wrong.png" alt="loader" />');
            $('span#error').html('Password minimal 8 character').fadeIn(500).delay(2500).fadeOut(500);
        }else if($('#password_baru').val() !== $('#password_ulangi').val()) {
            $('span#password_ulangi').fadeIn(500).html('<img src="img/wrong.png" alt="loader" />');
            $('span#error').html('Konfirmasi Password Salah').fadeIn(500).delay(2500).fadeOut(500);
        } else {
            $.post($('#frm_ubah').attr('action'),$('#frm_ubah').serialize(),function(data){
                $.each(data,function() {
                    if(data.msg==='ok') {
                        $('span#error').html(data.info).fadeIn(500).delay(2500).fadeOut(500);
                    } else {
                        $('span#password').fadeIn(500).html('<img src="img/wrong.png" alt="loader" />');
                        $('span#error').html(data.info).fadeIn(500).delay(2500).fadeOut(500);
                    }
                });
            },'json');
        }
        return false;
    });
    
});


