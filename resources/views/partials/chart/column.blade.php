<div class="charts">
    <h4 class="chart_css">
    </h4>
    <p></p>
    <div id="ColumnChart"
        style="height: 50vh; max-width: 1200px; margin: auto; display: flex; align-items: center; justify-content: center;">
    </div>
</div>
<script>
    var seriesOptions = {!! json_encode($column_data) !!};

    var columnChart = Highcharts.chart('ColumnChart', {      
        chart: {
            backgroundColor: 'rgba(63, 63, 63, 0)', 
                type: 'column',
            },
            exporting: {
                enabled: false  
            },
            legend: {
                enabled: true,
                itemStyle: {
                    color: '#ffffff'
                }
            },
            title: {
                text: '網路聲量圖',
                style: {
                        color: '#ffffff'
                    }
            },
            xAxis: {
                labels: {
                    style: {
                        color: '#ffffff'
                    }
                },
                categories: seriesOptions[0].data.map(point => point[0])
            },
            yAxis: {
                title: {
                    text: ''
                },
                labels: {
                    style: {
                        color: '#ffffff'
                    }
                }
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                column: {
                    borderRadius: '15%'
                },
                series: {
                    borderWidth: 0,
                }
            },
        series: seriesOptions
    });
</script>
