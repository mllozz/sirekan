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
        if (field === 'kddept' && val.length === 3) {
            $.getJSON('controller/cont.rekam.php', {kddept: val, cek: true}, function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $('input#' + field).next('#kddept').fadeIn(1000).text(data.nama);
                    } else {
                        $('input#' + field).next('#kddept').fadeIn(1000).text(data.nama);
                    }
                });
            });
        }
        if (field === 'kdunit' && val.length === 2) {
            $.getJSON('controller/cont.rekam.php', {kdunit: val, cek: true}, function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $('input#' + field).next('#kdunit').fadeIn(1000).text(data.nama);
                    } else {
                        $('input#' + field).next('#kdunit').fadeIn(1000).text(data.nama);
                    }
                });
            });
        }
        if (field === 'kdsatker' && val.length === 6) {
            $.getJSON('controller/cont.rekam.php', {kdsatker: val, cek: true}, function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $('input#' + field).next('#kdsatker').fadeIn(1000).text(data.nama);
                    } else {
                        $('input#' + field).next('#kdsatker').fadeIn(1000).text(data.nama);
                    }
                });
            });
        }
    });

    //submit form
    $('#frm_rekam').submit(function() {
        if ($('#kddept').val() === '' || $('#kdunit').val() === '' || $('#kdsatker').val() === '') {
            $('#error').html('Tidak boleh kosong').show();
            return false;
        } else {
            $.getJSON($('#frm_rekam').attr('action'), $('#frm_rekam').serialize(), function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        alert('ok dab');
                    }
                });
            });
        }
        return false;
    });
});

