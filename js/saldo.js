$(document).ready(function() {
    $.getJSON('controller/cont.saldo.php',function(data){
        if($('input:radio[name=dekon]').is(':checked') === false) {
            $('input:radio[name=dekon]').filter('[value='+data.kddekon+']').attr('checked', true);
        }
    });
});