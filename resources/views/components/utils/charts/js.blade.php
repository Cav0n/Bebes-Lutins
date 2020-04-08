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
        appendToTotal = null,
        type = 'line',
        color = undefined,
        fill = false)
    {
        $.ajax({
            url : apiUrl,
            type : 'GET',
            dataType : 'json',
            data: { class: modelClass, firstDate: firstDate, lastDate: lastDate, stepDate: stepDate },
            success : function(data){
                values = [];
                dates = [];
                data.max ? stepSize = Math.round(data.max / 5) : stepSize = null;

                $.each(data, function(index, value){
                    if (undefined !== value.value && undefined !== value.date) {
                        values.push(value.value);
                        dates.push(value.date);
                    }
                })

                $('h4.' + canvaId).text(data.total + appendToTotal);
                $('p.' + canvaId).text(canvaTitle);
                createChart(values, dates, canvaId, canvaTitle, stepSize, type, color, fill)
            },
            error : function(data, status, error){
                console.error("Une erreur est survenu lors de l'appel AJAX : " + error);
            }
        });
    }

    function createChart(values, dates, canvaId, title, stepSize = 1, type = 'line', color = '#9561e2', fill = false)
    {
        var timeFormat = 'MM/DD/YYYY HH:mm'

        var canva = document.getElementById(canvaId).getContext('2d');
        var chart = new Chart(canva, {
        type: type,
        data: {
            labels: dates,
            datasets: [{
                label: title,
                data: values,
                fill: fill,
                borderColor: color,
                backgroundColor: color
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        parser: timeFormat,
                        tooltipFormat: 'DD/MM',
                        displayFormats: {
                            day: 'DD / MM'
                        }
                    },
                    scaleLabel: {
                        display: false,
                        labelString: 'Date'
                    }
                }],
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: stepSize
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
