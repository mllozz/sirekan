$(document).ready(function() {
    
    $('#tgl_surat').datepicker({dateFormat: 'yy-mm-dd'});
    //input hanya angka
    $(".int").keydown(function(e) {
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
        $('#loader').html('<img src="img/loader.gif" alt="loader" />').show();
        if (field === 'kddept' && val.length === 3) {
            $.getJSON('controller/cont.rekam.php', {kddept: val, cek: true}, function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $('span#kddept').html(data.nama).fadeIn(500);
                    } else {
                        $('span#kddept').fadeIn(1000).text(data.nama);
                    }
                    $('#loader').html('<img src="img/loader.gif" alt="loader" />').hide();
                });
            });
        }
        if (field === 'kdunit' && val.length === 2) {
            var kddept = $('#kddept').val();
            $('#loader').html('<img src="img/loader.gif" alt="loader" />').show();
            $.getJSON('controller/cont.rekam.php', {kdunit: val, kddept: kddept, cek: true}, function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $('span#kdunit').fadeIn(1000).text(data.nama);
                    } else {
                        $('span#kdunit').fadeIn(1000).text(data.nama);
                    }
                    $('#loader').html('<img src="img/loader.gif" alt="loader" />').hide();
                });
            });
        }
        if (field === 'kdsatker' && val.length === 6) {
            var kddept = $('#kddept').val();
            var kdunit = $('#kdunit').val();
            $('#loader').html('<img src="img/loader.gif" alt="loader" />').show();
            $.getJSON('controller/cont.rekam.php', {kdsatker: val, kdunit: kdunit, kddept: kddept, cek: true}, function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $('span#kdsatker').fadeIn(1000).text(data.nama);
                    } else {
                        $('span#kdsatker').fadeIn(1000).text(data.nama);
                    }
                    $('#loader').html('<img src="img/loader.gif" alt="loader" />').hide();
                });
            });
        }
    });

    //submit form
    $('#frm_rekam').submit(function() {
        $('#loader').html('<img src="img/loader.gif" alt="loader" />').show();
        if ($('#kddept').val() === '' || $('#kdunit').val() === '' || $('#kdsatker').val() === '' || $('#no_surat').val() === '' || $('#tgl_surat').val() === '') {
            $('#error').html('Tidak boleh kosong').fadeIn(1000).delay(3500).fadeOut(500);
            $('#loader').html('<img src="img/loader.gif" alt="loader" />').hide();
            return false;
        } else {
            $.post($('#frm_rekam').attr('action'), $('#frm_rekam').serialize(), function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $("input[type=text]").val('');
                        $("input").next('span').fadeOut(500).text('');
                        $('#user_baru').html(data.password + ' ====> ' + data.username).show();
                    } else {
                        $("input[type=text]").val('');
                        $("input").next('span').fadeOut(500).text('');
                        $('#user_baru').html(data.info).fadeIn(500).delay(3500).fadeOut(500);
                    }
                });
            }, 'json');
        }
        $('#loader').html('<img src="img/loader.gif" alt="loader" />').hide();
        return false;
    });
});

