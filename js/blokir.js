$(document).ready(function() {

    $.getJSON('controller/cont.blokir.php', function(data) {

        $.each(data, function(index, data) {
            $('#grid tbody').append('<tr><td>' + data.id_user + "</td><td>" + data.kddept + "</td><td>" + data.kdunit
                    + "</td><td>" + data.kdsatker + "</td><td>" + data.nmsatker + "</td><td>" + data.nmakses +
                    "</td><td>" + data.username + "</td></tr>");
        });
    });

    $('#refresh').click(function() {
        $('#grid tbody').empty();
        $('input#cari').val('');
        $.getJSON('controller/cont.blokir.php', function(data) {

            $.each(data, function(index, data) {
                $('#grid tbody').append('<tr><td>' + data.id_user + "</td><td>" + data.kddept + "</td><td>" + data.kdunit
                        + "</td><td>" + data.kdsatker + "</td><td>" + data.nmsatker + "</td><td>" + data.nmakses +
                        "</td><td>" + data.username + "</td></tr>");
            });
        });
    });


    $('input#cari').keyup(function() {
        var str = $('input#cari').val();
        if (!isNaN(str)) {
            $.post('controller/cont.blokir.php', {aksi: 'cari', kata: $('input#cari').val()}, function(data) {
                $.each(data, function(index, data) {
                    $('#grid tbody').html('<tr><td>' + data.id_user + "</td><td>" + data.kddept + "</td><td>" + data.kdunit
                            + "</td><td>" + data.kdsatker + "</td><td>" + data.nmsatker + "</td><td>" + data.nmakses +
                            "</td><td>" + data.username + "</td></tr>");
                });
            }, 'json');
        } else {
            $.post('controller/cont.blokir.php', {aksi: 'cari', filter: 'nmsatker', kata: $('input#cari').val()}, function(data) {
                if (Object.keys(data).length > 4) {
                    //alert(data.nmsatker);
                    if (Object(data).length > 1) {
                        $.each(data, function(index, data) {
                            $('#grid tbody').html('<tr><td>' + data.id_user + "</td><td>" + data.kddept + "</td><td>" + data.kdunit
                                    + "</td><td>" + data.kdsatker + "</td><td>" + data.nmsatker + "</td><td>" + data.nmakses +
                                    "</td><td>" + data.username + "</td></tr>");
                        });
                    }else {
                        $('#grid tbody').html('<tr><td>' + data.id_user + "</td><td>" + data.kddept + "</td><td>" + data.kdunit
                                    + "</td><td>" + data.kdsatker + "</td><td>" + data.nmsatker + "</td><td>" + data.nmakses +
                                    "</td><td>" + data.username + "</td></tr>");
                    }
                }
            }, 'json');
        }

    });
    $('tr').addClass('clickable').click(function() {
        alert('hilite');
    });
});
