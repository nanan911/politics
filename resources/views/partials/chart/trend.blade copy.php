<div class="charts">
    <h4 class="chart_css">
    </h4>
    <p></p>
    <div id="TrendCharts"
        style="height: 50vh; max-width: 1200px; margin: auto; display: flex; align-items: center; justify-content: center;">
    </div>
</div>

<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="js/highcharts.js"></script>

<script>
    var seriesOptions = {!! json_encode($trend_data) !!};
    var TrendCharts = Highcharts.stockChart('TrendCharts', {
        rangeSelector: {
            selected: 4
        },
        chart: {
                backgroundColor: '#3f3f3f',
                height: 263
            },
            title: {
                text: '熱門趨勢圖' ,                
                style: {
                        color: '#ffffff'
                    }
            },
            subtitle: {
                text: '單位:(篇)',
                align: 'left',
                style: {
                        color: '#9fa3a0'
                    }
            },
            yAxis: {
                title: {
                    text: '',
                    style: {
                        color: '#fff'
                    }
                },
                labels: {
                    style: {
                        color: '#ffffff'
                    }
                },
                tickInterval: 50000
            },
            legend: {
                enabled: false 
            },
        xAxis: {
            type: 'datetime',
            labels: {
                style: {
                    fontSize: '16px',
                }
            },
            dateTimeLabelFormats: {
                day: '%Y-%m-%d',
                week: '%Y-%m-%d',
                month: '%Y-%m',
                year: '%Y'
            },
            title: {
              
            }
        },
        yAxis: {
            plotLines: [{
                value: 0,
                width: 2,
                color: 'silver'
            }]
        },
        plotOptions: {
            series: {
                showInNavigator: true
            }
        },
        
        series: seriesOptions
    });
</script>


