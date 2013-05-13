$(document).ready(function() {
    var now = new Date();

    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var today = now.getFullYear() + "-" + (month) + "-" + (day);

    $('#tgl_awal').datepicker({dateFormat: 'yy-mm-dd'});
    $('#tgl_akhir').datepicker({dateFormat: 'yy-mm-dd'});
    $('#tgl_awal').val('2012-01-01');
    $('#tgl_akhir').val(today);

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
    
    $("input[type=text]").keyup(function() {
        var val = $(this).attr('value');
        var field = $(this).attr('name');
        $('#loader2').html('<img src="img/loader.gif" alt="loader" />').show();
        if (field === 'kddept' && val.length === 3) {
            $.getJSON('controller/cont.rekam.php', {kddept: val, cek: true}, function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $('span#kddept').html(data.nama).fadeIn(500);
                    } else {
                        $('span#kddept').fadeIn(1000).text(data.nama);
                    }
                    $('#loader2').html('<img src="img/loader.gif" alt="loader" />').hide();
                });
            });
        }
        if (field === 'kdunit' && val.length === 2) {
            var kddept = $('#kddept').val();
            $('#loader2').html('<img src="img/loader.gif" alt="loader" />').show();
            $.getJSON('controller/cont.rekam.php', {kdunit: val, kddept: kddept, cek: true}, function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $('span#kdunit').fadeIn(1000).text(data.nama);
                    } else {
                        $('span#kdunit').fadeIn(1000).text(data.nama);
                    }
                    $('#loader2').html('<img src="img/loader.gif" alt="loader" />').hide();
                });
            });
        }
        if (field === 'kdsatker' && val.length === 6) {
            var kddept = $('#kddept').val();
            var kdunit = $('#kdunit').val();
            $('#loader2').html('<img src="img/loader.gif" alt="loader" />').show();
            $.getJSON('controller/cont.rekam.php', {kdsatker: val, kdunit: kdunit, kddept: kddept, cek: true}, function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $('span#kdsatker').fadeIn(1000).text(data.nama);
                    } else {
                        $('span#kdsatker').fadeIn(1000).text(data.nama);
                    }
                    $('#loader2').html('<img src="img/loader.gif" alt="loader" />').hide();
                });
            });
        }
        //$('#loader2').html('<img src="img/loader.gif" alt="loader" />').hide();
    });

    $.getJSON('controller/cont.periode.php', function(data) {
        $.each(data, function(index, data) {
            var option = $('<option />');
            option.attr('value', data.kdperiode).text(data.nmbulan);
            $('#periode').append(option);
        });

    });
    $.getJSON('controller/cont.jnsrekon.php', function(data) {
        $.each(data, function(index, data) {
            var option = $('<option />');
            option.attr('value', data.id_jns_rekon).text(data.nm_rekon);
            $('#jenis_rekon').append(option);
        });

    });

    $('#ceksakpa').submit(function() {
        $('#loader2').html('').hide();
        var kddept= $('#kddept').val();
        var kdunit= $('#kdunit').val();
        var kdsatker= $('#kdsatker').val();
        
        var username=kddept+kdunit+kdsatker;
        var kddekon = $('#dekon:checked').val();
        
        var tgl_awal = $('#tgl_awal').val();
        var tgl_akhir = $('#tgl_akhir').val();
        var e = document.getElementById('jenis_rekon');
        var jns_rekon = e.options[e.selectedIndex].value;
        var data={username: username,kddekon: kddekon, tgl_awal: tgl_awal, tgl_akhir: tgl_akhir,jns_rekon: jns_rekon};
        loading('Sedang Memproses Data');
//        $.post('controller/cont.server_data.php?server&sakpa', {kddekon: kddekon, tgl_awal: tgl_awal, tgl_akhir: tgl_akhir,
//            jns_rekon: jns_rekon}, function(data) {
//            if (data.error === false) {
//                //pengecekan 
//                Cek(data.msg);
//            } else {
//                alert(data.error);
//            }
//            tutup();
//        }, 'json');
        if(kddekon==='' || kddept==='' || kdunit==='' || kdsatker ===''){
            $('#loader2').html('Error, semua harus diisi').show();
        }else{
            Cek(data);
        }
        tutup();
        return false;
    });
});


function loading(msg)
{
    var confirmBox = $("#loader1");
    confirmBox.fadeIn(300);

    //Set the center alignment padding + border see css style
    var popMargTop = (confirmBox.height() + 24) / 2;
    var popMargLeft = (confirmBox.width() + 48) / 2;

    confirmBox.css({
        'margin-top': -popMargTop,
        'margin-left': -popMargLeft
    });

    confirmBox.find(".message").text(msg);
    confirmBox.show();

    // Add the mask to body
    $('body').append('<div id="mask"></div>');
    $('#mask').fadeIn(300);

    return false;
}

function tutup() {
    $('#mask , #loader').fadeOut(300, function() {
        $('#mask').remove();
    });
    return false;
}

function Cek(data) {

    $.post('controller/cont.ceksakpa.php?cekAdmin', {username: data.username,kddekon: data.kddekon, tgl_awal: data.tgl_awal,
        tgl_akhir: data.tgl_akhir, jns_rekon: data.jns_rekon}, function(data) {
        //alert(data);
        $('#hasil_rekon tbody').empty();
        //var i = 1;
        if (data === false) {
            $('#hasil_rekon tbody').append(
                    '<tr>' +
                    '<td align="center" colspan="9">Transaksi Kosong</td>'
                    + '</tr>'
                    );
        } else {
            $.each(data, function(index, data) {
                $('#hasil_rekon tbody').append(
                        '<tr>' +
                        //'<td>' + i + '</td>' +
                        '<td>' + data.KDPERK + '</td>' +
                        '<td>' + data.KDBAES1 + '</td>' +
                        '<td>' + data.KDSATKER + '</td>' +
                        '<td>' + data.JNSDOK1 + '</td>' +
                        '<td>' + data.TGLDOK1 + '</td>' +
                        '<td>' + data.NODOK1 + '</td>' +
                        '<td>' + formatRp(data.RPSAU) + '</td>' +
                        '<td>' + formatRp(data.RPSAI) + '</td>' +
                        '<td>' + data.HASIL + '</td>'
                        + '</tr>'
                        );
                //i++;
            });

            var otable = $('#hasil_rekon').dataTable({
                "bProcessing": true,
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": false,
                "bSort": true,
                "bAutoWidth": false,
                "bJQueryUI": true,
                "iDisplayLength": 15,
                "aoColumns": [
                    {"mData": "KDPERK"},
                    {"mData": "KDBAES1"},
                    {"mData": "KDSATKER"},
                    {"mData": "JNSDOK1"},
                    {"mData": "TGLDOK1"},
                    {"mData": "NODOK1"},
                    {"mData": "RPSAU"},
                    {"mData": "RPSAI"},
                    {"mData": "HASIL"}
                ]
            });
        }
        $('#rekon_sakpa').fadeIn(500);
        $('#ceksakpa').fadeOut(300);
    }, 'json');
}

function formatRp(num) {
    var p = parseFloat(num).toFixed(2).split(".");
    return p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return  num + (i && !(i % 3) ? "." : "") + acc;
    }, "") + "," + p[1];
}
