$(document).ready(function() {

    $.getJSON('controller/cont.blokir.php', function(data) {

        $.each(data, function(index, data) {
            $('#grid tbody').append('<tr class="'+ data.id_user +'"><td>' + data.kddept + "</td><td>" + data.kdunit
                    + "</td><td>" + data.kdsatker + "</td><td>" + data.nmsatker + "</td><td>" + data.nmakses +
                    "</td><td>" + data.username + "</td><td>" + data.status_blokir + "</td></tr>");
        });
    });

    $('#refresh').click(function() {
        $('#grid tbody').empty();
        $('input#cari').val('');
        $.getJSON('controller/cont.blokir.php', function(data) {

            $.each(data, function(index, data) {
                $('#grid tbody').append('<tr class="'+ data.id_user +'"><td>' + data.kddept + "</td><td>" + data.kdunit
                        + "</td><td>" + data.kdsatker + "</td><td>" + data.nmsatker + "</td><td>" + data.nmakses +
                        "</td><td>" + data.username + "</td><td>" + data.status_blokir + "</td></tr>");
            });
        });
    });


    $('input#cari').keyup(function() {
        var str = $('input#cari').val();
        if (str.length === 0) {
            $('#grid tbody').empty();
            $('input#cari').val('');
            $.getJSON('controller/cont.blokir.php', function(data) {

                $.each(data, function(index, data) {
                    $('#grid tbody').append('<tr class="'+ data.id_user +'"><td>' + data.kddept + "</td><td>" + data.kdunit
                            + "</td><td>" + data.kdsatker + "</td><td>" + data.nmsatker + "</td><td>" + data.nmakses +
                            "</td><td>" + data.username + "</td><td>" + data.status_blokir + "</td></tr>");
                });
            });
        } else if (!isNaN(str)) {
            $.post('controller/cont.blokir.php', {aksi: 'cari', kata: $('input#cari').val()}, function(data) {
                $.each(data, function(index, data) {
                    $('#grid tbody').html('<tr class="'+ data.id_user +'"><td>' + data.kddept + "</td><td>" + data.kdunit
                            + "</td><td>" + data.kdsatker + "</td><td>" + data.nmsatker + "</td><td>" + data.nmakses +
                            "</td><td>" + data.username + "</td><td>" + data.status_blokir + "</td></tr>");
                });
            }, 'json');
        } else {
            $.post('controller/cont.blokir.php', {aksi: 'cari', filter: 'nmsatker', kata: $('input#cari').val()}, function(data) {
                if (Object.keys(data).length > 4) {
                    //alert(data.nmsatker);
                    if (Object(data).length > 1) {
                        $.each(data, function(index, data) {
                            $('#grid tbody').html('<tr class="'+ data.id_user +'"><td>' + data.kddept + "</td><td>" + data.kdunit
                                    + "</td><td>" + data.kdsatker + "</td><td>" + data.nmsatker + "</td><td>" + data.nmakses +
                                    "</td><td>" + data.username + "</td><td>" + data.status_blokir + "</td></tr>");
                        });
                    } else {
                        $('#grid tbody').html('<tr class="'+ data.id_user +'"><td>' + data.kddept + "</td><td>" + data.kdunit
                                + "</td><td>" + data.kdsatker + "</td><td>" + data.nmsatker + "</td><td>" + data.nmakses +
                                "</td><td>" + data.username + "</td><td>" + data.status_blokir + "</td></tr>");
                    }
                }
            }, 'json');
        }

    });
    $('#grid tbody').on('click','td',function(data){
        var id=$(this).closest('tr').attr('class');
        if(id!==''){
            $.post('controller/cont.blokir.php',{aksi:'ubah',id_user:id},function(data){
                $('#frm_blokir').html('').show();
            },'json');
        }
    });
});
