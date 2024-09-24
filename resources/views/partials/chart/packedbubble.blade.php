<div class="charts">
    <h4 class="chart_css"></h4>
    <p></p>
    <div id="PackedBubble"
        style="height: 50vh; max-width: 1200px; margin: auto; display: flex; align-items: center; justify-content: center;">
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/module-name.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script>
    var seriesOptions = {!! json_encode($packedbubble_data) !!};
    var PackedBubble = Highcharts.chart('PackedBubble', {
        chart: {
            backgroundColor: 'rgba(63, 63, 63, 0)', 
            type: 'packedbubble',
        },
        title: {
            text: '熱門關鍵字',
            style: {
                fontFamily: '微軟正黑體, Microsoft JhengHei, Arial, sans-serif',
                color: '#ffffff'
            }
        },
        legend: {
            enabled: true,
            itemStyle: {
                color: '#ffffff'
            } 
        },
        tooltip: {
            useHTML: true,
            pointFormat: '<b>{point.name}:</b> {point.value}'
        },
        plotOptions: {
            packedbubble: {
                minSize: '1%',
                maxSize: '100%',
                zMin: 0,
                zMax: 4000,
                layoutAlgorithm: {
                    splitSeries: false,
                    gravitationalConstant: 0.02
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.name}',
                    style: {
                        color: 'black',
                        textOutline: 'none',
                        fontWeight: 'normal',
                        color: '#ffffff', // 文字顏色
                    }
                },
                marker: {
                    fillOpacity: 1 // 不透明度設為1
                }
            }
        },exporting: {
                enabled: false  
            },
            series: [{
                name: '政治',
                data: seriesOptions
            }]
    
    });
</script>

</body>
</html>
