$(document).ready(function() {
    $.getJSON('controller/cont.lampiran.php?detail', function(data) {
        $('#kdsatker').html(data.kdsatker).show();
        $('#nmsatker').html(data.nmsatker).show();
        if ($('input:radio[name=dekon]').is(':checked') === false) {
            $('input:radio[name=dekon]').filter('[value=' + data.kddekon + ']').attr('checked', true);
        }
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
    
    $('#cetak_lampiran').on('click', function() {
        $('#loader').html('<img src="img/loader.gif" alt="loader" />').show();
        var periode = $('#periode').val();
        var kddekon = $('#dekon:checked').val();
        var e = document.getElementById('jenis_rekon');
        var jns_rekon = e.options[e.selectedIndex].value;
        $.post($('#frm_lampiran').attr('action'), {cetak: true, periode: periode, kddekon: kddekon, jns_rekon: jns_rekon}, 
        function(data) {
            if (data.error === true) {
                $('#output').html('Gagal Cetak PDF, '+data.msg).show();
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
        $('#loader').html('<img src="img/loader.gif" alt="loader" />').hide();
        return false;
    });
});

