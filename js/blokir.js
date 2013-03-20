$(document).ready(function() {

    $('#tgl_mulai').datepicker({dateFormat: 'yy-mm-dd'});
    $('#tgl_akhir').datepicker({dateFormat: 'yy-mm-dd'});
    function appendData(data) {
        if (data.length === 0) {
            $('#grid tbody').append('<tr id="row"><td colspan="7">Tidak Ada</td></tr>');
        } else {
            $('#grid tbody').append('<tr id="row" class="' + data.id_user + '"><td>' + data.kddept + "</td><td>" + data.kdunit
                    + "</td><td>" + data.kdsatker + "</td><td>" + data.nmsatker + "</td><td>" + data.nmakses +
                    "</td><td>" + data.username + "</td><td>" + data.status_blokir + "</td></tr>");
        }
    }

    function appendHtml(data) {
        if (data.length === 0) {
            $('#grid tbody').html('<tr id="row"><td colspan="7">Tidak Ada</td></tr>');
        } else {
            $('#grid tbody').html('<tr id="row" class="' + data.id_user + '"><td>' + data.kddept + "</td><td>" + data.kdunit
                    + "</td><td>" + data.kdsatker + "</td><td>" + data.nmsatker + "</td><td>" + data.nmakses +
                    "</td><td>" + data.username + "</td><td>" + data.status_blokir + "</td></tr>");
        }
    }

    $.getJSON('controller/cont.blokir.php', function(data) {
        $.each(data, function(index, data) {
            appendData(data);
        });
    });

    $('#next').click(function() {
        return false;
    });



    $('#refresh').click(function() {
        $('#grid tbody').empty();
        $('input#cari').val('');
        $.getJSON('controller/cont.blokir.php', function(data) {

            $.each(data, function(index, data) {
                appendData(data);
            });
        });
    });


    $('input#cari').keyup(function() {
        var str = $('input#cari').val();
        if (str.length === 0) {
            $('#grid tbody').empty();
            $('input#cari').val('');
            $.getJSON('controller/cont.blokir.php', function(data) {

                $.each(data, function(index, data) {
                    appendData(data);
                });
            });
        } else if (!isNaN(str)) {
            $.post('controller/cont.blokir.php', {aksi: 'cari', kata: $('input#cari').val()}, function(data) {
                $.each(data, function(index, data) {
                    appendHtml(data);
                });
            }, 'json');
        } else {
            $.post('controller/cont.blokir.php', {aksi: 'cari', filter: 'nmsatker', kata: $('input#cari').val()}, function(data) {
                if (Object.keys(data).length > 4) {
                    //alert(data.nmsatker);
                    if (Object(data).length > 1) {
                        $.each(data, function(index, data) {
                            appendHtml(data);
                        });
                    } else {
                        appendHtml(data);
                    }
                }
            }, 'json');
        }

    });
    $('#grid tbody').on('click', 'td', function(data) {
        $('#tgl_mulai').datepicker({dateFormat: 'yy-mm-dd'});
        $('#tgl_akhir').datepicker({dateFormat: 'yy-mm-dd'});
        var id = $(this).closest('tr').attr('class');
        if (id !== '') {
            $.post('controller/cont.blokir.php', {aksi: 'ubah', id_user: id}, function(data) {
                $('#div_blokir').fadeIn(500);
                $('#simpan_blokir').hide();
                $('#simpan_baru_blokir').hide();
                $('#edit_blokir').show();
                $('#buka_blokir').show();
                document.getElementById('id_user').value = data.id_user;
                document.getElementById('id_blokir').value = data.id_blokir;
                $('#username').html(data.username);
                $('#kddept').html(data.kddept);
                $('#nmdept').html(data.nmdept);
                $('#kdunit').html(data.kdunit);
                $('#nmunit').html(data.nmunit);
                $('#kdsatker').html(data.kdsatker);
                $('#nmsatker').html(data.nmsatker);
                document.getElementById('tgl_mulai').value = data.tgl_mulai;
                document.getElementById('tgl_akhir').value = data.tgl_akhir;
                document.getElementById('ket_blokir').value = data.ket_blokir;
                $('#tgl_mulai').attr('disabled', true);
                $('#tgl_akhir').attr('disabled', true);
                $('#ket_blokir').attr('disabled', true);
                $('#edit_blokir').removeAttr("disabled");
                $('#buka_blokir').attr("disabled", true);
                if (data.is_blokir === 'no') {
                    $('#simpan_blokir').show();
                    $('#edit_blokir').hide();
                    $('#simpan_baru_blokir').hide();
                    $('#tgl_mulai').removeAttr("disabled");
                    $('#tgl_akhir').removeAttr("disabled");
                    $('#ket_blokir').removeAttr("disabled");
                    $('#buka_blokir').attr("disabled", true);
                    document.getElementById('tgl_mulai').value = '';
                    document.getElementById('tgl_akhir').value = '';
                    document.getElementById('ket_blokir').value = '';
                    document.getElementById('id_blokir').value = '';
                }
            }, 'json');
        }
    });
    $('#edit_blokir').click(function() {
        $('#tgl_mulai').removeAttr("disabled");
        $('#tgl_akhir').removeAttr("disabled");
        $('#ket_blokir').removeAttr("disabled");
        $('#simpan_baru_blokir').show();
        $('#edit_blokir').attr('disabled', true);
        $('#buka_blokir').show();
        $('#tgl_mulai').datepicker({dateFormat: 'yy-mm-dd'});
        $('#tgl_akhir').datepicker({dateFormat: 'yy-mm-dd'});
        return false;
    });
    

    $('#batal_blokir').click(function() {
        $('#tgl_mulai').datepicker({dateFormat: 'yy-mm-dd'});
        $('#tgl_akhir').datepicker({dateFormat: 'yy-mm-dd'});
        $('#div_blokir').fadeOut();
        return false;
    });

    $('#simpan_blokir').click(function() {
        if ($('#tgl_mulai').val() === '' || $('#tgl_akhir').val() === '' || $('#ket_blokir').val() === '') {
            $('#error').html('Tidak boleh kosong').fadeIn(500).delay(2500).fadeOut(500);
            return false;
        } else if ($('#tgl_mulai').val() >= $('#tgl_akhir').val()) {
            $('#error').html('Tgl mulai harus lebih dahulu').fadeIn(500).delay(2500).fadeOut(500);
            return false;
        } else {
            $.post('controller/cont.blokir.php', {id_user: $('#id_user').val(),
                tgl_mulai: $('#tgl_mulai').val(),tgl_akhir: $('#tgl_akhir').val(),
                ket_blokir: $('#ket_blokir').val(),aksi: 'simpan'
            }, function(data) {
                if (data.msg === 'ok') {
                    $('#error').html('Berhasil di blokir').fadeIn(500).delay(2500).fadeOut(500);
                    $('#refresh').trigger('click');
                    $('#div_blokir').fadeOut();
                } else {
                    alert(data.info);
                }
            }, 'json');
        }
        return false;
    });

    $('#simpan_baru_blokir').click(function() {
        if ($('#tgl_mulai').val() === '' || $('#tgl_akhir').val() === '' || $('#ket_blokir').val() === '') {
            $('#error').html('Tidak boleh kosong ubah').fadeIn(500).delay(2500).fadeOut(500);
            return false;
        } else if ($('#tgl_mulai').val() >= $('#tgl_akhir').val()) {
            $('#error').html('Tgl mulai harus lebih dahulu').fadeIn(500).delay(2500).fadeOut(500);
            return false;
        } else {
            
            $.post('controller/cont.blokir.php',{id_blokir: $('#id_blokir').val(),id_user: $('#id_user').val(),
                tgl_mulai: $('#tgl_mulai').val(),tgl_akhir: $('#tgl_akhir').val(),
                ket_blokir: $('#ket_blokir').val(),aksi: 'simpan_ubah'
            }, function(data) {
                if (data.msg === 'ok') {
                    $('#error').html('Berhasil di Simpan').fadeIn(500).delay(2500).fadeOut(500);
                    $('#refresh').trigger('click');
                    $('#div_blokir').fadeOut();
                } else {
                    alert(data.info);
                }
            }, 'json');
        }
        return false;
    });

    $('#buka_blokir').click(function() {
        var varr = $('#id_blokir').val();
        $.post('controller/cont.blokir.php', {aksi: 'buka', id_blokir: varr}, function(data) {
            if (data.msg === 'ok') {
                $('#error').html('Blokir dibuka').fadeIn(500).delay(2500).fadeOut(500);
                $('#buka_blokir').hide();
                $('#refresh').trigger('click');
                $('#div_blokir').fadeOut();
            } else {
                $('#error').html('Gagal membuka blokir').fadeIn(500).delay(2500).fadeOut(500);
            }
        }, 'json');
        return false;
    });
});
