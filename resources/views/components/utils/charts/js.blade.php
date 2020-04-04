{{-- Chart Creation --}}
<script>

    function generateChart(
        apiUrl,
        modelClass,
        canvaId,
        canvaTitle,
        firstDate = null,
        lastDate = null,
        stepDate = '1 day',
        color = null,
        appendToTotal = null)
    {
        $.ajax({
            url : apiUrl,
            type : 'GET',
            dataType : 'json',
            data: { class: modelClass, firstDate: firstDate, lastDate: lastDate, stepDate: stepDate },
            success : function(data){
                console.log(data);
                values = [];
                dates = [];

                $.each(data, function(index, value){
                    if (undefined !== value.value && undefined !== value.date) {
                        values.push(value.value);
                        dates.push(value.date);
                    }
                })

                $('h4.' + canvaId).text(data.total + appendToTotal);
                $('p.' + canvaId).text(canvaTitle);
                createChart(values, dates, canvaId, canvaTitle, color)
            },
            error : function(data, status, error){
                console.error("Une erreur est survenu lors de l'appel AJAX : " + error);
            }
        });
    }

    function createChart(values, dates, canvaId, title, color = '#9561e2')
    {
        // Correct color if null
        color = null === color ? '#9561e2' : color;
        var timeFormat = 'MM/DD/YYYY HH:mm'

        var canva = document.getElementById(canvaId).getContext('2d');
        var chart = new Chart(canva, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: title,
                data: values,
                fill: false,
                borderColor: color
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        parser: timeFormat,
                        tooltipFormat: 'DD/MM HH:MM'
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Date'
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }]
            },
            legend: {
                display: false,
            }
        }
        });
    }
</script>
