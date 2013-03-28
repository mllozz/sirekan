$(document).ready(function() {
    $.getJSON('controller/cont.periode.php', function(data) {
        $.each(data,function(index,data){
            var option = $('<option />');
            option.attr('value', data.kdperiode).text(data.nmbulan); 
            $('#periode').append(option);
        });
        
    });
    $.getJSON('controller/cont.ceksakpa.php?data', function(data) {
        $('#kdsatker').html(data.kdsatker).show(); 
        $('#nmsatker').html(data.nmsatker).show();
        if ($('input:radio[name=dekon]').is(':checked') === false) {
            $('input:radio[name=dekon]').filter('[value=' + data.kddekon + ']').attr('checked', true);
        }
    });
});


