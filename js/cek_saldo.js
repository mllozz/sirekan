$(document).ready(function() {
    $.getJSON('controller/cont.ceksaldo.php?data', function(data) {
        $('#kdsatker').html(data.kdsatker).show(); 
        $('#nmsatker').html(data.nmsatker).show();
    });
});


