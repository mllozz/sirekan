$(document).ready(function() {
    $("input[type=text]").keyup(function() {
        var val = $(this).attr('value');
        var field = $(this).attr('name');
        if (field === 'kddept') {
            $.getJSON('controller/cont.rekam.php', {kddept: val,cek:true}, function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $('input#' + field).next('#kddept').fadeIn(1000).text(data.nmdept);
                    } else {
                        $('input#' + field).next('#kddept').fadeIn(1000).text('Tidak ADA');
                    }
                });
            });
            //$('input#'+field ).next('#kddept').fadeIn(1000).text(val);
        }
        if (field === 'kdunit') {
            $.getJSON('controller/cont.rekam.php', {kdunit: val,cek:true}, function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $('input#' + field).next('#kdunit').fadeIn(1000).text(data.nmunit);
                    } else {
                        $('input#' + field).next('#kdunit').fadeIn(1000).text('Tidak Ada');
                    }
                });
            });
        }
        if (field === 'kdsatker') {
            $.getJSON('controller/cont.rekam.php', {kdsatker: val,cek:true}, function(data) {
                $.each(data, function() {
                    if (data.msg === 'ok') {
                        $('input#' + field).next('#kdsatker').fadeIn(1000).text(data.nmsatker);
                    } else {
                        $('input#' + field).next('#kdsatker').fadeIn(1000).text('Tidak Ada');
                    }
                });
            });
        }
        //$('div#'+field ).html(val).show();
    });
});

