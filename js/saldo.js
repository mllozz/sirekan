$(document).ready(function() {
    $.getJSON('controller/cont.saldo.php', function(data) {
        if ($('input:radio[name=dekon]').is(':checked') === false) {
            $('input:radio[name=dekon]').filter('[value=' + data.kddekon + ']').attr('checked', true);
        }
    });
    
    var pic1 = document.getElementById("img_cap"); 
    if (pic1 == typeof('undefined')) return;
    pic1.src = 'controller/cont.captcha.php';

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
    var cap=$('#cap').val();
    $.ajaxFileUpload({
        url: 'controller/cont.upload.php',
        secureuri: false,
        fileElementId: 'file_adk',
        dataType: 'json',
        data: {dekon: kddekon, id_rekon: id, cap:cap},
        success: function(data, status)
        {
            if (typeof(data.error) != 'undefined')
            {
                if (data.error != '')
                {
                    $('#output').html(data.error).fadeIn(500);
                } else
                {
                    $('#output').html(data.msg).fadeIn(500).delay(1000).fadeOut(500);
                    //$.each(data,function(index,rekon){
                    Rekon(data.rekon);
                    //});
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
var ulang = 0;
function Rekon(data) {
    var id_rekon = data.id_rekon, nama_file = data.nama_file,kddekon=data.kddekon;
    $.post('controller/cont.rekon.php', {rekon: ulang, id: id_rekon, nama: nama_file,kddekon:kddekon}, function(data) {
        //$('#output').html(data).fadeIn(500).delay(1000).fadeOut(500);
        if (data === 'pernah' && ulang === 0) {

            doConfirm("Rekon Sudah Pernah Dilakukan. Rekon lagi?", function yes()
            {
                ulang = 1;
                var rekon_lagi = {id_rekon: id_rekon, nama_file: nama_file,kddekon:kddekon};
                tutup();
                Rekon(rekon_lagi);
            }, function no()
            {
                ulang = 0;
                tutup();
            });
        } else {
            //alert(data);
            transferData(kddekon);
            var arr={kddekon:kddekon};
            displayHasil(arr);
            ulang = 0;
        }
    }, 'json');
    //alert(data.kdbaes+'/'+data.nama_file+'/'+data.kdsatker);
}

function transferData(data){
    loading('Sedang Memproses Data');
    $.post('controller/cont.server_data.php?transfer',{kddekon:data},function(data){
        if(data!==false){
            alert(data);
        }
        tutup();
    },'json');
}

function displayHasil(data){
    $.post('controller/cont.rekon.php',{hasil:true,kddekon:data.kddekon},function(data){
        if(data.bagian.SALDO===true){
            alert('Rekonsiliasi Saldo Awal Cocok');
        }else {
            alert('Rekonsiliasi Saldo Awal Salah, Silahkan Teliti Terlebih Dahulu')
        }
    },'json');
}

function loading(msg)
{
    var confirmBox = $("#loader_2");
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

function doConfirm(msg, yesFn, noFn)
{
    var confirmBox = $("#confirmBox");
    confirmBox.fadeIn(300);

    //Set the center alignment padding + border see css style
    var popMargTop = (confirmBox.height() + 24) / 2;
    var popMargLeft = (confirmBox.width() + 48) / 2;

    confirmBox.css({
        'margin-top': -popMargTop,
        'margin-left': -popMargLeft
    });

    confirmBox.find(".message").text(msg);
    confirmBox.find(".yes,.no").unbind().click(function()
    {
        confirmBox.hide();
    });
    confirmBox.find(".yes").click(yesFn);
    confirmBox.find(".no").click(noFn);
    confirmBox.show();

    // Add the mask to body
    $('body').append('<div id="mask"></div>');
    $('#mask').fadeIn(300);

    return false;
}

function tutup() {
    $('#mask , #confirmBox').fadeOut(300, function() {
        $('#mask').remove();
    });
    return false;
}