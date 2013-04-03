$(document).ready(function() {
    var now = new Date();

    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var today = now.getFullYear() + "-" + (month) + "-" + (day);

    $('#tgl_awal').datepicker({dateFormat: 'yy-mm-dd'});
    $('#tgl_akhir').datepicker({dateFormat: 'yy-mm-dd'});
    $('#tgl_awal').val('2012-01-01');
    $('#tgl_akhir').val(today);
    $.getJSON('controller/cont.ceksaldo.php?data', function(data) {
        $('#kdsatker').html(data.kdsatker).show();
        $('#nmsatker').html(data.nmsatker).show();
        if ($('input:radio[name=dekon]').is(':checked') === false) {
            $('input:radio[name=dekon]').filter('[value=' + data.kddekon + ']').attr('checked', true);
        }
    });

    $('#ceksaldo').submit(function() {
        var kddekon = $('#dekon:checked').val();
        var tgl_awal = $('#tgl_awal').val();
        var tgl_akhir = $('#tgl_akhir').val();
        loading('Sedang Memproses Data');
        $.post('controller/cont.server_data.php?server', {kddekon: kddekon, tgl_awal: tgl_awal, tgl_akhir: tgl_akhir},
        function(data) {
            if (data.error === false) {
                //pengecekan 
                Cek(data.msg);
            } else {
                alert(data.error);
            }
            tutup();
        }, 'json');
        return false;
    });

});


function loading(msg)
{
    var confirmBox = $("#loader");
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
    $.post('controller/cont.ceksaldo.php?cek', {kddekon: data.kddekon, tgl_awal: data.tgl_awal,
        tgl_akhir: data.tgl_akhir}, function(data) {
        //alert(data);
        $('#hasil_rekon tbody').empty();
        $.each(data, function(index, data) {   
            $('#hasil_rekon tbody').append(
                    '<tr>' +
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
        });
        $('#rekon_saldo').fadeIn(500);
    }, 'json');
}

function formatRp(num) {
    var p = parseFloat(num).toFixed(2).split(".");
    return p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return  num + (i && !(i % 3) ? "." : "") + acc;
    }, "") + "," + p[1];
}