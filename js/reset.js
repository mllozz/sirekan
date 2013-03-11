$(document).ready(function() {
    //input hanya angka
    $("input[type=text]").keydown(function(e) {
        var key = e.charCode || e.keyCode || 0;
        return (
                key === 8 ||
                key === 9 ||
                key === 46 ||
                (key >= 37 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
    });

    //JSON cek data
    $("input[type=text]").keyup(function() {
        var val = $(this).attr('value');
        var field = $(this).attr('name');
        $('#error').html('<img src="img/loader.gif" alt="loader" />').show();
        if (field === 'kddept' && val.length === 3) {
            $.getJSON('controller/cont.reset.php', {kddept: val, cek: true}, function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $('input#' + field).next('#kddept').fadeIn(1000).text(data.nama);
                    } else {
                        $('input#' + field).next('#kddept').fadeIn(1000).text(data.nama);
                    }
                    $('#error').html('<img src="img/loader.gif" alt="loader" />').hide();
                });
            });
        }
        if (field === 'kdunit' && val.length === 2) {
            var kddept = $('#kddept').val();
            $('#error').html('<img src="img/loader.gif" alt="loader" />').show();
            $.getJSON('controller/cont.reset.php', {kdunit: val, kddept: kddept, cek: true}, function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $('input#' + field).next('#kdunit').fadeIn(1000).text(data.nama);
                    } else {
                        $('input#' + field).next('#kdunit').fadeIn(1000).text(data.nama);
                    }
                    $('#error').html('<img src="img/loader.gif" alt="loader" />').hide();
                });
            });
        }
        if (field === 'kdsatker' && val.length === 6) {
            var kddept = $('#kddept').val();
            var kdunit = $('#kdunit').val();
            $('#error').html('<img src="img/loader.gif" alt="loader" />').show();
            $.getJSON('controller/cont.reset.php', {kdsatker: val, kdunit: kdunit, kddept: kddept, cek: true}, function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $('input#' + field).next('#kdsatker').fadeIn(1000).text(data.nama);
                    } else {
                        $('input#' + field).next('#kdsatker').fadeIn(1000).text(data.nama);
                    }
                    $('#error').html('<img src="img/loader.gif" alt="loader" />').hide();
                });
            });
        }
        
        if (field === 'username' && val.length === 11) {
            var kddept = $('#kddept').val();
            var kdunit = $('#kdunit').val();
            var kdsatker = $('#kdsatker').val();
            var user=new String(kddept+kdunit+kdsatker).valueOf();
            $('#error').html('<img src="img/loader.gif" alt="loader" />').show();
            if(val!==user) {
                $('span#username').fadeIn(500).html('<img src="img/wrong.png" alt="loader" />');
                $('#error').html('<img src="img/loader.gif" alt="loader" /> ').hide();
                $('#error').html('Username bukan milik satker').show();
            } else {
                $('span#username').fadeIn(500).html('<img src="img/ok.png" alt="loader" />');
                $('#error').html('<img src="img/loader.gif" alt="loader" /> ').hide();
            }
        }
    });
    
    //submit
    $('#btn_reset').click(function(){
        if($('input[type="text"]').val()==='') {
            $('input[type="text"]').next('span').fadeIn(500).html('<img src="img/wrong.png" alt="loader" /> ').delay(2500).fadeOut(500);
            $('#error').html('Semua harus diisi').show();
        } else {
            $.post($('#frm_reset').attr('action'),$('#frm_reset').serialize(),function(data){
                if(data.msg==='ok') {
                    $('#data_reset').html(data.password).show();
                } else {
                    $('#error').html(data.info).show();
                }
            },'json');
        }
        return false;
    });

});

