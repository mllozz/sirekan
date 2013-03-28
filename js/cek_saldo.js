$(document).ready(function() {
    $.getJSON('controller/cont.ceksaldo.php?data', function(data) {
        $('#kdsatker').html(data.kdsatker).show();
        $('#nmsatker').html(data.nmsatker).show();
        if ($('input:radio[name=dekon]').is(':checked') === false) {
            $('input:radio[name=dekon]').filter('[value=' + data.kddekon + ']').attr('checked', true);
        }
    });

    $('#ceksaldo').submit(function() {
        var kddekon = $('#dekon:checked').val();
        $('#loader').html('<img src="img/loader.gif" alt="loader" />').show();
        $.post('controller/cont.server_data.php?server', {kddekon: kddekon}, function(data) {
                if (data.error === false) {
                    //pengecekan 
                    alert(data.msg);
                } else {
                    alert(data.error);
                }
                $('#loader').html('<img src="img/loader.gif" alt="loader" />').hide();
        },'json');
        return false;
    });

});


