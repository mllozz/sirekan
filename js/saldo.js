$(document).ready(function() {
    $.getJSON('controller/cont.saldo.php', function(data) {
        if ($('input:radio[name=dekon]').is(':checked') === false) {
            $('input:radio[name=dekon]').filter('[value=' + data.kddekon + ']').attr('checked', true);
        }
    });

});

function ajaxFileUpload() {
    $('#loader').ajaxStart(function() {
        $(this).html('<img src="img/loader.gif" alt="loader" />').fadeIn(500);
    })
            .ajaxComplete(function() {
        $(this).html('<img src="img/loader.gif" alt="loader" />').fadeOut(500);
    });

    var kddekon = $('#dekon:checked').val();
    var id = $('#id_rekon').val();
    $.ajaxFileUpload({
        url: 'controller/cont.upload.php',
        secureuri: false,
        fileElementId: 'file_adk',
        dataType: 'json',
        data: {dekon: kddekon, id_rekon: id},
        success: function(data, status)
        {
            if (typeof(data.error) != 'undefined')
            {
                if (data.error != '')
                {
                    $('#output').html(data.error).fadeIn(500);
                } else
                {
                    $('#output').html(data.msg).fadeIn(500);
                }
            }
        },
        error: function(data, status, e)
        {
            $('#output').html(e).fadeIn(500);
        }
    });
    return false;
}