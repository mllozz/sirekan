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
    
    $('#ceksakpa').submit(function(){
        var kddekon = $('#dekon:checked').val();
        var periode = $('#periode').val();
        loading('Sedang Memproses Data')
        $.post('controller/cont.server_data.php?server', {kddekon: kddekon}, function(data) {
                if (data.error === false) {
                    //pengecekan 
                    alert(data.msg);
                } else {
                    alert(data.error);
                }
                tutup();
        },'json');
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