$(document).ready(function() {
    $.ajax({
        type: "GET",
        url: '/api/users/retention-chart',
        success: function (response) {
            Highcharts.chart('container', response);
        },
        dataType: 'json'
    });
});
