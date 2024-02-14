<div class="charts">
    <h4 class="chart_css">
        <b><i class="fa-regular fa-comments"></i>{{ $title }}</b>
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
                // compare: 'percent',
                showInNavigator: true
            }
        },
        tooltip: {
            dateTimeLabelFormats: {
                day: '%Y-%m-%d',
                week: '%Y-%m-%d',
                month: '%Y-%m',
                year: '%Y'
            },
            valueSuffix: "篇",
            style: {
                fontSize: "16px",
            },
        },
        series: seriesOptions
    });
</script>
