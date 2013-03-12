$(document).ready(function() {

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

    $.getJSON('controller/cont.blokir.php', function(data) {

        $.each(data, function(index, data) {
            $('#grid tbody').append('<tr><td>' + data.id_user + "</td><td>" + data.kddept + "</td><td>" + data.kdunit
                    + "</td><td>" + data.kdsatker + "</td><td>" + data.nmsatker + "</td><td>" + data.nmakses +
                    "</td><td>" + data.username + "</td></tr>");
        });
    });
    $('input#cari').keyup(function() {
        $.post('controller/cont.blokir.php', {aksi: 'cari', kata: $('input#cari').val()}, function(data) {

            $.each(data, function(index, data) {
                $('#grid tbody').html('<tr><td>' + data.id_user + "</td><td>" + data.kddept + "</td><td>" + data.kdunit
                        + "</td><td>" + data.kdsatker + "</td><td>" + data.nmsatker + "</td><td>" + data.nmakses +
                        "</td><td>" + data.username + "</td></tr>");
            });
        }, 'json');
    });
    $('tr').addClass('clickable').click(function () {
        alert('hilite');
    });
});
