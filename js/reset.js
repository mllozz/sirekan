$(document).ready(function() {
    $.getJSON('controller/cont.menu.php?admin', function(data) {
        if (data === '2') {
            window.location = 'main.php';
        }
    });

    var now = new Date();

    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    $('#tgl_surat').datepicker({dateFormat: 'yy-mm-dd'});
    $('#tgl_surat').val(today);
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
        $('#error').html('<img src="img/loader.gif" alt="loader" />').show();
        if (field === 'kddept' && val.length === 3) {
            $.getJSON('controller/cont.reset.php', {kddept: val, cek: true}, function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $('span#kddept').fadeIn(1000).text(data.nama);
                    } else {
                        $('span#kddept').fadeIn(1000).text(data.nama);
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
                        $('span#kdunit').fadeIn(1000).text(data.nama);
                    } else {
                        $('span#kdunit').fadeIn(1000).text(data.nama);
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
                        $('span#kdsatker').fadeIn(1000).text(data.nama);
                    } else {
                        $('span#kdsatker').fadeIn(1000).text(data.nama);
                    }
                    $('#error').html('<img src="img/loader.gif" alt="loader" />').hide();
                });
            });
        }

        if (field === 'username' && val.length === 13) {
            var kddept = $('#kddept').val();
            var kdunit = $('#kdunit').val();
            var kdsatker = $('#kdsatker').val();
            var kddekon = $('#dekon:checked').val();
            var user = new String(kddept + kdunit + kdsatker + kddekon).valueOf();
            $('#error').html('<img src="img/loader.gif" alt="loader" />').show();
            if (val !== user) {
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
    $('#btn_reset').click(function() {
        var kddekon = $('#dekon:checked').val();
        //var kdakses = e.options[e.selectedIndex].value;
        var kddept=$('#kddept').val();
        var kdunit= $('#kdunit').val();
        var kdsatker=$('#kdsatker').val();
        var username = $('#username').val();
        if ($('#kddept').val() === '' || $('#kdunit').val() === '' || $('#kdsatker').val() === '' || $('#username').val() === '' ||
                $('#no_surat').val() === '' || $('#tgl_surat').val() === '' || kddekon === '') {
            $('td span').fadeIn(500).html('<img src="img/wrong.png" alt="loader" /> ').delay(2500).fadeOut(500);
            $('#error').html('Semua harus diisi').show();
        } else {
            $.post($('#frm_reset').attr('action'), $('#frm_reset').serialize(), function(data) {
                
                var password = '';
                if (data.msg === 'ok') {
                    //$('#data_reset').html(data.password).show();
                    $('#grid').fadeOut(500);
                    password = data.password;
                    var arr = {kddept: kddept, kdunit: kdunit,
                        kdsatker: kdsatker, kddekon: kddekon, username: username, password: password};
                    cetakPass(arr);
                } else {
                    $('#error').html(data.info).show();
                }
            }, 'json');
        }
        return false;
    });

});

function cetakPass(data) {
    $.post('controller/cont.reset.php?pdf', {kddept: data.kddept, kdunit: data.kdunit, kdsatker: data.kdsatker,
        kddekon: data.kddekon, username: data.username, password: data.password}, function(data) {
        if (data === true) {
            $('#output').html('Gagal Cetak PDF');
        } else {
            //window.open('BAR.pdf', '_blank', 'fullscreen=yes');
            $('#grid').fadeOut(250);
            var pdf = new PDFObject({
                url: data,
                id: "pdf",
                pdfOpenParams: {
                    view: "FitH"
                }
            }).embed("pdf");
        }
    }, 'json');
}
