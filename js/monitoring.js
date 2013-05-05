$(document).ready(function() {

    $.getJSON('controller/cont.monitoring.php?user_pie', function(data) {
        var det = [
            {label: "Aktif", data: data.aktif, color: 'green'},
            {label: "Terblokir", data: data.blokir, color: 'red'}
        ];
        drawPieUser('#div1', '#title', 'User Aktif dan Terblokir', det);
    });

    $.getJSON('controller/cont.monitoring.php?rekon_pie', function(data) {
        var arr = [
            {label: "Rekon Benar", data: parseInt(data.benar), color: 'green'},
            {label: "Rekon Salah", data: parseInt(data.salah), color: 'yellow'},
            {label: "Belum Rekon", data: parseInt(data.belum), color: 'red'}
        ];
        drawPieUser('#div1_pie2', '#title2', 'Hasil Rekon Per Periode', arr);
    });
    $('#loader').html('<img src="img/loader.gif" alt="loader" />').show();
    $.getJSON('controller/cont.monitoring.php?status_rekon', function(data) {
        $.each(data, function(index, data) {
            $('#hasil_rekon tbody').append(
                    '<tr>' +
                    '<td>' + data.kddept + '</td>' +
                    '<td>' + data.kdunit + '</td>' +
                    '<td>' + data.kdsatker + '</td>' +
                    '<td>' + data.kddekon + '</td>' +
                    '<td align="center"><img src="img/' + iconDrawer(data.jan, 'jan') + '.png" /></td>' +
                    '<td align="center"><img src="img/' + iconDrawer(data.feb, 'feb') + '.png" /></td>' +
                    '<td align="center"><img src="img/' + iconDrawer(data.mar, 'mar') + '.png" /></td>' +
                    '<td align="center"><img src="img/' + iconDrawer(data.apr, 'apr') + '.png" /></td>' +
                    '<td align="center"><img src="img/' + iconDrawer(data.mei, 'mei') + '.png" /></td>' +
                    '<td align="center"><img src="img/' + iconDrawer(data.jun, 'jun') + '.png" /></td>' +
                    '<td align="center"><img src="img/' + iconDrawer(data.jul, 'jul') + '.png" /></td>' +
                    '<td align="center"><img src="img/' + iconDrawer(data.ags, 'ags') + '.png"  /></td>' +
                    '<td align="center"><img src="img/' + iconDrawer(data.sep, 'sep') + '.png" /></td>' +
                    '<td align="center"><img src="img/' + iconDrawer(data.okt, 'okt') + '.png" /></td>' +
                    '<td align="center"><img src="img/' + iconDrawer(data.nov, 'nov') + '.png" /></td>' +
                    '<td align="center"><img src="img/' + iconDrawer(data.des, 'des') + '.png" /></td>'
                    + '</tr>'
                    );
            //i++;
        });
        $('#loader').html('<img src="img/loader.gif" alt="loader" />').hide();
        var otable = $('#hasil_rekon').dataTable({
            "bProcessing": true,
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": false,
            "bJQueryUI": true,
            "iDisplayLength": 5,
            "aoColumns": [
                {"mData": "kddept"},
                {"mData": "kdunit"},
                {"mData": "kdsatker"},
                {"mData": "kddekon"},
                {"mData": "jan"},
                {"mData": "feb"},
                {"mData": "mar"},
                {"mData": "apr"},
                {"mData": "mei"},
                {"mData": "jun"},
                {"mData": "jul"},
                {"mData": "ags"},
                {"mData": "sep"},
                {"mData": "okt"},
                {"mData": "nov"},
                {"mData": "des"}
            ]
        });
        $('#hasil_rekon').fadeIn(500);
    });

    $.getJSON('controller/cont.monitoring.php?stat_user', function(data) {
        var tabel = '';
        if (data.id === '1') {
            $('#grid_stat tbody').append(
                    '<tr><th align="left">Kode Satker</th>' +
                    '<td>' + data.kddept + '.' + data.kdunit + '.' + data.kdsatker + '</td>' +
                    '</tr>' +
                    '<tr><th align="left">Nama Satker</th>' +
                    '<td>' + data.nmsatker + '</td>' +
                    '</tr>' +
                    '<tr><th align="left">Tgl Rekon Bulan Ini</th>' +
                    '<td>' + data.tgl_rekon + '</td>' +
                    '</tr>' +
                    '<tr><th align="left">Status Rekon Bulan Ini</th>' +
                    '<td>' + data.hasil + '</td>' +
                    '</tr>'
                    );
        } else {


            $('#grid_stat tbody').append(
                    '<tr><th align="left">Kode Satker</th>' +
                    '<td>' + data.kddept + '.' + data.kdunit + '.' + data.kdsatker + '</td>' +
                    '</tr>' +
                    '<tr><th align="left">Nama Satker</th>' +
                    '<td>' + data.nmsatker + '</td>' +
                    '</tr>' +
                    '<tr><th align="left">Tgl Rekon Bulan Ini</th>' +
                    '<td>' + data.tgl_rekon + '</td>' +
                    '</tr>' +
                    '<tr><th  colspan="2" align="center">Status Rekon Bulan Ini</th>' +
                    '</tr>'
                    );
            tabel += '<table style="border: 1px solid black; width: 90%;">';
            tabel += '<tr><th style=" text-align:left; width:50%;">Rekon UP</th><td>' + 
                    displayBenar(data.hasil.UP) + '</td></tr>';
            tabel += '<tr><th  style=" text-align:left; width:50%;">Rekon Realisasi Belanja</th><td>' + 
                    displayBenar(data.hasil.RBelanja) + '</td></tr>';
            tabel += '<tr><th  style=" text-align:left; width:50%;">Rekon Penerimaan Bukan Pajak</th><td>' + 
                    displayBenar(data.hasil.BPjk) + '</td></tr>';
            tabel += '<tr><th  style=" text-align:left; width:50%;">Rekon Penerimaan Pajak</th><td>' + 
                    displayBenar(data.hasil.Pjk) + '</td></tr>';
            tabel += '<tr><th  style=" text-align:left; width:50%;">Rekon Penerimaan Pembiaayaan</th><td>' + 
                    displayBenar(data.hasil.PBiaya) + '</td></tr>';
            tabel += '<tr><th  style=" text-align:left; width:50%;">Rekon Pengeluaran Pembiayaan</th><td>' + 
                    displayBenar(data.hasil.KBiaya) + '</td></tr>';
            tabel += '<tr><th  style=" text-align:left; width:50;">Rekon Pengembalian Belanja</th><td>' + 
                    displayBenar(data.hasil.PBelanja) + '</td></tr>';
            tabel+='</table>';
            $('#hasil_rek').html(tabel).show();
        }
    });

});

function displayBenar(data) {
    if (data === true) {
        return 'Benar';
    } else {
        return 'Salah';
    }
}

function drawPieUser(divnya, tmp_judul, judul, data) {

    var placeholder = $(divnya);

    placeholder.unbind();

    $(tmp_judul).text(judul);

    $.plot(placeholder, data, {
        series: {
            pie: {
                show: true,
                radius: 1,
                label: {
                    show: true,
                    radius: 1 / 2,
                    formatter: labelFormatter,
                    background: {
                        opacity: 0.5
                    }
                }
            }
        },
        legend: {
            show: true
        },
        grid: {
            hoverable: true
        }
    });
}

function labelFormatter(label, series) {
    return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" +
            Math.round(series.percent) + "% (" + series.data[0][1] + " user)</div>";
}

function iconDrawer(stat, bul) {

    var bulan = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'ags', 'sep', 'okt', 'nov', 'des'];

    var tgl = new Date();
    var bln_ini = tgl.getMonth();

    var bln_lewat = bulan.slice(0, bln_ini + 1);

    if (stat === false && ($.inArray(bul, bln_lewat)) === -1) {
        return 'not_yet';
    } else if (stat === false && ($.inArray(bul, bln_lewat)) === 0) {
        return 'wrong';
    } else if (stat === '2') {
        return 'ok';
    } else {
        return 'wrong';
    }
}
