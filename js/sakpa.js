$(document).ready(function() {
    $.getJSON('controller/cont.sakpa.php', function(data) {
        if ($('input:radio[name=dekon]').is(':checked') === false) {
            $('input:radio[name=dekon]').filter('[value=' + data.kddekon + ']').attr('checked', true);
        }
    });
    
    $.getJSON('controller/cont.periode.php', function(data) {
        $.each(data,function(index,data){
            var option = $('<option />');
            option.attr('value', data.kdperiode).text(data.nmbulan); 
            $('#periode').append(option);
        });
        
    });
    
    //$.getJSON('controller/cont.captcha.php',function(data){
        var pic1 = document.getElementById("img_cap"); 
        if (pic1 == typeof('undefined')) return;
        pic1.src = 'controller/cont.captcha.php';
    //});

});

function ajaxFileUpload() {
    $('#loader').ajaxStart(function() {
        $(this).html('<img src="img/loader.gif" alt="loader" />').fadeIn(500);
        //loading('Sedang Memproses Data');
    })
            .ajaxComplete(function() {
        $(this).html('<img src="img/loader.gif" alt="loader" />').fadeOut(500);
        //tutup();
        
    });

    var kddekon = $('#dekon:checked').val();
    var id = $('#id_rekon').val();
    var kdperiode = $('#periode').val();
    var cap=$('#cap').val();
    $.ajaxFileUpload({
        url: 'controller/cont.upload.php',
        secureuri: false,
        fileElementId: 'file_adk',
        dataType: 'json',
        data: {dekon: kddekon, id_rekon: id, periode: kdperiode, cap:cap},
        success: function(data, status)
        {
            if (typeof(data.error) != 'undefined')
            {
                if (data.error != '')
                {
                    $('#output').html(data.error).fadeIn(500).delay(2500).fadeOut(500);
                } else
                {
                    //$('#output').html(data.msg).fadeIn(500).delay(1000).fadeOut(500);
                    
                    Rekon(data.rekon);
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
    loading('Sedang Memproses Data');
    var id_rekon = data.id_rekon, nama_file = data.nama_file, kdperiode=data.periode,kddekon=data.kddekon;
    $.post('controller/cont.rekon.php', {rekon: ulang, id: id_rekon, nama: nama_file,periode: kdperiode,kddekon:kddekon}, function(data) {
        //$('#output').html(data).fadeIn(500).delay(1000).fadeOut(500);
        if (data === 'pernah' && ulang === 0) {
            doConfirm("Rekon Sudah Pernah Dilakukan. Rekon lagi?", function yes()
            {
                ulang = 1;
                var rekon_lagi = {id_rekon: id_rekon, nama_file: nama_file, periode: kdperiode,kddekon:kddekon};
                tutup();
                Rekon(rekon_lagi);
            }, function no()
            {
                ulang = 0;
                tutup();
            });
        } else {
            //transfer data ke rekon_gl
            transferData(kddekon);
            //alert(data);
            var arr={periode:kdperiode,kddekon:kddekon};
            displayHasil(arr);
            ulang = 0;
            tutup();
        }
    }, 'json');
    //alert(data.kdbaes+'/'+data.nama_file+'/'+data.kdsatker);
}

function transferData(data){
    //loading('Sedang Memproses Data');
    $.post('controller/cont.server_data.php?transfer',{kddekon:data},function(data){
        if(data!==false){
            alert(data);
        }
        tutup();
    },'json');
}

function displayHasil(data){
    $.post('controller/cont.rekon.php',{hasil:true,sakpa:true,periode:data.periode,kddekon:data.kddekon},function(data){
        var tabel="";
        //if(data.hasil===false){
            //alert(data.msg);
            tabel+='<tr><th colspan="2">'+ data.msg + '</th></tr>';
            tabel+="<tr><th>Rekon UP</th><td>"+displayBenar(data.bagian.UP)+"</td></tr>";
            tabel+="<tr><th>Rekon Realisasi Belanja</th><td>"+displayBenar(data.bagian.RBelanja)+"</td></tr>";
            tabel+="<tr><th>Rekon Penerimaan Bukan Pajak</th><td>"+displayBenar(data.bagian.BPjk)+"</td></tr>";
            tabel+="<tr><th>Rekon Penerimaan Pajak</th><td>"+displayBenar(data.bagian.Pjk)+"</td></tr>";
            tabel+="<tr><th>Rekon Penerimaan Pembiaayaan</th><td>"+displayBenar(data.bagian.PBiaya)+"</td></tr>";
            tabel+="<tr><th>Rekon Pengeluaran Pembiayaan</th><td>"+displayBenar(data.bagian.KBiaya)+"</td></tr>";
            tabel+="<tr><th>Rekon Pengembalian Belanja</th><td>"+displayBenar(data.bagian.PBelanja)+"</td></tr>";
            $('#hasil tbody').append(tabel);
            $('#div_hasil').fadeIn(500);
        //}else {
        //    alert(data.msg);
        //}
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

function displayBenar(data){
    if(data===true){
        return 'Benar';
    }else{
        return 'Salah';
    }
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