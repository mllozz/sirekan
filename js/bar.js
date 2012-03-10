$(document).ready(function() {
    $.getJSON('controller/cont.bar.php?detail', function(data) {
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
    $('#cetak_bar').on('click', function() {
        $('#loader').html('<img src="img/loader.gif" alt="loader" />').show();
        var periode = $('#periode').val();
        var kddekon = $('#dekon:checked').val();
        $.post($('#frm_bar').attr('action'), {cetak: true, periode: periode, kddekon: kddekon}, function(data) {
            if (data.error === true) {
                $('#output').html('Gagal Cetak PDF, '+data.msg).fadeIn(500).delay(2500).fadeOut(500);
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

