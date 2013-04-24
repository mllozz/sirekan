$(document).ready(function() {

    $.getJSON('controller/cont.monitoring.php?user_pie', function(data) {
        var det = [
            {label: "Aktif", data: data.aktif, color: 'green'},
            {label: "Terblokir", data: data.blokir, color: 'red'}
        ];
        drawPieUser('#div1','User Aktif dan Terblokir', det);
    });



});

function drawPieUser(divnya,judul, data) {

    var placeholder = $(divnya);

    placeholder.unbind();

    $("#title").text(judul);

    $.plot(placeholder, data, {
        series: {
            pie: {
                show: true,
                radius: 1,
                label: {
                    show: true,
                    radius: 1 / 2,
                    formatter: labelFormatter,
                    background: {
                        opacity: 0.5
                    }
                }
            }
        },
        legend: {
            show: true
        },
        grid: {
            hoverable: true
        }
    });
}

function labelFormatter(label, series) {
    return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + 
            Math.round(series.percent) + "% (" + series.data[0][1] + " user)</div>";
}
